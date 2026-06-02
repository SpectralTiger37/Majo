<?php

session_start();


include '../includes/conexion.php';

$id_usuario = $_SESSION['id'];

$id = intval($_GET['id']);

$tab = $_GET['tab'] ?? 'novedades';



$clase = mysqli_fetch_assoc(
    mysqli_query($conexion, "
SELECT *
FROM clases
WHERE id=$id
")
);

$publicaciones = mysqli_query($conexion, "
SELECT *
FROM publicaciones
WHERE clase_id=$id
ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .banner {

            color: white;

            padding: 40px;

            border-radius: 25px;

            margin-bottom: 25px;

            box-shadow:
                0 10px 30px rgba(79, 70, 229, .2);

        }

        .banner h1 {
            font-weight: 700;
        }

        .tabs {

            display: flex;

            gap: 10px;

            margin-bottom: 25px;

        }

        .tabs button {

            border: none;

            background: white;

            padding: 12px 20px;

            border-radius: 12px;

            font-weight: 600;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, .05);

        }

        .tabs button:hover {

            background: #4f46e5;
            color: white;

        }

        .publicacion {

            background: white;

            border-radius: 20px;

            padding: 20px;

            margin-bottom: 20px;

            box-shadow:
                0 4px 20px rgba(0, 0, 0, .05);

        }

        .publicacion h5 {
            font-weight: 700;
        }

        .fecha {
            color: #6b7280;
        }
    </style>
</head>

<body>

    <div class="container mt-4">

        <a href="dashboard.php" class="btn btn-primary mb-4">

            ← Volver al Dashboard

        </a>

        <div class="banner" style="background: <?= $clase['color'] ?>;">

            <h1>
                <?= $clase['nombre'] ?>
            </h1>

            <p>

                Código:
                <?= $clase['codigo'] ?>

            </p>

        </div>

        <div class="tabs">

            <a class="btn <?= $tab == 'novedades' ? 'btn-primary' : 'btn-light' ?>"
                href="clase.php?id=<?= $id ?>&tab=novedades">

                📢 Novedades

            </a>

            <a class="btn <?= $tab == 'tareas' ? 'btn-primary' : 'btn-light' ?>"
                href="clase.php?id=<?= $id ?>&tab=tareas">

                📄 Tareas

            </a>

            <a class="btn <?= $tab == 'personas' ? 'btn-primary' : 'btn-light' ?>"
                href="clase.php?id=<?= $id ?>&tab=personas">

                👥 Personas

            </a>

        </div>

        <?php

        if ($tab == 'tareas'):

            $tareas = mysqli_query(
                $conexion,
                "SELECT *
     FROM tareas
     WHERE clase_id = $id"
            );

            if (!$tareas) {
                die(mysqli_error($conexion));
            }

            ?>

            <div class="row mb-4">

                <?php while ($t = mysqli_fetch_assoc($tareas)):

                    $entrega = mysqli_num_rows(

                        mysqli_query(

                            $conexion,

                            "SELECT *
                    FROM entregas
                    WHERE tarea_id=" . $t['id'] . "
                    AND alumno_id=" . $id_usuario

                        )

                    );
                    ?>
                    <div class="col-md-4">

                        <div class="publicacion">

                            <div class="d-flex justify-content-between align-items-center">

                                <h5>
                                    📄 <?= $t['titulo'] ?>
                                </h5>

                                <span class="badge bg-primary">

                                    <?= $t['puntos'] ?> XP

                                </span>

                            </div>

                            <hr>

                            <?php if ($entrega == 0): ?>

                                <a href="entregar_tarea.php?id=<?= $t['id'] ?>" class="btn btn-success w-100">

                                    📤 Entregar tarea

                                </a>

                            <?php else: ?>

                                <button class="btn btn-secondary w-100" disabled>

                                    ✅ Tarea entregada

                                </button>

                            <?php endif; ?>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        <?php endif; ?>

        <?php

        if ($tab == 'personas'):

            $alumnos = mysqli_query(

                $conexion,

                "SELECT u.*

FROM usuarios u

INNER JOIN alumnos_clases ac

ON u.id = ac.alumno_id

WHERE ac.clase_id=$id"

            );

            ?>

            <div class="publicacion">

                <h4>

                    👨‍🎓 Alumnos inscritos

                </h4>

                <hr>

                <?php while ($a = mysqli_fetch_assoc($alumnos)): ?>

                    <div class="d-flex
align-items-center
mb-3">

                        <img src="https://ui-avatars.com/api/?name=<?=
                            urlencode($a['nombre'])
                            ?>" width="50" height="50" style="
border-radius:50%;
margin-right:15px;
">

                        <div>

                            <strong>

                                <?= $a['nombre'] ?>

                            </strong>

                            <br>

                            Nivel

                            <?= $a['nivel'] ?>

                            ⭐

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        <?php endif; ?>

        <?php if ($tab == 'novedades'): ?>

            <h3 class="mt-4">
                Novedades
            </h3>

            <?php while ($p = mysqli_fetch_assoc($publicaciones)): ?>

                <div class="publicacion">

                    <h5>
                        <?= $p['titulo'] ?>
                    </h5>

                    <p>
                        <?= $p['descripcion'] ?>
                    </p>

                    <?php if (!empty($p['imagen'])): ?>

                        <img src="../profesor/uploads/publicaciones/<?= $p['imagen'] ?>" class="img-fluid rounded mt-3">

                    <?php endif; ?>

                    <?php if (!empty($p['link'])): ?>

                        <a href="../uploads/pdf/<?= $p['link'] ?>" target="_blank" class="btn btn-danger mt-3">

                            📄 Ver PDF

                        </a>

                    <?php endif; ?>

                    <div class="fecha mt-3">

                        <?= $p['created_at'] ?>

                    </div>

                </div>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>

</body>

</html>