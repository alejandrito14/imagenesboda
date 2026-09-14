<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '0');
require_once '../../clases/class.Sesion.php';
$session = new Sesion();

function import_response(int $status, array $payload): never
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!isset($_SESSION['se_SAS'])) import_response(401, ['success' => false, 'message' => 'La sesión terminó.']);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') import_response(405, ['success' => false, 'message' => 'Método no permitido.']);
if (!isset($_FILES['guest_file']) || $_FILES['guest_file']['error'] !== UPLOAD_ERR_OK) import_response(422, ['success' => false, 'message' => 'Selecciona un archivo de Excel o CSV.']);
if ((int) $_FILES['guest_file']['size'] > 5 * 1024 * 1024) import_response(422, ['success' => false, 'message' => 'El archivo no debe superar 5 MB.']);

require_once dirname(__DIR__, 3) . '/includes/database.php';

function import_column_index(string $reference): int
{
    preg_match('/^[A-Z]+/i', $reference, $match);
    $letters = strtoupper($match[0] ?? 'A');
    $index = 0;
    foreach (str_split($letters) as $letter) $index = $index * 26 + ord($letter) - 64;
    return max(0, $index - 1);
}

function import_xlsx_rows(string $filename): array
{
    $zip = new ZipArchive();
    if ($zip->open($filename) !== true) throw new RuntimeException('No se pudo abrir el archivo XLSX.');

    $sharedStrings = [];
    $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
    if ($sharedXml !== false) {
        $xml = simplexml_load_string($sharedXml);
        if ($xml) foreach ($xml->si as $item) {
            $text = (string) $item->t;
            if ($text === '' && isset($item->r)) foreach ($item->r as $run) $text .= (string) $run->t;
            $sharedStrings[] = $text;
        }
    }

    $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
    if ($sheetXml === false) {
        $zip->close();
        throw new RuntimeException('El libro no contiene una primera hoja válida.');
    }
    $sheet = simplexml_load_string($sheetXml);
    $rows = [];
    if ($sheet) foreach ($sheet->sheetData->row as $xmlRow) {
        $row = [];
        foreach ($xmlRow->c as $cell) {
            $index = import_column_index((string) $cell['r']);
            $type = (string) $cell['t'];
            if ($type === 's') {
                $value = $sharedStrings[(int) $cell->v] ?? '';
            } elseif ($type === 'inlineStr') {
                $value = (string) $cell->is->t;
                if ($value === '' && isset($cell->is->r)) foreach ($cell->is->r as $run) $value .= (string) $run->t;
            } else {
                $value = (string) $cell->v;
            }
            $row[$index] = trim($value);
        }
        if ($row) {
            $max = max(array_keys($row));
            $rows[] = array_replace(array_fill(0, $max + 1, ''), $row);
        }
    }
    $zip->close();
    return $rows;
}

function import_csv_rows(string $filename): array
{
    $handle = fopen($filename, 'rb');
    if (!$handle) throw new RuntimeException('No se pudo leer el archivo CSV.');
    $firstLine = fgets($handle);
    rewind($handle);
    $delimiter = substr_count((string) $firstLine, ';') > substr_count((string) $firstLine, ',') ? ';' : ',';
    $rows = [];
    while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
        $row = array_map(static fn($value) => trim((string) $value), $row);
        if ($rows === [] && isset($row[0])) $row[0] = preg_replace('/^\xEF\xBB\xBF/', '', $row[0]);
        if (array_filter($row, static fn($value) => $value !== '')) $rows[] = $row;
    }
    fclose($handle);
    return $rows;
}

