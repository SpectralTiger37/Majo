<?php

session_start();

include '../includes/conexion.php';

if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit;
}

$id_usuario = $_SESSION['id'];

$nombre = mysqli_real_escape_string(
    $conexion,
    $_POST['nombre']
);

$semestre = mysqli_real_escape_string(
    $conexion,
    $_POST['semestre']
);

$grupo = mysqli_real_escape_string(
    $conexion,
    $_POST['grupo']
);


mysqli_query(

    $conexion,

    "UPDATE usuarios
     SET
        nombre='$nombre',
        semestre='$semestre',
        grupo='$grupo'
     WHERE id=$id_usuario"

);


if(
    isset($_FILES['foto']) &&
    $_FILES['foto']['error'] == 0
){

    $carpeta = "../uploads/perfiles/";

    if(!is_dir($carpeta)){
        mkdir($carpeta, 0777, true);
    }

    $nombreArchivo =
        time() . "_" .
        basename($_FILES['foto']['name']);

    $rutaDestino =
        $carpeta . $nombreArchivo;

    move_uploaded_file(
        $_FILES['foto']['tmp_name'],
        $rutaDestino
    );

    mysqli_query(

        $conexion,

        "UPDATE usuarios
         SET foto='$nombreArchivo'
         WHERE id=$id_usuario"

    );

}

header("Location: perfil.php?ok=1");
exit;