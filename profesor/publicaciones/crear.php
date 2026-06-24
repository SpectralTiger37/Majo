<?php

session_start();

if (
    !isset($_SESSION['id']) ||
    $_SESSION['rol'] != 'maestro'
) {
    header("Location: ../../auth/login.html");
    exit;
}

include '../../includes/conexion.php';
include '../../includes/sidebar_maestro.php';

$id_clase = intval($_GET['id_clase']);

if (isset($_POST['guardar'])) {

    $titulo = mysqli_real_escape_string(
        $conexion,
        $_POST['titulo']
    );

    $descripcion = mysqli_real_escape_string(
        $conexion,
        $_POST['descripcion']
    );

    $tipo = $_POST['tipo'];

    $link = mysqli_real_escape_string(
        $conexion,
        $_POST['link']
    );

    $imagen = '';

    if (
        isset($_FILES['imagen']) &&
        $_FILES['imagen']['error'] == 0
    ) {

        $carpeta = "../uploads/publicaciones/";

        if (!is_dir($carpeta)) {

            mkdir(
                $carpeta,
                0777,
                true
            );

        }

        $imagen =
            time() .
            "_" .
            basename($_FILES['imagen']['name']);

        move_uploaded_file(

            $_FILES['imagen']['tmp_name'],

            $carpeta . $imagen

        );

    }

    mysqli_query(

        $conexion,

        "INSERT INTO publicaciones(

        clase_id,
        titulo,
        descripcion,
        tipo,
        imagen,
        link

        )

        VALUES(

        $id_clase,

        '$titulo',
        '$descripcion',
        '$tipo',
        '$imagen',
        '$link'

        )"

    );

    header(
        "Location: ../clases/clase.php?id=" . $id_clase . "&tab=publicaciones"
    );

    exit;

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Nueva Publicación</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .content {
            margin-left: 320px;
            padding: 35px;
        }

        .card-form {

            background: white;

            max-width: 900px;

            margin: auto;

            padding: 30px;

            border-radius: 25px;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, .05);

        }
    </style>

</head>

<body>

    <div class="content">

        <div class="card-form">

            <h2 class="mb-4">

                📢 Nueva Publicación

            </h2>

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">

                    <label>

                        Título

                    </label>

                    <input type="text" name="titulo" class="form-control" required>

                </div>

                <div class="mb-3">

                    <label>

                        Descripción

                    </label>

                    <textarea name="descripcion" class="form-control" rows="5" required></textarea>

                </div>

                <div class="mb-3">

                    <label>

                        Tipo

                    </label>

                    <select name="tipo" class="form-control">

                        <option value="noticia">

                            📢 Noticia

                        </option>

                        <option value="documento">

                            📄 Documento

                        </option>

                        <option value="video">

                            🎥 Video

                        </option>

                        <option value="enlace">

                            🔗 Enlace

                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label>

                        Imagen

                    </label>

                    <input type="file" name="imagen" class="form-control">

                </div>

                <div class="mb-3">

                    <label>

                        Link

                    </label>

                    <input type="url" name="link" class="form-control">

                </div>

                <button type="submit" name="guardar" class="btn btn-primary">

                    💾 Publicar

                </button>

                <a href="../clases/clase.php?id=<?= $id_clase ?>&tab=publicaciones" class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</body>

</html>