<?php

include 'DataBase.php';

session_start();

$usuario = $_POST['email'];
$contra = $_POST['password'];

try {
    // Seleccionar los usuarios de la base de datos
    $ps = $conexion->prepare("SELECT NOMBRE, ID, CONTRASENA FROM usuarios WHERE CORREO = ?");
    $ps->bind_param('s', $usuario);
    $ps->execute();

    // Logear el usuario
    $ps->bind_result($name, $ID, $contraUsuario );
    $ps->fetch();

    // Verificar que el usuario existe y la contraseña es correcta
    if ($name) {
        // Verificar la contraseña del usuario
        if (password_verify($contra, $contraUsuario)) {
            // Crear la sesión con el ID del usuario
            $_SESSION['idUsuario'] = $ID;

            // Enviar respuesta con el rol y usuario encriptado
            $encriptar = urlencode(base64_encode($ID));
            $respuesta = array(
                'respuesta' => 'correcto',
                'usuario' => $encriptar
            );
        } else {
            // Contraseña incorrecta
            $respuesta = array(
                'respuesta' => 'error',
                 'msg' => 'error en la contraseña'
            );
        }
    } else {
        // Usuario no existe
        $respuesta = array(
            'respuesta' => 'error',
            'datos' => $usuario,
            'name' => $name
        );
    }

    $ps->close();
    $conexion->close();
} catch (Exception $e) {
    // Error en la consulta
    $respuesta = array(
        'err' => $e->getMessage()
    );
}

echo json_encode($respuesta);
