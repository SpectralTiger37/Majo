

<?php

$host = "127.0.0.1";
$usuario = "root";
$password = "";
$baseDatos = "spectral";

$conexion = new mysqli(
    $host,
    $usuario,
    $password,
    $baseDatos
);


if($conexion->connect_error){

    die(
        "Error de conexión: " .
        $conexion->connect_error
    );

}


$conexion->set_charset("utf8");

?>