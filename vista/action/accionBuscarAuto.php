<?php
include_once ('../../configuracion.php');

$datos = darDatosSubmitted();

$patente = isset($datos['patente']) ? $datos['patente'] : '';

$verAuto = new ControlAuto();

$autos = $verAuto->buscar(['patente' => $patente]);

if (count($autos) > 0) {
    $auto = $autos[0]; 
    $patente = $auto->getPatente();
    $marca = $auto->getMarca();
    $modelo = $auto->getModelo();
    $dniDuenio = $auto->getObjDuenio()->getNroDni();

    $verPersona = new ControlPersona();
    $personas = $verPersona->buscar(['nroDni' => $dniDuenio]);
    $nombreDuenio = 'No disponible'; 
    if (count($personas) > 0) {
        $persona = $personas[0];
        $nombreDuenio = $persona->getNombre() . ' ' . $persona->getApellido();
    }
} else {
    $mensaje = 'No se encontró ningún auto con la patente proporcionada.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de Búsqueda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estructura/css/estilos.css">
    <script src="../estructura/js/validacionCampos.js"></script>
</head>
<body>
<?php include_once('../estructura/encabezadoAction.php') ?>
    <div class="container mt-4">
        <h2>Resultado de Búsqueda</h2>
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-warning" role="alert">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Patente</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Dueño</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($patente); ?></td>
                        <td><?php echo htmlspecialchars($marca); ?></td>
                        <td><?php echo htmlspecialchars($modelo); ?></td>
                        <td><?php echo htmlspecialchars($nombreDuenio); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <a href="../buscarAuto.php" class="btn btn-primary">Volver</a>
    </div>
    <?php include_once('../estructura/pieDePagina.php') ?>
</body>
</html>
