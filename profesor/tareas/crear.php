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

    $puntos = intval($_POST['puntos']);

    $fecha_entrega = $_POST['fecha_entrega'];

    mysqli_query(

        $conexion,

        "INSERT INTO tareas(

        clase_id,
        titulo,
        puntos,
        fecha_entrega,
        descripcion

        )

        VALUES(

        $id_clase,
        '$titulo',
        $puntos,
        '$fecha_entrega',
        '$descripcion'

        )"

    );

    header(
        "Location: ../clases/clase.php?id=" . $id_clase . "&tab=tareas"
    );

    exit;

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Nueva Tarea</title>

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

            box-shadow: 0 4px 15px rgba(0, 0, 0, .05);

        }
    </style>

</head>

<body>

    <div class="content">

        <div class="card-form">

            <h2 class="mb-4">

                📝 Nueva Tarea

            </h2>

            <form method="POST">

                <div class="mb-3">

                    <label>Título</label>

                    <input type="text" name="titulo" class="form-control" required>

                </div>

                <div class="mb-3">

                    <label>Descripción</label>

                    <textarea name="descripcion" class="form-control" rows="5" required></textarea>

                </div>

                <div class="mb-3">

                    <label>Puntos</label>

                    <input type="number" name="puntos" class="form-control" min="1" required>

                </div>

                <div class="mb-3">

                    <label>Fecha de entrega</label>

                    <input type="date" name="fecha_entrega" class="form-control" required>

                </div>

                <button type="submit" name="guardar" class="btn btn-primary">

                    💾 Crear Tarea

                </button>

                <a href="../clases/clase.php?id=<?= $id_clase ?>&tab=tareas" class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</body>

</html>