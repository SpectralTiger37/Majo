<?php

session_start();

if (
    !isset($_SESSION['id']) ||
    $_SESSION['rol'] != 'maestro'
) {
    header("Location: ../auth/login.html");
    exit;
}

include '../includes/conexion.php';
include '../includes/sidebar_maestro.php';

$id = $_SESSION['id'];

$usuario = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM usuarios
         WHERE id = $id"

    )

);

if (!$usuario) {

    die("Usuario no encontrado");

}

if (isset($_POST['guardar'])) {

    $nombre = mysqli_real_escape_string(
        $conexion,
        trim($_POST['nombre'])
    );

    $foto = $usuario['foto'];

    if (
        isset($_FILES['foto']) &&
        $_FILES['foto']['error'] === 0
    ) {

        $carpeta = __DIR__ . "/uploads/perfil/";

        if (!is_dir($carpeta)) {

            mkdir(
                $carpeta,
                0777,
                true
            );

        }

        $extension = pathinfo(
            $_FILES['foto']['name'],
            PATHINFO_EXTENSION
        );

        $nuevoNombre =
            "perfil_" .
            $id .
            "_" .
            time() .
            "." .
            $extension;

        if (
            move_uploaded_file(
                $_FILES['foto']['tmp_name'],
                $carpeta . $nuevoNombre
            )
        ) {

            if (
                !empty($usuario['foto']) &&
                file_exists(
                    $carpeta . $usuario['foto']
                )
            ) {

                unlink(
                    $carpeta . $usuario['foto']
                );

            }

            $foto = $nuevoNombre;

        } else {

            die(
                "No se pudo guardar la imagen.<br>" .
                "Ruta: " .
                $carpeta .
                $nuevoNombre
            );

        }

    }

    $sql = "

        UPDATE usuarios
        SET

        nombre = '$nombre',
        foto = '$foto'

        WHERE id = $id

    ";

    mysqli_query(
        $conexion,
        $sql
    );

    if (mysqli_error($conexion)) {

        die(
            mysqli_error($conexion)
        );

    }

    $_SESSION['nombre'] = $nombre;

    header("Location: perfil.php");
    exit;

}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mi Perfil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {

            background: #f5f7fb;

        }

        .content {

            margin-left: 320px;

            padding: 35px;

        }

        .card-profile {

            background: white;

            max-width: 800px;

            margin: auto;

            padding: 35px;

            border-radius: 25px;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, .05);

        }

        .foto-perfil {

            width: 160px;

            height: 160px;

            border-radius: 50%;

            object-fit: cover;

            display: block;

            margin: auto;

            margin-bottom: 25px;

            border: 5px solid #4f46e5;

        }
    </style>

</head>

<body>

    <div class="content">

        <div class="card-profile">

            <h2 class="mb-4">

                👤 Perfil del Maestro

            </h2>

            <?php

            $fotoPerfil = !empty($usuario['foto'])

                ? "uploads/perfil/" . $usuario['foto']

                : "https://ui-avatars.com/api/?name=" .
                urlencode($usuario['nombre']) .
                "&background=4f46e5&color=ffffff";

            ?>

            <img src="<?= $fotoPerfil ?>" class="foto-perfil" alt="Perfil">

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">

                    <label class="form-label">

                        Nombre

                    </label>

                    <input type="text" name="nombre" class="form-control"
                        value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Correo

                    </label>

                    <input type="email" class="form-control" value="<?= htmlspecialchars($usuario['correo']) ?>"
                        disabled>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Rol

                    </label>

                    <input type="text" class="form-control" value="Maestro" disabled>

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Cambiar foto de perfil

                    </label>

                    <input type="file" name="foto" class="form-control" accept="image/*">

                </div>

                <button type="submit" name="guardar" class="btn btn-success">

                    💾 Guardar Cambios

                </button>

            </form>

        </div>

    </div>

</body>

</html>