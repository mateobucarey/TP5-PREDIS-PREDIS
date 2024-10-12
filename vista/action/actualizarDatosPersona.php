<?php
include_once '../../configuracion.php';

$datos = darDatosSubmitted();

if (isset($datos['nroDni']) && isset($datos['nombre']) && isset($datos['apellido']) && isset($datos['fechaNac']) && isset($datos['telefono']) && isset($datos['domicilio'])) {
    $nroDni = $datos['nroDni'];
    $nombre = $datos['nombre'];
    $apellido = $datos['apellido'];
    $fechaNac = $datos['fechaNac'];
    $telefono = $datos['telefono'];
    $domicilio = $datos['domicilio'];

    $controlPersona = new ControlPersona();
    $paramPersonaModificada = [
        'nroDni' => $nroDni,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'fechaNac' => $fechaNac,
        'telefono' => $telefono,
        'domicilio' => $domicilio
    ];

    $exito = $controlPersona->modificacion($paramPersonaModificada);

    if ($exito) {
        $mensaje = "Los datos de la persona con documento $nroDni se han actualizado exitosamente.";
    } else {
        $mensaje = "Hubo un error al intentar actualizar los datos de la persona.";
    }
} else {
    $mensaje = "Faltan datos obligatorios para actualizar la persona.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado Actualización</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estructura/css/estilos.css">
    <script src="../estructura/js/validacionCampos.js"></script>
</head>
<body>
<?php include_once('../estructura/encabezadoAction.php') ?>
    <div class="container mt-4">
        <div class="alert <?php echo isset($exito) && $exito ? 'alert-success' : 'alert-danger'; ?>" role="alert">
            <?php echo $mensaje; ?>
        </div>
        <a href="../buscarPersona.php" class="btn btn-primary">Volver</a>
    </div>
    <?php include_once('../estructura/pieDePagina.php') ?>
</body>
</html>
