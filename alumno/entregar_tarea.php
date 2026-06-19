<?php

session_start();

include '../includes/conexion.php';

if (
    !isset($_SESSION['id']) ||
    $_SESSION['rol'] != 'alumno'
) {
    header("Location: ../auth/login.html");
    exit;
}

$id_tarea = intval($_GET['id']);
$id_alumno = $_SESSION['id'];

$tarea = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM tareas
         WHERE id = $id_tarea"

    )

);

if (!$tarea) {

    die("Tarea no encontrada");

}

$entregaExistente = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM entregas
         WHERE tarea_id = $id_tarea
         AND alumno_id = $id_alumno"

    )

);

if (isset($_POST['entregar'])) {

    if (
        isset($_FILES['archivo']) &&
        $_FILES['archivo']['error'] == 0
    ) {

        $carpeta =
            __DIR__ . "/../uploads/entregas/";

        if (!is_dir($carpeta)) {

            mkdir(
                $carpeta,
                0777,
                true
            );

        }

        $archivo =

            time() . "_" .

            basename(
                $_FILES['archivo']['name']
            );

        move_uploaded_file(

            $_FILES['archivo']['tmp_name'],

            $carpeta . $archivo

        );

        if ($entregaExistente) {

            mysqli_query(

                $conexion,

                "UPDATE entregas
                 SET

                 archivo='$archivo',
                 entregado=1,
                 fecha=NOW()

                 WHERE id=" . $entregaExistente['id']

            );

        } else {

            mysqli_query(

                $conexion,

                "INSERT INTO entregas(

                tarea_id,
                alumno_id,
                entregado,
                archivo,
                fecha

                )

                VALUES(

                $id_tarea,
                $id_alumno,
                1,
                '$archivo',
                NOW()

                )"

            );

        }

        header("Location: mis_clases.php");
        exit;

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Entregar Tarea</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .container {
            max-width: 800px;
            margin-top: 40px;
        }

        .card {
            border-radius: 20px;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="card p-4">

            <h2>

                📝 <?= htmlspecialchars($tarea['titulo']) ?>

            </h2>

            <hr>

            <p>

                <?= nl2br(
                    htmlspecialchars(
                        $tarea['descripcion']
                    )
                ) ?>

            </p>

            <p>

                ⭐ Valor:

                <?= $tarea['puntos'] ?>

                puntos

            </p>

            <p>

                📅 Fecha límite:

                <?= $tarea['fecha_entrega'] ?>

            </p>

            <?php if ($entregaExistente): ?>

                <div class="alert alert-success">

                    ✅ Ya entregaste esta tarea.

                </div>

            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">

                    <label>

                        Selecciona tu archivo

                    </label>

                    <input type="file" name="archivo" class="form-control" required>

                </div>

                <button type="submit" name="entregar" class="btn btn-primary">

                    📤 Entregar tarea

                </button>

            </form>

        </div>

    </div>

</body>

</html>