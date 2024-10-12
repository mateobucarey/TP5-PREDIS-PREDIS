<?php

function darDatosSubmitted() {
    $datos = [];
    foreach($_GET as $key => $value){
        $datos[$key] = $value;
    }
    foreach($_POST as $key => $value){
        $datos[$key] = $value;
    }
    // Obtener archivos de $_FILES
    foreach ($_FILES as $key => $file) {
        $datos[$key] = $file; 
    }
    return $datos;
}

function verEstructura($e){
    echo "<pre>";
    print_r($e);
    echo "</pre>"; 
}

// autoload para version 8.0
spl_autoload_register(function($class_name) {
    $directorys = array(
        //Cambie los root, puse todo en minusculas
        $_SESSION['ROOT'].'modelo/',
        $_SESSION['ROOT'].'modelo/conector/',
        $_SESSION['ROOT'].'control/',
        //  $GLOBALS['ROOT'].'util/class/',
    );

    $i = 0;
    $total_directories = count($directorys);

    // Usamos un while para recorrer el array $directorys
    while ($i < $total_directories) {
        $directory = $directorys[$i];
        if (file_exists($directory . $class_name . '.php')) {
            // echo "se incluyó " . $directory . $class_name . '.php';
            require_once($directory . $class_name . '.php');
            break;  // Termina si encuentra el archivo
        }
        $i++;
    }
    return;
});
