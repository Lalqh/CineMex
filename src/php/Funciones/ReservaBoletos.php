<?php
session_start();

if (isset($_SESSION['idUsuario'])) {
    include 'DataBase.php';

    $idUsuario = $_SESSION['idUsuario'];

    if (isset($_POST["asientos"]) && isset($_POST["hora"]) && isset($_POST["idUsuario"]) && isset($_POST["idPelicula"])) {
        $asientosSeleccionados = $_POST["asientos"];
        $horaSeleccionada = $_POST["hora"];
        $idUsuario = $_POST["idUsuario"];
        $idPelicula = $_POST["idPelicula"];

        // Procesar la reserva de los boletos
        $resultado = guardarReserva($idUsuario, $asientosSeleccionados, $horaSeleccionada, $idPelicula);

        // Verificar el resultado de la reserva
        if ($resultado) {
            // Reserva exitosa
            $respuesta = array(
                'respuesta' => 'correcto',
                'mensaje' => 'Reserva exitosa'
            );
        } else {
            // Error en la reserva
            $respuesta = array(
                'respuesta' => 'error',
                'mensaje' => 'Error al realizar la reserva'
            );
        }

        echo json_encode($respuesta);
    } else {
        // En caso de datos faltantes
        $respuesta = array(
            'respuesta' => 'error',
            'mensaje' => 'Datos incompletos'
        );
        echo json_encode($respuesta);
    }
} else {
    // En caso de usuario no autenticado
    $respuesta = array(
        'respuesta' => 'error',
        'mensaje' => 'Debes iniciar sesión para realizar la reserva'
    );
    echo json_encode($respuesta);
}

function guardarReserva($idUsuario, $asientosSeleccionados, $horaSeleccionada, $idPelicula)
{
    include "DataBase.php";

    // Insertar la reserva en la tabla de reservas
    $query = "INSERT INTO reserva (ID_USUARIO, ASIENTOS, HORA, ID_PELICULA) VALUES (?, ?, ?, ?)";
    $statement = $conexion->prepare($query);
    $statement->bind_param('issi', $idUsuario, $asientosSeleccionados, $horaSeleccionada, $idPelicula);
    $statement->execute();

    // Verificar si se realizó correctamente la inserción
    $resultado = $statement->affected_rows > 0;

    // Actualizar el estado de los asientos seleccionados en la tabla de asientos
    $asientos = explode(",", $asientosSeleccionados);
    foreach ($asientos as $asiento) {
        $queryUpdate = "UPDATE asiento SET ESTADO = 1 WHERE ID = ?";
        $statementUpdate = $conexion->prepare($queryUpdate);
        $statementUpdate->bind_param('i', $asiento);
        $statementUpdate->execute();
        $statementUpdate->close();
    }

    $statement->close();
    $conexion->close();

    return $resultado;
}
?>
