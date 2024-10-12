<?php
include_once '../configuracion.php';

$controlAuto = new ControlAuto();
$controlPersona = new ControlPersona();
$autos = $controlAuto->buscar(null); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Autos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estructura/css/estilos.css">
</head>
<body>
    <?php include_once('estructura/encabezado.php') ?>
    
    <div class="container mt-5">
        <h1 class="mb-4">Listado de Autos</h1>
        
        <?php
        if (count($autos) > 0) {

            echo '<table class="table table-striped">';
            echo '<thead><tr><th>Patente</th><th>Marca</th><th>Modelo</th><th>Dueño</th></tr></thead>';
            echo '<tbody>';
            foreach ($autos as $auto) {
                $paramPersona = ['nroDni' => $auto->getObjDuenio()];
                $personaArray = $controlPersona->buscar($paramPersona);
                $nombreDueño = count($personaArray) > 0 
                    ? $personaArray[0]->getNombre() . ' ' . $personaArray[0]->getApellido() 
                    : 'Dueño no encontrado';
                echo '<tr>';
                echo '<td>' . $auto->getPatente() . '</td>';
                echo '<td>' . $auto->getMarca() . '</td>';
                echo '<td>' . $auto->getModelo() . '</td>';
                echo '<td>' . $nombreDueño . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<div class="alert alert-warning">No hay autos cargados en la base de datos.</div>';
        }
        ?>
    </div>
    
    <?php include_once('estructura/pieDePagina.php') ?>
</body>
</html>
