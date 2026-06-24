<?php

session_start();

include "../includes/conexion.php";

$correo = trim($_POST['correo']);
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE correo = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    $usuario = $resultado->fetch_assoc();

    if (password_verify($password, $usuario['password'])) {

        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        if ($usuario['rol'] == "maestro") {

            header("Location: ../profesor/dashboard.php");

        } else {

            header("Location: ../alumno/dashboard.php");

        }

        exit;

    } else {

        $_SESSION['error_login'] =
            "Contraseña incorrecta.";

        header("Location: ../index.php");
        exit;

    }

} else {

    $_SESSION['error_login'] =
        "No se encontró una cuenta con ese correo.";

    header("Location: ../index.php");
    exit;

}