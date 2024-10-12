<?php
include_once '../../configuracion.php';

$datos = darDatosSubmitted();

if (isset($datos['patente']) && isset($datos['dniNuevoDuenio'])) {
    
    $patente = $datos['patente'];
    $dniNuevoDuenio = $datos['dniNuevoDuenio'];
    
    $controlAuto = new ControlAuto();
    $paramAuto = ['patente' => $patente];
    $autoArray = $controlAuto->buscar($paramAuto);
    
    if (count($autoArray) > 0) {

        $controlPersona = new ControlPersona();
        $paramPersona = ['nroDni' => $dniNuevoDuenio];
        $personaArray = $controlPersona->buscar($paramPersona);
        
        if (count($personaArray) > 0) {

            $paramAutoModificado = [
                'patente' => $patente,
                'marca' => $autoArray[0]->getMarca(),
                'modelo' => $autoArray[0]->getModelo(),
                'dniDuenio' => $dniNuevoDuenio
            ];
            
            $exito = $controlAuto->modificacion($paramAutoModificado);
            
            if ($exito) {
                $mensaje = "El dueño del auto con patente $patente ha sido cambiado exitosamente.";
            } else {
                $mensaje = "Hubo un error al intentar cambiar el dueño del auto.";
            }
        } else {

            $mensaje = "No se encontró ninguna persona registrada con el DNI $dniNuevoDuenio.";
        }
    } else {

        $mensaje = "No se encontró ningún auto registrado con la patente $patente.";
    }
} else {
    $mensaje = "Faltan datos obligatorios para realizar el cambio de dueño.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado Cambio de Dueño</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estructura/css/estilos.css">
    <script src="../estructura/js/validacionCampos.js"></script>
</head>
<body>
<?php include_once('../estructura/encabezadoAction.php') ?>
    <div class="container mt-4">
        <h2>Resultado</h2>
        <div class="alert <?php echo isset($exito) && $exito ? 'alert-success' : 'alert-danger'; ?>" role="alert">
            <?php echo $mensaje; ?>
        </div>
        <a href="../cambioDuenio.php" class="btn btn-primary">Volver</a>
    </div>
    <?php include_once('../estructura/pieDePagina.php') ?>
</body>
</html>
