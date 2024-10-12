<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Persona</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estructura/css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php include_once('estructura/encabezado.php') ?>
    <div class="container mt-4">
        <h2>Buscar Persona</h2>
        <form id="buscarPersonaForm" action="action/accionBuscarPersona.php" method="post">
            <div class="form-group">
                <label for="nroDni">Número de Documento</label>
                <input type="text" name="nroDni" id="nroDni" class="form-control" required maxlength="8">
                <div class="error-message" id="dniError"></div>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>
    <?php include_once('estructura/pieDePagina.php') ?>

    <script>
        $(document).ready(function() {
            $('#buscarPersonaForm').on('submit', function(event) {
                let valid = true;

                $('#nroDni').removeClass('is-invalid');
                $('#dniError').text('');

                const dni = $('#nroDni').val();
                if (!/^\d+$/.test(dni) || dni.length > 12) {
                    $('#nroDni').addClass('is-invalid');
                    $('#dniError').text('El DNI es invalido.');
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
