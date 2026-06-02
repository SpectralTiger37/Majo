<?php

session_start();
if(
    !isset($_SESSION['id']) ||
    $_SESSION['rol'] != 'maestro'
){
    header("Location: ../auth/login.html");
    exit;
}

include '../../includes/conexion.php';
include '../../includes/sidebar_maestro.php';

$id = intval($_GET['id']);

$clase = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM clases
         WHERE id=$id"

    )

);

if (!$clase) {

    die("Clase no encontrada");

}

if (isset($_POST['guardar'])) {

    $nombre = mysqli_real_escape_string(
        $conexion,
        $_POST['nombre']
    );

    $descripcion = mysqli_real_escape_string(
        $conexion,
        $_POST['descripcion']
    );

    $color = $_POST['color'];

    $imagen = $clase['imagen'];

    if (
        isset($_FILES['imagen']) &&
        $_FILES['imagen']['error'] == 0
    ) {

        $carpeta = "../uploads/clases/";

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

        "UPDATE clases
         SET

         nombre='$nombre',
         descripcion='$descripcion',
         color='$color',
         imagen='$imagen'

         WHERE id=$id"

    );

    header("Location: ver.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Editar Clase</title>

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

        .preview {

            width: 100%;

            height: 220px;

            object-fit: cover;

            border-radius: 20px;

            margin-bottom: 20px;

        }
    </style>

</head>

<body>

    <div class="content">

        <div class="card-form">

            <h2 class="mb-4">

                ✏️ Editar Clase

            </h2>

            <?php

            $img = !empty($clase['imagen'])

                ? "../uploads/clases/" . $clase['imagen']

                : "https://picsum.photos/800/300";

            ?>

            <img src="<?= $img ?>" class="preview">

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">

                    <label>

                        Nombre

                    </label>

                    <input type="text" name="nombre" class="form-control"
                        value="<?= htmlspecialchars($clase['nombre'] ?? '') ?>" required>

                </div>

                <div class="mb-3">

                    <label>

                        Descripción

                    </label>

                    <textarea name="descripcion" class="form-control"
                        rows="4"><?= htmlspecialchars($clase['descripcion'] ?? '') ?></textarea>

                </div>

                <div class="mb-3">

                    <label>

                        Color

                    </label>

                    <input type="color" name="color" class="form-control form-control-color"
                        value="<?= $clase['color'] ?: '#4f46e5' ?>">

                </div>

                <div class="mb-3">

                    <label>

                        Nueva imagen

                    </label>

                    <input type="file" name="imagen" class="form-control">

                </div>

                <div class="mb-3">

                    <label>

                        Código de clase

                    </label>

                    <input type="text" class="form-control" value="<?= $clase['codigo'] ?>" disabled>

                </div>

                <button type="submit" name="guardar" class="btn btn-success">

                    💾 Guardar Cambios

                </button>

                <a href="ver.php" class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</body>

</html>