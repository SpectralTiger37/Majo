<?php

session_start();

if(!isset($_SESSION['id'])){

    header("Location: ../index.php");
    exit();

}

include "../includes/conexion.php";

$id = $_SESSION['id'];

$mensaje = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombre = $_POST['nombre'];

    /* GENERAR CÓDIGO */

    $codigo = strtoupper(
        substr(
            md5(
                uniqid()
            ),
            0,
            6
        )
    );

    $sql = "INSERT INTO clases
    (nombre,codigo,maestro_id)
    VALUES (?,?,?)";

    $stmt =
    $conexion->prepare($sql);

    $stmt->bind_param(
        "ssi",
        $nombre,
        $codigo,
        $id
    );

    $stmt->execute();

    $mensaje =
    "Clase creada correctamente";

}
?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Crear Clase</title>

<link rel="stylesheet"
href="../assets/css/maestro.css">

<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap"
rel="stylesheet">

</head>
<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <div class="sidebar-logo">

        SPECTRAL

    </div>

    <div class="sidebar-menu">

        <a href="dashboard.php">

            Dashboard

        </a>

        <a href="create_class.php"
        class="active">

            Crear clase

        </a>

        <a href="../auth/logout.php">

            Cerrar sesión

        </a>

    </div>

</div>

<!-- MAIN -->

<div class="main">

    <div class="form-card">

        <h1>

            Crear Clase

        </h1>

        <p>

            Genera una nueva clase
            para tus alumnos.

        </p>

        <?php if($mensaje != ""){ ?>

            <div class="success">

                <?php
                echo $mensaje;
                ?>

            </div>

        <?php } ?>

        <form method="POST">

            <input type="text"
            name="nombre"
            placeholder="Nombre de la clase"
            required>

            <button>

                Crear clase

            </button>

        </form>

    </div>

</div>

</body>
</html>