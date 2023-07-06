<?php
include "src/php/Funciones/Peliculas.php";

$peliculas = obtenerPeliculas();
if (!empty($peliculas)) {

    echo '<div class="container">';
    echo '<h1 class="text-center my-4">Cartelera de películas</h1>';
    echo '<div class="row">';

    foreach ($peliculas as $pelicula) {
        $titulo = $pelicula['NOMBRE_PELICULA'];
        $duracion = $pelicula['DURACION'];
        $imagenBase64 = $pelicula['IMG'];
        echo '
        <div class="col-md-4">
            <div class="card p-0 h-100">
                <img src="data:image/jpeg;base64,' . $imagenBase64 . '" class="card-img-top" alt="Película">
                <div class="card-body">
                    <h5 class="card-title">' . $titulo . '</h5>
                    <p class="card-text"> Duración: ' . $duracion . '</p>
                    <a href="src/php/Secciones/ShowMovie.php?id=' . $pelicula['ID'] . '" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        </div>
        ';
    }
    echo '</div>';
    echo '</div>';
} else {
    echo 'No hay películas disponibles.';
}