function import_header_key(string $value): string
{
    $value = mb_strtolower(trim($value));
    $value = strtr($value, ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ü'=>'u','ñ'=>'n']);
    return preg_replace('/[^a-z0-9]+/', '_', $value);
}

function import_generated_code(mysqli $db, string $prefix): string
{
    do {
        $code = $prefix . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
        $statement = $db->prepare('SELECT id FROM invitation_guests WHERE invitation_code = ? LIMIT 1');
        $statement->bind_param('s', $code);
        $statement->execute();
        $exists = $statement->get_result()->num_rows > 0;
    } while ($exists);
    return $code;
}

try {
    $extension = strtolower(pathinfo($_FILES['guest_file']['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, ['xlsx', 'csv'], true)) throw new RuntimeException('Formato no permitido. Utiliza .xlsx o .csv.');
    $rows = $extension === 'xlsx' ? import_xlsx_rows($_FILES['guest_file']['tmp_name']) : import_csv_rows($_FILES['guest_file']['tmp_name']);
    if (count($rows) < 2) throw new RuntimeException('El archivo no contiene invitados para importar.');

    $headers = array_map('import_header_key', array_shift($rows));
    $aliases = [
        'nombre' => ['nombre', 'nombres', 'nombre_del_invitado'],
        'apellidos' => ['apellidos', 'apellido'],
        'telefono' => ['telefono', 'whatsapp', 'celular'],
        'personas' => ['personas', 'numero_personas', 'cantidad'],
        'codigo' => ['codigo', 'codigo_invitacion'],
        'informacion' => ['informacion', 'informacion_del_pase', 'pase'],
    ];
    $columns = [];
    foreach ($aliases as $key => $names) foreach ($names as $name) {
        $position = array_search($name, $headers, true);
        if ($position !== false) { $columns[$key] = $position; break; }
    }
    if (!isset($columns['nombre'], $columns['apellidos'])) throw new RuntimeException('La plantilla debe incluir las columnas Nombre y Apellidos.');

    $db = boda_db();
    $settings = $db->query('SELECT event_type FROM invitation_settings WHERE id=1')->fetch_assoc() ?: [];
    $prefix = match ($settings['event_type'] ?? 'wedding') { 'quince' => 'XV', 'birthday' => 'CUMPLE', default => 'BODA' };
    $db->begin_transaction();
    $inserted = 0; $updated = 0; $skipped = 0; $errors = []; $seenCodes = [];

    foreach ($rows as $offset => $row) {
        $line = $offset + 2;
        $value = static fn(string $key) => trim((string) ($row[$columns[$key] ?? -1] ?? ''));
        $name = $value('nombre');
        $lastName = $value('apellidos');
        if ($name === '' || $lastName === '') { $skipped++; $errors[] = "Fila {$line}: faltan Nombre o Apellidos."; continue; }
        $phone = preg_replace('/\D+/', '', $value('telefono')) ?: null;
        $people = max(1, min(100, (int) ($value('personas') ?: 1)));
        $code = mb_strtoupper($value('codigo'));
        if ($code === '') $code = import_generated_code($db, $prefix);
        if (!preg_match('/^[A-Z0-9_-]{3,50}$/', $code)) { $skipped++; $errors[] = "Fila {$line}: el código sólo puede contener letras, números, guion y guion bajo."; continue; }
        if (isset($seenCodes[$code])) { $skipped++; $errors[] = "Fila {$line}: el código {$code} está repetido en el archivo."; continue; }
        $seenCodes[$code] = true;
        $information = $value('informacion');

        $lookup = $db->prepare('SELECT id FROM invitation_guests WHERE invitation_code = ? LIMIT 1');
        $lookup->bind_param('s', $code);
        $lookup->execute();
        $existing = $lookup->get_result()->fetch_assoc();
        if ($existing) {
            $statement = $db->prepare('UPDATE invitation_guests SET last_name=?,guest_name=?,phone=?,guest_count=?,pass_information=? WHERE id=?');
            $statement->bind_param('sssisi', $lastName, $name, $phone, $people, $information, $existing['id']);
            $statement->execute();
            $updated++;
        } else {
            $statement = $db->prepare('INSERT INTO invitation_guests (invitation_id,invitation_code,last_name,guest_name,phone,guest_count,pass_information) VALUES (1,?,?,?,?,?,?)');
            $statement->bind_param('ssssis', $code, $lastName, $name, $phone, $people, $information);
            $statement->execute();
            $inserted++;
        }
    }
    $db->commit();
    import_response(200, ['success' => true, 'message' => "Importación terminada: {$inserted} nuevos, {$updated} actualizados y {$skipped} omitidos.", 'inserted' => $inserted, 'updated' => $updated, 'skipped' => $skipped, 'errors' => array_slice($errors, 0, 20)]);
} catch (Throwable $exception) {
    if (isset($db)) $db->rollback();
    import_response(422, ['success' => false, 'message' => $exception->getMessage()]);
}

