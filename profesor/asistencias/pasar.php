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

$id_clase = intval($_GET['id'] ?? 0);

$clase = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM clases
         WHERE id = $id_clase"

    )

);

if (!$clase) {

    die("Clase no encontrada");

}

$fechaHoy = date('Y-m-d');

if (isset($_POST['guardar'])) {

    $verificar = mysqli_num_rows(

        mysqli_query(

            $conexion,

            "SELECT *
             FROM asistencias
             WHERE clase_id = $id_clase
             AND fecha = '$fechaHoy'"

        )

    );

    if ($verificar > 0) {

        $mensaje =
            "Ya existe una asistencia registrada para hoy.";

    } else {

        $alumnos = mysqli_query(

            $conexion,

            "SELECT alumno_id
             FROM alumnos_clases
             WHERE clase_id = $id_clase"

        );

        while ($a = mysqli_fetch_assoc($alumnos)) {

            $alumno_id = $a['alumno_id'];

            $asistencia =
                isset($_POST['asistencia'][$alumno_id])
                ? 1
                : 0;

            mysqli_query(

                $conexion,

                "INSERT INTO asistencias(

                alumno_id,
                clase_id,
                asistencia,
                fecha

                )

                VALUES(

                $alumno_id,
                $id_clase,
                $asistencia,
                '$fechaHoy'

                )"

            );

        }

        $mensaje =
            "Asistencia guardada correctamente.";

    }

}

$alumnos = mysqli_query(

    $conexion,

    "SELECT

    u.id,
    u.nombre,
    u.correo

    FROM alumnos_clases ac

    INNER JOIN usuarios u
    ON ac.alumno_id = u.id

    WHERE ac.clase_id = $id_clase

    ORDER BY u.nombre"

);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Pasar Asistencia</title>

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

        .alumno {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 15px;

            border-bottom: 1px solid #eee;

        }

        .alumno:last-child {

            border-bottom: none;

        }
    </style>

</head>

<body>

    <div class="content">

        <div class="card-main">

            <h2>

                ✅ Pasar Asistencia

            </h2>

            <h5>

                <?= htmlspecialchars($clase['nombre']) ?>

            </h5>

            <p>

                Fecha:
                <?= date('d/m/Y') ?>

            </p>

            <?php if (isset($mensaje)): ?>

                <div class="alert alert-info">

                    <?= $mensaje ?>

                </div>

            <?php endif; ?>

            <form method="POST">

                <?php while ($alumno = mysqli_fetch_assoc($alumnos)): ?>

                    <div class="alumno">

                        <div>

                            <strong>

                                <?= htmlspecialchars($alumno['nombre']) ?>

                            </strong>

                            <br>

                            <small>

                                <?= htmlspecialchars($alumno['correo']) ?>

                            </small>

                        </div>

                        <div>

                            <input type="checkbox" class="form-check-input" name="asistencia[<?= $alumno['id'] ?>]" checked>

                        </div>

                    </div>

                <?php endwhile; ?>

                <br>

                <button type="submit" name="guardar" class="btn btn-success">

                    💾 Guardar asistencia

                </button>

                <a href="../clases/clase.php?id=<?= $id_clase ?>&tab=asistencias" class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</body>

</html>