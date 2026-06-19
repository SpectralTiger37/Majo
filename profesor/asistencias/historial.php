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

$id_maestro = $_SESSION['id'];

$id_clase = isset($_GET['id'])
    ? intval($_GET['id'])
    : 0;

if ($id_clase > 0) {

    $where =
        "AND c.id = $id_clase";

} else {

    $where = "";

}

$historial = mysqli_query(

    $conexion,

    "SELECT

    a.*,
    u.nombre,
    c.nombre AS clase

    FROM asistencias a

    INNER JOIN usuarios u
    ON a.alumno_id = u.id

    INNER JOIN clases c
    ON a.clase_id = c.id

    WHERE c.maestro_id = $id_maestro

    $where

    ORDER BY a.fecha DESC,
    c.nombre,
    u.nombre"

);

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Historial de Asistencias</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .content {
            margin-left: 320px;
            padding: 35px;
        }

        .card-main {

            background: white;

            border-radius: 25px;

            padding: 30px;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, .05);

        }
    </style>

</head>

<body>

    <div class="content">

        <div class="card-main">

            <h2>

                📋 Historial de Asistencias

            </h2>

            <hr>

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>Fecha</th>
                        <th>Clase</th>
                        <th>Alumno</th>
                        <th>Estado</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while ($h = mysqli_fetch_assoc($historial)): ?>

                        <tr>

                            <td>

                                <?= date(
                                    'd/m/Y',
                                    strtotime($h['fecha'])
                                ) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($h['clase']) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($h['nombre']) ?>

                            </td>

                            <td>

                                <?php if ($h['asistencia']): ?>

                                    <span class="badge bg-success">

                                        Presente

                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-danger">

                                        Ausente

                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>