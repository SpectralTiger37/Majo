

<?php

$host = "127.0.0.1";
$usuario = "root";
$password = "";
$baseDatos = "spectral";

/* ========================================= */
/* CONEXIÓN */
/* ========================================= */

$conexion = new mysqli(
    $host,
    $usuario,
    $password,
    $baseDatos
);

/* ========================================= */
/* VALIDAR CONEXIÓN */
/* ========================================= */

if($conexion->connect_error){

    die(
        "Error de conexión: " .
        $conexion->connect_error
    );

}

/* ========================================= */
/* UTF8 */
/* ========================================= */

$conexion->set_charset("utf8");

?>