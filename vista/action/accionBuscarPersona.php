<?php
include_once '../../configuracion.php';

$datos = darDatosSubmitted();

if (isset($datos['nroDni'])) {
    $nroDni = $datos['nroDni'];

    $controlPersona = new ControlPersona();
    $paramPersona = ['nroDni' => $nroDni];
    $personaArray = $controlPersona->buscar($paramPersona);

    if (count($personaArray) > 0) {

        $persona = $personaArray[0];
        $nombre = $persona->getNombre();
        $apellido = $persona->getApellido();
        $fechaNac = $persona->getFechaNac();
        $telefono = $persona->getTelefono();
        $domicilio = $persona->getDomicilio();
    } else {
        $mensaje = "No se encontró ninguna persona con el documento $nroDni.";
    }
} else {
    $mensaje = "No se ingresó un número de documento.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Datos Persona</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estructura/css/estilos.css">
    <script src="../estructura/js/validacionCampos.js"></script>
</head>
<body>
<?php include_once('../estructura/encabezadoAction.php') ?>
    <div class="container mt-4">
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-danger">
                <?php echo $mensaje; ?>
            </div>
            <a href="BuscarPersona.html" class="btn btn-primary">Volver</a>
        <?php else: ?>
            <h2>Modificar Datos de la Persona</h2>
            <form action="ActualizarDatosPersona.php" method="post">
                <div class="form-group">
                    <label for="nroDoc">Número de Documento</label>
                    <input type="text" name="nroDni" id="nroDni" class="form-control" value="<?php echo htmlspecialchars($nroDni); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre); ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" value="<?php echo htmlspecialchars($apellido); ?>" required>
                </div>
                <div class="form-group">
                    <label for="fechaNac">Fecha de Nacimiento</label>
                    <input type="date" name="fechaNac" id="fechaNac" class="form-control" value="<?php echo htmlspecialchars($fechaNac); ?>" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo htmlspecialchars($telefono); ?>" required>
                </div>
                <div class="form-group">
                    <label for="domicilio">Domicilio</label>
                    <input type="text" name="domicilio" id="domicilio" class="form-control" value="<?php echo htmlspecialchars($domicilio); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Datos</button>
            </form>
        <?php endif; ?>
    </div>
    <?php include_once('../estructura/pieDePagina.php') ?>
</body>
</html>
