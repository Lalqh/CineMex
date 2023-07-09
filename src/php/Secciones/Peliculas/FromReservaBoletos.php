<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalles de la película</title>
    <link rel="stylesheet" type="text/css" href="../../../css/StylesMovie.css">
    <link rel="stylesheet" href="../../../css/Styles.css">

    <link rel="stylesheet" href="../../../../fonts/fontawesome-free-6.4.0-web/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include "../Header.php"; ?>

<?php
include "../../Funciones/Peliculas.php";

session_start();

if (isset($_SESSION['idUsuario'])) {
    if (isset($_GET["id"])) {
        $idUsuario = $_SESSION['idUsuario'];
        $idPelicula = $_GET['id'];
        $asientos = obtenerAsientosDisponibles($idPelicula);

        if ($asientos) {
            echo '<div class="container">';
            echo '<h2 class="text-center my-4">Selecciona tus asientos</h2>';
            echo '<div class="row justify-content-center">';

            foreach ($asientos as $asiento) {
                $icono = 'fa-chair';
                $color = $asiento['ESTADO'] == 1 ? 'text-danger' : 'text-secondary';

                echo '<div class="col-md-2 mb-4">';
                echo '<div class="d-flex flex-column align-items-center">';
                echo '<i class="fas ' . $icono . ' fa-2x ' . $color . '"></i>';
                echo '<p class="mt-2">' . $asiento['ID'] . '</p>';
                if ($asiento['ESTADO'] == 0) {
                    echo '<input type="checkbox" name="asientos[]" value="' . $asiento['ID'] . '">';
                }
                echo '</div>';
                echo '</div>';
            }

            echo '</div>';
            echo '<div class="row justify-content-center mt-4">';
            echo '<div class="col-md-4">';
            echo '<label for="hora">Selecciona la hora:</label>';
            echo '<select name="hora" id="hora" class="form-select">';
            echo '<option value="10:00">10:00 AM</option>';
            echo '<option value="12:00">12:00 PM</option>';
            echo '<option value="15:00">3:00 PM</option>';
            echo '</select>';
            echo '</div>';
            echo '</div>';
            echo '<div class="row justify-content-center mt-4">';
            echo '<div class="col-md-4">';
            echo '<button type="button" id="reservarBtn" class="btn btn-primary">Reservar boletos</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div id="message" class="mt-3 p-3"></div>';
        } else {
            echo "No hay asientos disponibles para esta película.";
        }
    } else {
        echo "No se encontró el ID de la película.";
    }
} else {
    echo "Debes iniciar sesión para ver este contenido.";
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#reservarBtn').click(function() {
            let asientosSeleccionados = [];
            $('input[name="asientos[]"]:checked').each(function() {
                asientosSeleccionados.push($(this).val());
            });

            let horaSeleccionada = $('#hora').val();

            // Convertir el arreglo de asientos en una cadena separada por comas
            let asientosString = asientosSeleccionados.join(",");

            $.ajax({
                url: '../../Funciones/ReservaBoletos.php',
                method: 'POST',
                data: {
                    idUsuario: <?php echo $idUsuario; ?>,
                    idPelicula: <?php echo $idPelicula; ?>,
                    asientos: asientosString,
                    hora: horaSeleccionada
                },
                success: function(response) {
                    let resp = JSON.parse(response);

                    if (resp.respuesta === 'correcto'){
                        $('#message').html('<div class="alert alert-success">La reserva se completo correctamente.</div>');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }else{
                        $('#message').html('<div class="alert alert-danger">Ocurrio un error al hacer la reserva.</div>');

                    }

                },
                error: function(xhr, status, error) {
                    // Manejar el error de la solicitud AJAX
                    console.log(error);
                    alert('Error al procesar la reserva');
                }
            });
        });
    });
</script>
</body>
</html>
