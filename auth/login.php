<!-- auth/login.php -->

<?php

session_start();

include "../includes/conexion.php";

$correo = $_POST['correo'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios
WHERE correo = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("s",$correo);

$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows > 0){

    $usuario = $resultado->fetch_assoc();

    if(password_verify(
        $password,
        $usuario['password']
    )){

        $_SESSION['id'] =
        $usuario['id'];

        $_SESSION['nombre'] =
        $usuario['nombre'];

        $_SESSION['rol'] =
        $usuario['rol'];

        /* REDIRECT */

        if($usuario['rol'] == "maestro"){

            header(
            "Location: ../maestro/dashboard.php"
            );

        }else{

            header(
            "Location: ../alumno/dashboard.php"
            );

        }

    }else{

        echo "Incorrect password";

    }

}else{

    echo "User not found";

}
?>