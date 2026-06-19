<?php

session_start();

include '../../includes/conexion.php';
include '../../includes/sidebar_maestro.php';

$id_tarea = intval($_GET['id']);

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

$entregas = mysqli_query(

    $conexion,

    "SELECT

    e.*,
    u.nombre

    FROM entregas e

    INNER JOIN usuarios u
    ON e.alumno_id = u.id

    WHERE e.tarea_id = $id_tarea

    ORDER BY e.fecha DESC"

);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Entregas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .content {
            margin-left: 320px;
            padding: 35px;
        }
    </style>

</head>

<body>

    <div class="content">

        <h2>

            📝 <?= htmlspecialchars($tarea['titulo']) ?>

        </h2>

        <hr>

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Alumno</th>
                    <th>Fecha</th>
                    <th>Archivo</th>
                    <th>Calificación</th>
                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

                <?php while ($e = mysqli_fetch_assoc($entregas)): ?>

                    <tr>

                        <td>

                            <?= htmlspecialchars($e['nombre']) ?>

                        </td>

                        <td>

                            <?= $e['fecha'] ?>

                        </td>

                        <td>

                            <?php if (!empty($e['archivo'])): ?>

                                <a href="../../uploads/entregas/<?= $e['archivo'] ?>" target="_blank">

                                    📎 Ver archivo

                                </a>

                            <?php endif; ?>

                        </td>

                        <td>

                            <?= $e['calificacion'] ?? 'Sin calificar' ?>

                        </td>

                        <td>

                            <a href="calificar.php?id=<?= $e['id'] ?>" class="btn btn-success btn-sm">

                                📊 Calificar

                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</body>

</html>