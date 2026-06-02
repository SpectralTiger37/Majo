<?php

session_start();

include '../includes/conexion.php';
include '../includes/sidebar.php';

$id_usuario = $_SESSION['id'];

$clases = mysqli_query(

    $conexion,

    "SELECT c.*
FROM clases c

INNER JOIN alumnos_clases ac
ON c.id = ac.clase_id

WHERE ac.alumno_id=$id_usuario"

);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Mis Clases</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', sans-serif;
            margin-left: 300px;
            padding: 35px;
        }

        .container-main {
            max-width: 1200px;
            margin: auto;
            padding: 40px;
        }

        .card-academica {

            background: white;

            border-radius: 25px;

            padding: 25px;

            margin-bottom: 25px;

            box-shadow:
                0 6px 20px rgba(0, 0, 0, .06);

            transition: .25s;
        }

        .card-academica:hover {

            transform: translateY(-5px);

        }

        .nombre {

            font-size: 1.4rem;

            font-weight: 700;

            color: #4338ca;
        }

        .stats {

            display: flex;

            gap: 15px;

            margin-top: 20px;

        }

        .badge-custom {

            background: #eef2ff;

            color: #4338ca;

            padding: 10px 15px;

            border-radius: 12px;

            font-weight: 600;
        }
    </style>

</head>

<body>

    <div class="container-main">

        <h1 class="mb-4">

            📚 Mis Clases

        </h1>

        <?php while ($c = mysqli_fetch_assoc($clases)):

            $tareas = mysqli_num_rows(

                mysqli_query(

                    $conexion,

                    "SELECT *
FROM tareas
WHERE clase_id=" . $c['id']

                )

            );

            $entregadas = mysqli_num_rows(

                mysqli_query(

                    $conexion,

                    "SELECT e.*

FROM entregas e

INNER JOIN tareas t
ON e.tarea_id=t.id

WHERE e.alumno_id=$id_usuario
AND t.clase_id=" . $c['id']

                )

            );

            $porcentaje = 0;

            if ($tareas > 0) {

                $porcentaje =
                    round(
                        ($entregadas / $tareas) * 100
                    );

            }

            ?>

            <div class="card-academica">

                <div class="nombre">

                    <?= $c['nombre'] ?>

                </div>

                <div>

                    Código:
                    <strong>

                        <?= $c['codigo'] ?>

                    </strong>

                </div>

                <div class="stats">

                    <div class="badge-custom">

                        📄 Tareas:
                        <?= $tareas ?>

                    </div>

                    <div class="badge-custom">

                        ✅ Entregadas:
                        <?= $entregadas ?>

                    </div>

                    <div class="badge-custom">

                        📈 Progreso:
                        <?= $porcentaje ?>%

                    </div>

                </div>

                <div class="progress mt-4">

                    <div class="progress-bar" style="width:<?= $porcentaje ?>%">

                        <?= $porcentaje ?>%

                    </div>

                </div>

                <div class="mt-4">

                    <a href="clase.php?id=<?= $c['id'] ?>" class="btn btn-primary">

                        Entrar a la clase

                    </a>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</body>

</html>