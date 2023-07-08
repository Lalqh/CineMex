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

if(isset($_GET["id"])){
    $idPelicula = $_GET['id'];
    $asientos = obtenerAsientosDisponibles($idPelicula);

    if ($asientos) {
        echo '<div class="container">';
        echo '<h2 class="text-center my-4">Selecciona tus asientos</h2>';
        echo '<div class="row justify-content-center">';

        foreach ($asientos as $asiento) {
            $icono = $asiento['ESTADO'] == 0 ? 'fa-chair' : 'fa-chair-alt';
            $color = $asiento['ESTADO'] == 1 ? 'text-danger' : 'text-secondary';

            echo '<div class="col-md-2 mb-4">';
            echo '<div class="d-flex flex-column align-items-center">';
            echo '<i class="fas ' . $icono . ' fa-2x ' . $color . '"></i>';
            echo '<p class="mt-2">' . $asiento['ID'] . '</p>';
            echo '<input type="checkbox" name="asientos[]" value="' . $asiento['ID'] . '" ' . ($asiento['ESTADO'] ? 'disabled' : '') . '>';
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
        echo '<button type="submit" class="btn btn-primary">Reservar boletos</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo "No hay asientos disponibles para esta película.";
    }
} else {
    echo "No se encontró el ID de la película.";
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
