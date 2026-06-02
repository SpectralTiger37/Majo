<?php

session_start();


include '../../includes/conexion.php';
include '../../includes/sidebar_maestro.php';

$id_maestro = $_SESSION['id'];

$clases = mysqli_query(

    $conexion,

    "SELECT *
     FROM clases
     WHERE maestro_id = $id_maestro
     ORDER BY id DESC"

);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Mis Clases</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .content {

            margin-left: 320px;

            padding: 35px;

        }

        .grid-clases {

            display: grid;

            grid-template-columns:
                repeat(auto-fill, minmax(350px, 1fr));

            gap: 25px;

        }

        .card-clase {

            background: white;

            border-radius: 25px;

            overflow: hidden;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, .05);

        }

        .portada {

            width: 100%;

            height: 180px;

            object-fit: cover;

        }

        .info {

            padding: 20px;

        }

        .codigo {

            background: #eef2ff;

            color: #4f46e5;

            padding: 5px 10px;

            border-radius: 10px;

            display: inline-block;

            font-weight: 600;

        }
    </style>

</head>

<body>

    <div class="content">

        <h1 class="mb-4">

            📚 Mis Clases

        </h1>

        <div class="grid-clases">

            <?php while ($c = mysqli_fetch_assoc($clases)):

                $alumnos = mysqli_num_rows(

                    mysqli_query(

                        $conexion,

                        "SELECT *
         FROM alumnos_clases
         WHERE clase_id=" . $c['id']

                    )

                );

                $imagen = !empty($c['imagen'])

                    ? "../uploads/clases/" . $c['imagen']

                    : "https://picsum.photos/600/300";

                ?>

                <div class="card-clase">

                    <img src="<?= $imagen ?>" class="portada">

                    <div class="info" style="border-top:8px solid <?= $c['color'] ?>;">

                        <h4>

                            <?= htmlspecialchars($c['nombre']) ?>

                        </h4>


                        <p>

                            <?= !empty($c['descripcion'])
                                ? htmlspecialchars($c['descripcion'])
                                : 'Sin descripción' ?>


                        </p>

                        <span class="codigo">

                            <?= $c['codigo'] ?>

                        </span>

                        <br><br>

                        <p>

                            👨‍🎓 <?= $alumnos ?> alumnos

                        </p>

                        <a href="clase.php?id=<?= $c['id'] ?>" class="btn btn-primary">

                            Administrar

                        </a>

                        <a href="editar.php?id=<?= $c['id'] ?>" class="btn btn-warning">

                            Editar

                        </a>

                        <a href="eliminar.php?id=<?= $c['id'] ?>" class="btn btn-danger"
                            onclick="return confirm('¿Eliminar clase?')">

                            Eliminar

                        </a>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    </div>

</body>

</html>