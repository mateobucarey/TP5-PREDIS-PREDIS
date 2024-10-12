<?php
include '../configuracion.php';

$dni = isset($_GET['dni']) ? $_GET['dni'] : '';

if (empty($dni)) {

    $mensaje = 'No se proporcionó un DNI válido.';
} else {

    $controlPersona = new ControlPersona();
    $personas = $controlPersona->buscar(['nroDni' => $dni]);

    if (count($personas) > 0) {

        $persona = $personas[0];
        $nombre = $persona->getNombre();
        $apellido = $persona->getApellido();

        $controlAuto = new ControlAuto();
        $autos = $controlAuto->buscar(['dniDuenio' => $dni]);
    } else {

        $mensaje = 'No se encontró ninguna persona con el DNI proporcionado.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autos de Persona</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estructura/css/estilos.css">
</head>
<body>
<?php include_once('estructura/encabezado.php'); ?>
    <div class="container mt-4">
        <h2>Detalles de la Persona</h2>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-warning" role="alert">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php else: ?>
            <div class="mb-4">
                <h3><?php echo htmlspecialchars($nombre . ' ' . $apellido); ?></h3>
            </div>

            <h2>Autos Asociados</h2>

            <?php if (count($autos) > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Patente</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($autos as $auto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($auto->getPatente()); ?></td>
                                <td><?php echo htmlspecialchars($auto->getMarca()); ?></td>
                                <td><?php echo htmlspecialchars($auto->getModelo()); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info" role="alert">
                    Esta persona no tiene autos asociados.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <a href="listaPersonas.php" class="btn btn-primary">Volver a la lista de personas</a>
    </div>
    <?php include_once('estructura/pieDePagina.php'); ?>
</body>
</html>
