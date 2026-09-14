<?php
require_once '../../clases/class.Sesion.php';
$session = new Sesion();
if (!isset($_SESSION['se_SAS'])) { http_response_code(401); exit('La sesión terminó.'); }

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="plantilla_invitados.csv"');
echo "\xEF\xBB\xBF";
$output = fopen('php://output', 'wb');
fputcsv($output, ['Nombre', 'Apellidos', 'Telefono', 'Personas', 'Codigo', 'Informacion']);
fputcsv($output, ['Carlos', 'López', '521234567890', '2', 'BODA82', 'Pase válido para dos personas']);
fclose($output);

