<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Persona</title>
    <link rel="stylesheet" href="estructura/css/estilos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="estructura/js/validacionCampos.js"></script>
</head>
<body>
<?php include_once('estructura/encabezado.php') ?>
    <div class="container mt-4">
        <h2>Nueva Persona</h2>
        <form id="personaForm" action="action/accionNuevaPersona.php" method="post">
            <div class="form-group">
                <label for="nroDni">DNI</label>
                <input type="text" name="nroDni" id="nroDni" class="form-control" required maxlength="8">
                <div class="error-message" id="dniError"></div>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required maxlength="50">
                <div class="error-message" id="nombreError"></div>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control" required maxlength="50">
                <div class="error-message" id="apellidoError"></div>
            </div>
            <div class="form-group">
                <label for="fechaNac">Fecha de Nacimiento</label>
                <input type="date" name="fechaNac" id="fechaNac" class="form-control" required>
                <div class="error-message" id="fechaNacError"></div>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control" required maxlength="10">
                <div class="error-message" id="telefonoError"></div>
            </div>
            <div class="form-group">
                <label for="domicilio">Domicilio</label>
                <input type="text" name="domicilio" id="domicilio" class="form-control" required maxlength="100">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Persona</button>
        </form>
    </div>
    <?php include_once('estructura/pieDePagina.php') ?>

    <script>
        $(document).ready(function() {
            $('#personaForm').on('submit', function(event) {
                let valid = true;

                $('.form-control').removeClass('is-invalid');
                $('.error-message').text('');

                const dni = $('#nroDni').val();
                if (!/^\d+$/.test(dni) || dni.length > 12) {
                    $('#nroDni').addClass('is-invalid');
                    $('#dniError').text('El DNI debe ser un número de máximo 12 dígitos.');
                    valid = false;
                }

                const nombre = $('#nombre').val();
                if (!/^[a-zA-Z\s]+$/.test(nombre) || nombre.length > 50) {
                    $('#nombre').addClass('is-invalid');
                    $('#nombreError').text('El nombre es obligatorio, solo puede contener letras y no debe exceder los 50 caracteres.');
                    valid = false;
                }

                const apellido = $('#apellido').val();
                if (!/^[a-zA-Z\s]+$/.test(apellido) || apellido.length > 50) {
                    $('#apellido').addClass('is-invalid');
                    $('#apellidoError').text('El apellido es obligatorio, solo puede contener letras y no debe exceder los 50 caracteres.');
                    valid = false;
                }

                const fechaNac = new Date($('#fechaNac').val());
                const fechaActual = new Date();
                const edad = fechaActual.getFullYear() - fechaNac.getFullYear();
                if (isNaN(fechaNac.getTime()) || edad > 100 || edad < 0) {
                    $('#fechaNac').addClass('is-invalid');
                    $('#fechaNacError').text('Debe ingresar una fecha de nacimiento válida.');
                    valid = false;
                }

                const telefono = $('#telefono').val();
                if (!/^\d+$/.test(telefono) || telefono.length > 10) {
                    $('#telefono').addClass('is-invalid');
                    $('#telefonoError').text('El teléfono debe ser un número valido.');
                    valid = false;
                }

                if (!valid) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
