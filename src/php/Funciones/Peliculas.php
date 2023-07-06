<?php
include "DataBase.php";
function obtenerPeliculas() {
    global $conexion;
    try {
        $consulta = "SELECT * FROM peliculas";
        $ps = $conexion->prepare($consulta);
        $ps->execute();
        $resultado = $ps->get_result();

        if ($resultado->num_rows > 0) {
            $peliculas = array();

            while ($fila = $resultado->fetch_assoc()) {
                $imagenBase64 = base64_encode($fila['IMG']);
                $fila['IMG'] = $imagenBase64;
                $peliculas[] = $fila;
            }

            return $peliculas;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo "Error en la consulta: " . $e->getMessage();
        return false;
    }
}
function obtenerDetallesPelicula($idPelicula) {
    global $conexion; // Asegúrate de tener acceso a la conexión a la base de datos

    try {
        // Consulta para obtener los detalles de la película usando el ID
        $consulta = "SELECT * FROM peliculas WHERE ID = ?";
        $ps = $conexion->prepare($consulta);
        $ps->bind_param("i", $idPelicula);
        $ps->execute();
        $resultado = $ps->get_result();

        if ($resultado->num_rows > 0) {
            $pelicula = $resultado->fetch_assoc();
            $imagenBase64 = base64_encode($pelicula['IMG']);
            $pelicula['IMG'] = $imagenBase64;
            return $pelicula;
        } else {
            return null;
        }
    } catch (Exception $e) {
        echo "Error en la consulta: " . $e->getMessage();
        return null;
    }
}
?>
