<?php
include_once '../../configuracion.php';

$datos = darDatosSubmitted();

if (isset($datos['nroDni']) && isset($datos['nombre']) && isset($datos['apellido']) && isset($datos['fechaNac']) && isset($datos['telefono']) && isset($datos['domicilio'])) {
    
    $param = [
        'nroDni' => $datos['nroDni'],
        'nombre' => $datos['nombre'],
        'apellido' => $datos['apellido'],
        'fechaNac' => $datos['fechaNac'],
        'telefono' => $datos['telefono'],
        'domicilio' => $datos['domicilio']
    ];
    
    $verPersona = new ControlPersona();
    
    $exito = $verPersona->alta($param);
    
    if ($exito) {
        $mensaje = "La persona fue cargada exitosamente.";
    } else {
        $mensaje = "Hubo un error al intentar cargar la persona.";
    }
} else {
    $mensaje = "Faltan datos obligatorios para poder cargar la persona.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado Nueva Persona</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estructura/css/estilos.css">
    <script src="../estructura/js/validacionCampos.js"></script>
</head>
<body>
<?php include_once('../estructura/encabezadoAction.php') ?>

    <div class="container mt-4">
        <h2>Resultado</h2>
        <div class="alert <?php echo $exito ? 'alert-success' : 'alert-danger'; ?>" role="alert">
            <?php echo $mensaje; ?>
        </div>
        <a href="../nuevaPersona.php" class="btn btn-primary">Volver</a>
    </div>
    <?php include_once('../estructura/pieDePagina.php') ?>
</body>
</html>
