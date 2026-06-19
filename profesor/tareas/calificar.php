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

$entrega = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT

        e.*,
        u.nombre,
        t.titulo

        FROM entregas e

        INNER JOIN usuarios u
        ON e.alumno_id = u.id

        INNER JOIN tareas t
        ON e.tarea_id = t.id

        WHERE e.id = $id"

    )

);

if (!$entrega) {

    die("Entrega no encontrada");

}

if (isset($_POST['guardar'])) {

    $calificacion = floatval(
        $_POST['calificacion']
    );

    mysqli_query(

        $conexion,

        "UPDATE entregas
         SET calificacion = $calificacion
         WHERE id = $id"

    );

    header(

        "Location: entregas.php?id=" . $entrega['tarea_id']

    );

    exit;

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Calificar Entrega</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .content {
            margin-left: 320px;
            padding: 35px;
        }

        .card {

            background: white;

            max-width: 800px;

            margin: auto;

            padding: 30px;

            border-radius: 25px;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, .05);

        }
    </style>

</head>

<body>

    <div class="content">

        <div class="card">

            <h2>

                📊 Calificar Entrega

            </h2>

            <hr>

            <p>

                <strong>Alumno:</strong>

                <?= htmlspecialchars($entrega['nombre']) ?>

            </p>

            <p>

                <strong>Tarea:</strong>

                <?= htmlspecialchars($entrega['titulo']) ?>

            </p>

            <p>

                <strong>Fecha:</strong>

                <?= $entrega['fecha'] ?>

            </p>

            <?php if (!empty($entrega['archivo'])): ?>

                <p>

                    <a href="../../uploads/entregas/<?= $entrega['archivo'] ?>" target="_blank" class="btn btn-info">

                        📎 Ver archivo

                    </a>

                </p>

            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">

                    <label>

                        Calificación

                    </label>

                    <input type="number" step="0.01" min="0" max="100" name="calificacion" class="form-control"
                        value="<?= $entrega['calificacion'] ?>">

                </div>

                <button type="submit" name="guardar" class="btn btn-success">

                    💾 Guardar

                </button>

                <a href="entregas.php?id=<?= $entrega['tarea_id'] ?>" class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</body>

</html>