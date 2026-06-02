<?php

session_start();


include '../../includes/conexion.php';
include '../../includes/sidebar_maestro.php';

$id_maestro = $_SESSION['id'];

if (isset($_POST['crear'])) {

    $nombre = mysqli_real_escape_string(
        $conexion,
        $_POST['nombre']
    );

    $descripcion = mysqli_real_escape_string(
        $conexion,
        $_POST['descripcion']
    );

    $color = $_POST['color'];

    $codigo = strtoupper(

        substr(
            md5(
                uniqid()
            ),
            0,
            6
        )

    );

    $imagen = '';

    if (
        isset($_FILES['imagen']) &&
        $_FILES['imagen']['error'] == 0
    ) {

        $carpeta =
            "../uploads/clases/";

        if (!is_dir($carpeta)) {

            mkdir(
                $carpeta,
                0777,
                true
            );

        }

        $imagen =
            time() . '_' .
            $_FILES['imagen']['name'];

        move_uploaded_file(

            $_FILES['imagen']['tmp_name'],

            $carpeta . $imagen

        );

    }

    mysqli_query(

        $conexion,

        "INSERT INTO clases(

            nombre,
            descripcion,
            color,
            imagen,
            codigo,
            maestro_id

        )

        VALUES(

            '$nombre',
            '$descripcion',
            '$color',
            '$imagen',
            '$codigo',
            $id_maestro

        )"

    );

    header("Location: ../dashboard.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Crear Clase</title>

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

            padding: 35px;

            border-radius: 25px;

            max-width: 800px;

            margin: auto;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, .08);

        }

        .preview {

            width: 100%;

            height: 180px;

            border-radius: 15px;

            object-fit: cover;

            margin-bottom: 15px;

        }
    </style>

</head>

<body>

    <div class="content">

        <div class="card-form">

            <h2 class="mb-4">

                📚 Crear Clase

            </h2>

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">

                    <label>

                        Nombre

                    </label>

                    <input type="text" name="nombre" class="form-control" required>

                </div>

                <div class="mb-3">

                    <label>

                        Descripción

                    </label>

                    <textarea name="descripcion" class="form-control" rows="4"></textarea>

                </div>

                <div class="mb-3">

                    <label>

                        Color de la clase

                    </label>

                    <input type="color" name="color" class="form-control form-control-color" value="#4f46e5">

                </div>

                <div class="mb-3">

                    <label>

                        Imagen de portada

                    </label>

                    <input type="file" name="imagen" class="form-control">

                </div>

                <button type="submit" name="crear" class="btn btn-primary w-100">

                    Crear Clase

                </button>

            </form>

        </div>

    </div>

</body>

</html>