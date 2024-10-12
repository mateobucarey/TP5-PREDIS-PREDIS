<?php
session_start();  // Inicia la sesión al comienzo del archivo

header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate");

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO = 'phpMysql';

// Variable que almacena el directorio del proyecto
$ROOT = $_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";

// Incluye el archivo de funciones
include_once($ROOT.'util/funciones.php');

// Variable que define la página de autenticación del proyecto
$INICIO = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/vista/login/login.php";

// Variable que define la página principal del proyecto (menú principal)
$PRINCIPAL = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/principal.php";

// Asigna la variable de sesión ROOT
$_SESSION['ROOT'] = $ROOT;
?>
