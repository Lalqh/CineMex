<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalles de la película</title>
    <link rel="stylesheet" type="text/css" href="../../../css/StylesMovie.css">
    <link rel="stylesheet" href="../../../css/Styles.css">

</head>
<body>
<?php include "../Header.php"; ?>
<main>
<div class="container">
    <?php
    include "../../Funciones/Peliculas.php";

    if (isset($_GET['id'])) {
        $idPelicula = $_GET['id'];

        $pelicula = obtenerDetallesPelicula($idPelicula);

        if($pelicula){
            echo "<h1>" . $pelicula['NOMBRE_PELICULA'] . "</h1>";
            echo '<div class="movie-details">';
            echo '<img src="data:image/jpeg;base64,' . $pelicula['IMG'] . '" alt="' . $pelicula['NOMBRE_PELICULA'] . '" class="movie-image">';
            echo '<div class="movie-info">';
            echo '<h2 class="movie-title">' . $pelicula['NOMBRE_PELICULA'] . '</h2>';
            echo '<p class="movie-duration">Duración: ' . $pelicula['DURACION'] . '</p>';
            echo '<p class="movie-description">' . $pelicula['sinopsis'] . '</p>';
            echo '<a href="FromReservaBoletos.php?id=' . $pelicula['ID'] . '" class="btn btn-primary">Comprar Boletos</a>';
            echo '</div>';
            echo '</div>';
        }else {
            echo "La película no fue encontrada.";
        }
    } else {
        echo "ID de película no válido";
    }
    ?>
</div>
</main>

</body>

</html>

