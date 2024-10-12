<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambio de Dueño</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estructura/css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php include_once('estructura/encabezado.php') ?>
    <div class="container mt-4">
        <h2>Cambiar Dueño del Auto</h2>
        <form id="cambioDuenioForm" action="action/accionCambioDuenio.php" method="post">
            <div class="form-group">
                <label for="patente">Patente del Auto</label>
                <input type="text" name="patente" id="patente" class="form-control" required maxlength="7">
                <div class="error-message" id="patenteError"></div>
            </div>
            <div class="form-group">
                <label for="dniNuevoDuenio">DNI del Nuevo Dueño</label>
                <input type="text" name="dniNuevoDuenio" id="dniNuevoDuenio" class="form-control" required maxlength="8">
                <div class="error-message" id="dniNuevoDuenioError"></div>
            </div>
            <button type="submit" class="btn btn-primary">Cambiar Dueño</button>
        </form>
    </div>
    <?php include_once('estructura/pieDePagina.php') ?>

    <script>
        $(document).ready(function() {
            $('#cambioDuenioForm').on('submit', function(event) {
                let valid = true;

                $('#patente').removeClass('is-invalid');
                $('#dniNuevoDuenio').removeClass('is-invalid');
                $('#patenteError').text('');
                $('#dniNuevoDuenioError').text('');

                const patente = $('#patente').val();
                if (!/^[a-zA-Z0-9]+$/.test(patente) || patente.length > 7) {
                    $('#patente').addClass('is-invalid');
                    $('#patenteError').text('La patente es invalida.');
                    valid = false;
                }

                const dniNuevoDuenio = $('#dniNuevoDuenio').val();
                if (!/^\d+$/.test(dniNuevoDuenio) || dniNuevoDuenio.length > 12) {
                    $('#dniNuevoDuenio').addClass('is-invalid');
                    $('#dniNuevoDuenioError').text('El DNI es invalido.');
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
