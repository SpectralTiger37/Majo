<?php

session_start();

include '../../includes/conexion.php';
include '../../includes/sidebar_maestro.php';

$id_clase = intval($_GET['id']);

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
$totalAlumnos = mysqli_num_rows(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM alumnos_clases
         WHERE clase_id = $id_clase"

    )

);
$tab = $_GET['tab'] ?? 'publicaciones';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clase</title>
    <style>
        body {
            background: #f5f7fb;
        }

        .content {
            margin-left: 320px;
            padding: 35px;
        }

        .card-clase {
            background: white;
            padding: 30px;
            border-radius: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .05);
        }

        .menu-admin {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .menu-admin a {
            text-decoration: none;
            background: #4f46e5;
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
        }

        .menu-admin a:hover {
            opacity: .9;
        }

        .panel {
            background: white;
            padding: 25px;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .05);
        }
    </style>
</head>

<body>
    <div class="content">

        <div class="card-clase">

            <h1>

                <?= $clase['nombre'] ?>

            </h1>

            <p>

                Código:
                <strong>

                    <?= $clase['codigo'] ?>

                </strong>

            </p>

            <p>

                👨‍🎓 <?= $totalAlumnos ?> alumnos

            </p>

        </div>
        <div class="menu-admin">

            <a href="?id=<?= $id_clase ?>&tab=publicaciones">
                📢 Publicaciones
            </a>

            <a href="?id=<?= $id_clase ?>&tab=tareas">
                📝 Tareas
            </a>

            <a href="?id=<?= $id_clase ?>&tab=alumnos">
                👨‍🎓 Alumnos
            </a>

            <a href="?id=<?= $id_clase ?>&tab=asistencias">
                ✅ Asistencias
            </a>

            <a href="?id=<?= $id_clase ?>&tab=calificaciones">
                📊 Calificaciones
            </a>

        </div>
        <div class="panel">

            <?php

            if ($tab == 'publicaciones') {

                ?>

                <h3>📢 Publicaciones</h3>

                <a href="../publicaciones/crear.php?id_clase=<?= $id_clase ?>" class="btn btn-primary mb-3">

                    ➕ Nueva publicación

                </a>

                <hr>

                <?php

                $publicaciones = mysqli_query(

                    $conexion,

                    "SELECT *
     FROM publicaciones
     WHERE clase_id = $id_clase
     ORDER BY id DESC"

                );

                while ($p = mysqli_fetch_assoc($publicaciones)):

                    ?>

                    <div class="card mb-3">

                        <div class="card-body">

                            <h5>

                                <?= htmlspecialchars($p['titulo']) ?>

                            </h5>

                            <p>

                                <?= nl2br(htmlspecialchars($p['descripcion'])) ?>

                            </p>

                            <?php if (!empty($p['link'])): ?>

                                <a href="<?= htmlspecialchars($p['link']) ?>" target="_blank" class="btn btn-info btn-sm">

                                    🔗 Abrir enlace

                                </a>

                            <?php endif; ?>

                            <a href="../publicaciones/editar.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">

                                ✏️ Editar

                            </a>

                            <a href="../publicaciones/eliminar.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar publicación?')">

                                🗑️ Eliminar

                            </a>

                        </div>

                    </div>

                <?php endwhile; ?>
                <?php

            } elseif ($tab == 'tareas') {

                ?>

                <h3>📝 Tareas</h3>

                <a href="../tareas/crear.php?id_clase=<?= $id_clase ?>" class="btn btn-primary mb-3">

                    ➕ Nueva tarea

                </a>

                <?php

            } elseif ($tab == 'alumnos') {

                ?>

                <h3>👨‍🎓 Alumnos inscritos</h3>

                <?php

            } elseif ($tab == 'asistencias') {

                ?>

                <h3>✅ Asistencias</h3>

                <?php

            } elseif ($tab == 'calificaciones') {

                ?>

                <h3>📊 Calificaciones</h3>

                <?php

            }

            ?>

        </div>

</body>

</html>