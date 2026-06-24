<?php

session_start();


include '../includes/conexion.php';

$id_maestro = $_SESSION['id'];

$totalClases = mysqli_num_rows(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM clases
         WHERE maestro_id = $id_maestro"

    )

);

$alumnos = mysqli_num_rows(

    mysqli_query(

        $conexion,

        "SELECT DISTINCT alumno_id
         FROM alumnos_clases ac
         INNER JOIN clases c
         ON ac.clase_id = c.id
         WHERE c.maestro_id = $id_maestro"

    )

);


$totalTareas = mysqli_num_rows(

    mysqli_query(

        $conexion,

        "SELECT t.*
         FROM tareas t
         INNER JOIN clases c
         ON t.clase_id = c.id
         WHERE c.maestro_id = $id_maestro"

    )

);

$totalPublicaciones = mysqli_num_rows(

    mysqli_query(

        $conexion,

        "SELECT p.*
         FROM publicaciones p
         INNER JOIN clases c
         ON p.clase_id = c.id
         WHERE c.maestro_id = $id_maestro"

    )

);

$clases = mysqli_query(

    $conexion,

    "SELECT *
     FROM clases
     WHERE maestro_id = $id_maestro"

);

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor EduNova</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fb;
            margin: 0;
            min-height: 100vh;
            overflow-y: auto;
        }

        .content {

            margin-left: 320px;

            padding: 35px;

            width: calc(100% - 320px);

        }

        .stats {

            display: flex;

            justify-content: center;

            gap: 25px;

            flex-wrap: wrap;

            margin-bottom: 40px;

        }

        .stat-box {

            width: 220px;

            background: white;

            border-radius: 25px;

            padding: 30px;

            text-align: center;

            box-shadow: 0 4px 15px rgba(0, 0, 0, .05);

        }

        .clases-container {

            display: flex;

            flex-direction: column;

            align-items: center;

        }

        .card-clase {

            width: 100%;

            max-width: 900px;

            background: white;

            border-radius: 25px;

            padding: 25px;

            margin-bottom: 20px;

            box-shadow: 0 4px 15px rgba(0, 0, 0, .05);

        }

        .titulo-dashboard {

            text-align: center;

            margin-bottom: 40px;

        }

        .btn-crear {

            display: block;

            width: 220px;

            margin: 0 auto 35px auto;

        }
    </style>
</head>
<?php include '../includes/sidebar_maestro.php'; ?>

<body>
    <div class="content">

        <div class="titulo-dashboard">

            <h1>👨‍🏫 Dashboard</h1>

        </div>

        <div class="stats">

            <div class="stat-box">
                <h2><?= $totalClases ?></h2>
                <p>Clases</p>
            </div>

            <div class="stat-box">
                <h2><?= $alumnos ?></h2>
                <p>Alumnos</p>
            </div>

            <div class="stat-box">
                <h2><?= $totalTareas ?></h2>
                <p>Tareas</p>
            </div>

            <div class="stat-box">
                <h2><?= $totalPublicaciones ?></h2>
                <p>Publicaciones</p>
            </div>

        </div>

        <a href="crear_clase.php" class="btn btn-primary btn-crear">

            ➕ Crear Clase

        </a>

        <div class="clases-container">

            <?php while ($c = mysqli_fetch_assoc($clases)):
                $totalAlumnosClase = mysqli_num_rows(

                    mysqli_query(

                        $conexion,

                        "SELECT *
         FROM alumnos_clases
         WHERE clase_id=" . $c['id']

                    )

                );
                ?>


                <div class="card-clase">

                    <?php

                    $imagen = !empty($c['imagen'])

                        ? "uploads/clases/" . $c['imagen']

                        : "https://picsum.photos/600/300";

                    ?>
                    <img src="<?= $imagen ?>" style="
width:100%;
height:180px;
object-fit:cover;
border-radius:20px;">

                    <h3><?= $c['nombre'] ?></h3>

                    <p>
                        Código:
                        <strong><?= $c['codigo'] ?></strong>
                    </p>

                    <p>
                        👨‍🎓 <?= $totalAlumnosClase ?> alumnos
                    </p>

                    <a href="clases/clase.php?id=<?= $c['id'] ?>" class="btn btn-primary">

                        Administrar

                    </a>

                </div>

            <?php endwhile; ?>

        </div>

    </div>


</body>

</html>