<?php
include '../configuracion.php';

$persona = new ControlPersona();

$personas = $persona->buscar([null]); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Personas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estructura/css/estilos.css">
</head>
<body>
<?php include_once('estructura/encabezado.php') ?>
    <div class="container mt-4">
        <h2>Lista de Personas</h2>
        <?php if (count($personas) > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha de nacimiento</th>
                        <th>Telefono</th>
                        <th>Domicilio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($personas as $persona): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($persona->getNroDni()); ?></td>
                            <td><?php echo htmlspecialchars($persona->getNombre()); ?></td>
                            <td><?php echo htmlspecialchars($persona->getApellido()); ?></td>
                            <td><?php echo htmlspecialchars($persona->getFechaNac()); ?></td>
                            <td><?php echo htmlspecialchars($persona->getTelefono()); ?></td>
                            <td><?php echo htmlspecialchars($persona->getDomicilio()); ?></td>
                            <td>
                                <a href="autosPersonas.php?dni=<?php echo urlencode($persona->getNroDni()); ?>" class="btn btn-primary">Ver Autos</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                No hay personas cargadas en el sistema.
            </div>
        <?php endif; ?>
    </div>
    <?php include_once('estructura/pieDePagina.php') ?>
</body>
</html>
