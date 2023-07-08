<?php

include 'DataBase.php';

$nombre = $_POST['name'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$password = $_POST['password'];

//Opciones para la encriptacion
$opciones = array(
    'cost' => 10
);

//Encriptar la contraseña
$encriptar = password_hash($password, PASSWORD_BCRYPT, $opciones);

try{
    //Validar si ya existe ese usuario
    $ps = $conexion->prepare("select CORREO from usuarios where CORREO = ?");
    $ps->bind_param('s',$email);
    $ps->execute();

    //Obtener a el usuario
    $ps->bind_result($name_usuer);
    $ps->fetch();

    if($name_usuer){
        $respuesta = array(
            'respuesta' => 'registrado'
        );
    }else{
        //Preperar conexion
        $ps = $conexion->prepare("insert into usuarios(NOMBRE ,APELLIDOS ,CORREO, CONTRASENA) values (?,?,?,?)");
        $ps->bind_param('ssss',$nombre, $apellidos, $email ,$encriptar);
        $ps->execute();

        if($ps->affected_rows > 0){
            $respuesta = array(
                'respuesta' => 'correcto'
            );
        }
    }

    $ps->close();
    $conexion->close();

}catch (Exception $e){
    //En caso de algun error
    $respuesta = array(
        'err' => $e->getMessage()
    );
}

echo json_encode($respuesta);
?>