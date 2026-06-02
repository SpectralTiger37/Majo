<?php

session_start();

include '../includes/conexion.php';
include '../includes/sidebar.php';

$id_usuario = $_SESSION['id'];

$usuario = mysqli_fetch_assoc(

    mysqli_query(
        $conexion,
        "SELECT *
         FROM usuarios
         WHERE id = $id_usuario"
    )

);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fb;
        }

        .content {
            margin-left: 300px;
            padding: 35px;
        }

        .foto-perfil-grande {

            width: 180px;

            height: 180px;

            border-radius: 50%;

            object-fit: cover;

            border: 6px solid #4f46e5;

            display: block;

            margin: auto;

        }

        .card-perfil {

            background: white;

            padding: 30px;

            border-radius: 25px;

            max-width: 700px;

            margin: auto;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, .08);

        }
    </style>
</head>

<body>
    <div class="content">

        <h1 class="mb-4">
            👤 Mi Perfil
        </h1>
        <div class="card-perfil">

            <img src="<?= !empty($usuario['foto'])

                ? '../uploads/perfiles/' . $usuario['foto']

                : 'https://ui-avatars.com/api/?name=' .
                urlencode($usuario['nombre'])

                ?>" class="foto-perfil-grande">

            <?php if (isset($_GET['ok'])): ?>

                <div class="alert alert-success">

                    ✅ Perfil actualizado correctamente.

                </div>

            <?php endif; ?>
            <form action="guardar_perfil.php" method="POST" enctype="multipart/form-data">

                <div class="mb-3">

                    <label>
                        Nombre
                    </label>

                    <input type="text" name="nombre" class="form-control" value="<?= $usuario['nombre'] ?>">

                </div>

                <div class="mb-3">

                    <label>
                        Semestre
                    </label>

                    <input type="text" name="semestre" class="form-control" value="<?= $usuario['semestre'] ?>">

                </div>

                <div class="mb-3">

                    <label>
                        Grupo
                    </label>

                    <input type="text" name="grupo" class="form-control" value="<?= $usuario['grupo'] ?>">

                </div>

                <div class="mb-3">

                    <label>
                        Foto de perfil
                    </label>

                    <input type="file" name="foto" class="form-control">

                </div>

                <button class="btn btn-primary">

                    Guardar cambios

                </button>

            </form>
        </div>
    </div>
</body>

</html>