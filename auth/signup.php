<!-- auth/signup.php -->

<?php

include "../includes/conexion.php";

$nombre = $_POST['nombre'];

$correo = $_POST['correo'];

$password = password_hash(
    $_POST['password'],
    PASSWORD_DEFAULT
);

/* VALIDAR SI EXISTE */

$check = "SELECT * FROM usuarios
WHERE correo = ?";

$stmt = $conexion->prepare($check);

$stmt->bind_param("s",$correo);

$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows > 0){

    die("Email already exists");

}

/* INSERTAR ALUMNO */

$sql = "INSERT INTO usuarios
(nombre,correo,password,rol)
VALUES (?,?,?,'alumno')";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "sss",
    $nombre,
    $correo,
    $password
);

$stmt->execute();

/* LOGIN AUTOMÁTICO */

session_start();

$_SESSION['id'] =
$conexion->insert_id;

$_SESSION['nombre'] =
$nombre;

$_SESSION['rol'] =
"alumno";

/* REDIRECT */

header(
"Location: ../alumno/dashboard.php"
);
?>