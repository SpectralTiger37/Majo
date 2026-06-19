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

$id = intval($_GET['id']);

$publicacion = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM publicaciones
         WHERE id = $id"

    )

);

if (!$publicacion) {

    die("Publicación no encontrada");

}

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

    $imagen = $publicacion['imagen'];

    if (
        isset($_FILES['imagen']) &&
        $_FILES['imagen']['error'] === 0 &&
        !empty($_FILES['imagen']['name'])
    ) {

        $carpeta = __DIR__ . "/../uploads/publicaciones/";

        if (!is_dir($carpeta)) {

            mkdir(
                $carpeta,
                0777,
                true
            );

        }

        $nuevoNombre =
            time() . "_" .
            basename($_FILES['imagen']['name']);

        if (
            move_uploaded_file(
                $_FILES['imagen']['tmp_name'],
                $carpeta . $nuevoNombre
            )
        ) {

            echo "Imagen subida correctamente";

            $imagen = $nuevoNombre;

        } else {

            die(
                "Error al subir imagen.<br>" .
                "Destino: " . $carpeta . $nuevoNombre . "<br>" .
                "Tmp: " . $_FILES['imagen']['tmp_name']
            );



            /* eliminar imagen anterior */

            if (
                !empty($publicacion['imagen']) &&
                file_exists(
                    $carpeta .
                    $publicacion['imagen']
                )
            ) {

                unlink(
                    $carpeta .
                    $publicacion['imagen']
                );

            }

            $imagen = $nuevoNombre;

        }

    }

    mysqli_query(

        $conexion,

        "UPDATE publicaciones
         SET

         titulo='$titulo',
         descripcion='$descripcion',
         tipo='$tipo',
         imagen='$imagen',
         link='$link'

         WHERE id=$id"

    );

    if (mysqli_affected_rows($conexion) >= 0) {

        header(
            "Location: ../clases/clase.php?id=" . $publicacion['clase_id'] . "&tab=publicaciones"
        );

        exit;

    } else {

        die(mysqli_error($conexion));

    }

    header(
        "Location: ../clases/clase.php?id=" . $publicacion['clase_id'] . "&tab=publicaciones"
    );

    exit;

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Editar Publicación</title>

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

            max-height: 250px;

            object-fit: cover;

            border-radius: 15px;

            margin-bottom: 20px;

        }
    </style>

</head>

<body>

    <div class="content">

        <div class="card-form">

            <h2 class="mb-4">

                ✏️ Editar Publicación

            </h2>

            <?php if (!empty($publicacion['imagen'])): ?>

                <img src="../uploads/publicaciones/<?= htmlspecialchars($publicacion['imagen']) ?>" class="preview">

            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">

                    <label>Título</label>

                    <input type="text" name="titulo" class="form-control"
                        value="<?= htmlspecialchars($publicacion['titulo']) ?>" required>

                </div>

                <div class="mb-3">

                    <label>Descripción</label>

                    <textarea name="descripcion" class="form-control"
                        rows="5"><?= htmlspecialchars($publicacion['descripcion']) ?></textarea>

                </div>

                <div class="mb-3">

                    <label>Tipo</label>

                    <select name="tipo" class="form-control">

                        <option value="noticia" <?= $publicacion['tipo'] == 'noticia' ? 'selected' : '' ?>>

                            📢 Noticia

                        </option>

                        <option value="documento" <?= $publicacion['tipo'] == 'documento' ? 'selected' : '' ?>>

                            📄 Documento

                        </option>

                        <option value="video" <?= $publicacion['tipo'] == 'video' ? 'selected' : '' ?>>

                            🎥 Video

                        </option>

                        <option value="enlace" <?= $publicacion['tipo'] == 'enlace' ? 'selected' : '' ?>>

                            🔗 Enlace

                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label>Nueva imagen</label>

                    <input type="file" name="imagen" class="form-control">

                </div>

                <div class="mb-3">

                    <label>Link</label>

                    <input type="url" name="link" class="form-control"
                        value="<?= htmlspecialchars($publicacion['link']) ?>">

                </div>

                <button type="submit" name="guardar" class="btn btn-success">

                    💾 Guardar Cambios

                </button>

                <a href="../clases/clase.php?id=<?= $publicacion['clase_id'] ?>&tab=publicaciones"
                    class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</body>

</html>