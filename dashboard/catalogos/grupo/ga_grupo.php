<?php
/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once "../../clases/class.Sesion.php";
//creamos nuestra sesion.
$se = new Sesion();

if (!isset($_SESSION['se_SAS'])) {
    /*header("Location: ../../login.php"); */echo "login";

    exit;
}

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos las clases que vamos a utilizar
require_once "../../clases/conexcion.php";
require_once "../../clases/class.Grupos.php";
require_once "../../clases/class.Opcion.php";

require_once "../../clases/class.Funciones.php";
require_once '../../clases/class.MovimientoBitacora.php';

try
{
    //declaramos los objetos de clase
    $db     = new MySQL();
    $grupos = new Grupos();
    $f      = new Funciones();
    $md     = new MovimientoBitacora();

    //enviamos la conexión a las clases que lo requieren
    $grupos->db = $db;
    $md->db     = $db;

    $db->begin();

    //Recbimos parametros
    $grupos->idgrupos    = trim($_POST['id']);
    $grupos->nombregrupo = trim($f->guardar_cadena_utf8($_POST['nombregrupo']));
    $grupos->descripcion = trim($f->guardar_cadena_utf8($_POST['descripcion']));
    $grupos->sinprecio   = trim($f->guardar_cadena_utf8($_POST['costoadicional']));
    $grupos->multiple    = trim($f->guardar_cadena_utf8($_POST['seleccionmultiple']));
    $grupos->estatus     = trim($f->guardar_cadena_utf8($_POST['v_estatus']));
    $grupos->obligatorio = $_POST['obligatorio'];

    $tope = $_POST['tope'];

    if ($tope == '') {
        # code...
        $tope = 0;
    }

    $grupos->tope = $tope;

    $opciones  = explode(',', $_POST['opcion']);
    $costos    = explode(',', $_POST['costo']);
    $idsopcion = explode(',', $_POST['ids']);
    //Validamos si hacermos un insert o un update
    if ($grupos->idgrupos == 0) {
        //guardando
        $grupos->Guardargrupos();

        for ($i = 0; $i < count($opciones); $i++) {

            $opcion     = new Opcion();
            $opcion->db = $db;

            $opcion->opcion = $opciones[$i];

            if ($costos[$i] == '') {
                $costos[$i] = 0;
            }
            $opcion->costo         = $costos[$i];
            $opcion->idgrupo       = $grupos->idgrupos;
            $opcion->idgrupoopcion = $idsopcion[$i];

            $opcion->Guardaropcion();
            //}

        }

        $md->guardarMovimiento($f->guardar_cadena_utf8('grupos'), 'grupos', $f->guardar_cadena_utf8('Nuevo grupos creado con el ID-' . $grupos->idgrupos));
    } else {
        $grupos->Modificargrupos();
        $grupos->EliminarOpciones();

        for ($i = 0; $i < count($opciones); $i++) {

            $opcion     = new Opcion();
            $opcion->db = $db;

            $opcion->opcion = $opciones[$i];

            if ($costos[$i] == '') {
                $costos[$i] = 0;
            }
            $opcion->costo         = $costos[$i];
            $opcion->idgrupo       = $grupos->idgrupos;
            $opcion->idgrupoopcion = $idsopcion[$i];

            if ($opcion->idgrupoopcion != 0) {
                $opcion->Guardaropcion2();

            } else {

                $opcion->Guardaropcion();

            }

        }

        $md->guardarMovimiento($f->guardar_cadena_utf8('grupos'), 'grupos', $f->guardar_cadena_utf8('Modificación de grupos -' . $grupos->idgrupos));
    }

    $db->commit();
    echo "1|" . $grupos->idgrupos;

} catch (Exception $e) {
    $db->rollback();
    echo "Error. " . $e;
}
