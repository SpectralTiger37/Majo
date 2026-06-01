<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

include "../includes/conexion.php";

if (!isset($_GET['id'])) {
    die("Clase no encontrada");
}

$idClase = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $link = $_POST['link'];

    $imagen = "";

    /* IMAGEN */

    if (
        isset($_FILES['imagen'])
        && $_FILES['imagen']['name'] != ""
    ) {

        $nombre =
            time() . "_" .
            $_FILES['imagen']['name'];

        $ruta =
            "../uploads/" . $nombre;

        move_uploaded_file(
            $_FILES['imagen']['tmp_name'],
            $ruta
        );

        $imagen = $nombre;

    }

    /* INSERT */

    $sql = "INSERT INTO publicaciones
    (clase_id,titulo,descripcion,tipo,imagen,link)
    VALUES (?,?,?,?,?,?)";

    $stmt =
        $conexion->prepare($sql);

    $stmt->bind_param(
        "isssss",
        $idClase,
        $titulo,
        $descripcion,
        $tipo,
        $imagen,
        $link
    );

    /* EJECUTAR */

    $stmt->execute();

    /* ========================================= */
    /* SI ES TAREA */
    /* ========================================= */

    if ($tipo == "tarea") {

        $puntos = 50;

        $sqlTarea = "INSERT INTO tareas
    (clase_id,titulo,puntos)
    VALUES (?,?,?)";

        $stmtTarea =
            $conexion->prepare($sqlTarea);

        $stmtTarea->bind_param(
            "isi",
            $idClase,
            $titulo,
            $puntos
        );

        $stmtTarea->execute();

    }

    /* REDIRECT */

    header(
        "Location: classroom.php?id=$idClase"
    );

}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Crear publicación</title>

    <link rel="stylesheet" href="../assets/css/maestro.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

</head>

<body>

    <div class="sidebar">

        <div class="sidebar-logo">

            SPECTRAL

        </div>

        <div class="sidebar-menu">

            <a href="dashboard.php">

                Dashboard

            </a>

            <a href="../auth/logout.php">

                Cerrar sesión

            </a>

        </div>

    </div>

    <div class="main">

        <div class="topbar">

            <div>

                <h1>

                    Crear publicación

                </h1>

                <p class="subtitle">

                    Publica tareas,
                    noticias o links.

                </p>

            </div>

        </div>

        <!-- FORM -->

        <div class="form-card">

            <form method="POST" enctype="multipart/form-data">

                <input type="text" name="titulo" placeholder="Título" required>

                <textarea name="descripcion" placeholder="Descripción" required></textarea>

                <select name="tipo">

                    <option value="tarea">

                        Tarea

                    </option>

                    <option value="noticia">

                        Noticia

                    </option>

                    <option value="link">

                        Link

                    </option>

                </select>

                <input type="text" name="link" placeholder="Link opcional">

                <input type="file" name="imagen">

                <button>

                    Publicar

                </button>

            </form>

        </div>

    </div>

</body>

</html>