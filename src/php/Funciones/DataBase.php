<?php
//Conectar a la base de datos

$conexion = new mysqli('localhost', 'root', '', 'cinemex');

//Comprobrar si se conecto correctamente a la base de datos
if($conexion->connect_error){
    echo $conexion->connect_error;
}

//Esto permite enviar comillas letras ñ etc.
$conexion ->set_charset('utf8');