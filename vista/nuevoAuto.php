<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Auto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estructura/css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="estructura/js/validacionCampos.js"></script>
</head>
<body>
<?php include_once('estructura/encabezado.php') ?>
    <div class="container mt-4">
        <h2>Registrar Nuevo Auto</h2>
        <form id="autoForm" action="action/accionNuevoAuto.php" method="post">
            <div class="form-group">
                <label for="patente">Patente</label>
                <input type="text" name="patente" id="patente" class="form-control" required maxlength="10">
                <div class="error-message" id="patenteError"></div>
            </div>
            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" name="marca" id="marca" class="form-control" required maxlength="50">
                <div class="error-message" id="marcaError"></div>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="number" name="modelo" id="modelo" class="form-control" required maxlength="4">
                <div class="error-message" id="modeloError"></div>
            </div>
            <div class="form-group">
                <label for="dniDuenio">DNI del Dueño</label>
                <input type="text" name="dniDuenio" id="dniDuenio" class="form-control" required maxlength="8">
                <div class="error-message" id="dniDuenioError"></div>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Auto</button>
        </form>
    </div>
    <?php include_once('estructura/pieDePagina.php') ?>

    <script>
        $(document).ready(function() {
            $('#autoForm').on('submit', function(event) {
                let valid = true;
                
                $('.form-control').removeClass('is-invalid');
                $('.error-message').text('');

                const patente = $('#patente').val();
                if (patente === '' || patente.length > 7) {
                    $('#patente').addClass('is-invalid');
                    $('#patenteError').text('La patente es obligatoria y no debe exceder los 7 caracteres.');
                    valid = false;
                }

                const marca = $('#marca').val();
                if (marca === '' || marca.length > 50) {
                    $('#marca').addClass('is-invalid');
                    $('#marcaError').text('La marca es obligatoria y no debe exceder los 50 caracteres.');
                    valid = false;
                }

                const modelo = $('#modelo').val();
                if (!/^\d+$/.test(modelo) || modelo.length > 4) {
                    $('#modelo').addClass('is-invalid');
                    $('#modeloError').text('El modelo es invalido.');
                    valid = false;
                }

                const dniDuenio = $('#dniDuenio').val();
                if (!/^\d+$/.test(dniDuenio) || dniDuenio.length > 12) {
                    $('#dniDuenio').addClass('is-invalid');
                    $('#dniDuenioError').text('El DNI del dueño debe ser un número de máximo 12 dígitos.');
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
