<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Auto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estructura/css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php include_once('estructura/encabezado.php') ?>
    <div class="container mt-4">
        <h2>Buscar Auto</h2>
        <form id="buscarAutoForm" action="action/accionBuscarAuto.php" method="post">
            <div class="form-group">
                <label for="patente">Número de Patente:</label>
                <input type="text" class="form-control" id="patente" name="patente" required maxlength="7">
                <div class="error-message" id="patenteError"></div>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>
    <?php include_once('estructura/pieDePagina.php') ?>

    <script>
        $(document).ready(function() {
            $('#buscarAutoForm').on('submit', function(event) {
                let valid = true;

                $('#patente').removeClass('is-invalid');
                $('#patenteError').text('');

                const patente = $('#patente').val();
                if (!/^[a-zA-Z0-9]+$/.test(patente) || patente.length > 7) {
                    $('#patente').addClass('is-invalid');
                    $('#patenteError').text('La patente no debe exceder los 7 caracteres.');
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
