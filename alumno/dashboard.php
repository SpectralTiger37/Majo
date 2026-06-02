<?php
session_start();

include '../includes/conexion.php';

$id_usuario = $_SESSION['id'];

$usuario = mysqli_fetch_assoc(
    mysqli_query($conexion, "SELECT * FROM usuarios WHERE id=$id_usuario")
);

$clases = mysqli_query($conexion, "
SELECT c.*
FROM clases c
INNER JOIN alumnos_clases ac
ON c.id = ac.clase_id
WHERE ac.alumno_id = $id_usuario
");

$totalClases = mysqli_num_rows($clases);

$totalEntregas = mysqli_num_rows(
    mysqli_query(
        $conexion,
        "SELECT *
        FROM entregas
        WHERE alumno_id=$id_usuario"
    )
);

$totalAsistencias = mysqli_num_rows(
    mysqli_query(
        $conexion,
        "SELECT *
        FROM asistencias
        WHERE alumno_id=$id_usuario
        AND asistencia=1"
    )
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Spectral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;

            width: 280px;
            height: 100vh;

            overflow-y: auto;

            background: white;

            padding: 25px;

            box-shadow: 0 0 25px rgba(0, 0, 0, .08);
        }

        .sidebar img {
            border: 4px solid #4f46e5;
        }

        .foto-perfil {

            width: 100px;

            height: 100px;

            border-radius: 50%;

            object-fit: cover;

            display: block;

            margin: auto;

        }

        .sidebar h4 {
            margin-top: 15px;
            font-weight: 700;
        }

        .sidebar h6 {
            color: #6b7280;
        }

        .content {
            margin-left: 300px;
            padding: 35px;
        }

        .progress {
            border-radius: 20px;
        }

        .progress-bar {
            background: #4f46e5;
        }

        .card-clase {
            border-top: 8px solid
                <?= $c['color'] ?>
            ;
        }

        .card-clase:hover {
            transform: translateY(-8px);
        }

        .portada {
            height: 180px;
            object-fit: cover;
        }

        .overlay {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 15px;
            color: white;
            background: linear-gradient(transparent,
                    rgba(0, 0, 0, .85));
        }

        .overlay h4 {
            margin: 0;
            font-weight: 700;
        }

        .stat-box {

            background: #f8fafc;

            padding: 10px;

            border-radius: 12px;

            margin-bottom: 8px;

        }

        .stat-box h3 {

            margin: 0;

            font-size: 1.2rem;

            color: #4f46e5;

        }

        .stat-box small {

            color: #6b7280;

        }

        .btn-menu {
            width: 100%;
            margin-bottom: 8px;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="sidebar">

        <center>

            <img class="foto-perfil" src="<?= !empty($usuario['foto'])

                ? '../uploads/perfiles/' . $usuario['foto']

                : 'https://ui-avatars.com/api/?name=' .
                urlencode($usuario['nombre'])

                ?>">

            <h4><?= $usuario['nombre'] ?></h4>

            <h6>Nivel <?= $usuario['nivel'] ?></h6>

            <?php

            $xpActual = $usuario['xp'];
            $xpNivel = 1000;

            $porcentaje = ($xpActual % $xpNivel) / $xpNivel * 100;

            ?>

            <div class="progress xp-bar">
                <div class="progress-bar" style="width:<?= $porcentaje ?>%">
                </div>
            </div>

            <small>
                <?= $xpActual ?> XP
            </small>

            <div class="mt-3">

                <div class="stat-box mb-2">

                    <h3><?= $totalClases ?></h3>

                    <small>Clases</small>

                </div>

                <div class="stat-box mb-2">

                    <h3><?= $totalEntregas ?></h3>

                    <small>Tareas</small>

                </div>

                <div class="stat-box">

                    <h3><?= $usuario['xp'] ?></h3>

                    <small>XP</small>

                </div>

            </div>
        </center>

        <hr>

        <a class="btn btn-light btn-menu" href="dashboard.php">
            🏠 Dashboard
        </a>

        <a class="btn btn-light btn-menu" href="mis_clases.php">
            📚 Mis Clases
        </a>

        <a class="btn btn-light btn-menu" href="calendario.php">
            📅 Calendario
        </a>

        <a class="btn btn-light btn-menu" href="logros.php">
            🏆 Logros
        </a>

        <a class="btn btn-light btn-menu" href="ranking.php">
            🥇 Ranking
        </a>

        <a class="btn btn-light btn-menu" href="perfil.php">

            👤 Perfil

        </a>

        <a class="btn btn-danger btn-menu" href="../auth/logout.php">
            🚪 Cerrar sesión
        </a>
    </div>

    <div class="content">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>
                Mis Clases
            </h2>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalClase">

                ➕ Unirse a Clase

            </button>

        </div>
        <div class="row">

            <?php while ($c = mysqli_fetch_assoc($clases)): ?>

                <div class="col-lg-4 col-md-6 mb-4">

                    <a href="clase.php?id=<?= $c['id'] ?>" style="text-decoration:none;">

                        <div class="card shadow border-0 card-clase">

                            <div class="position-relative">

                                <img src="../profesor/uploads/clases/<?= $c['imagen'] ?>" class="card-img-top portada">

                                <div class="overlay">

                                    <h4><?= $c['nombre'] ?></h4>

                                    <small>
                                        Código:
                                        <?= $c['codigo'] ?>
                                    </small>

                                </div>

                            </div>

                            <div class="card-body">

                                <p class="text-muted">
                                    Haz clic para ingresar
                                </p>

                            </div>

                        </div>

                    </a>

                </div>

            <?php endwhile; ?>

        </div>

    </div>

    <div class="modal fade" id="modalClase">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="unirse_clase.php" method="POST">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Unirse a una Clase
                        </h5>

                    </div>

                    <div class="modal-body">

                        <input type="text" name="codigo" class="form-control" placeholder="Código de clase" required>

                    </div>

                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary">

                            Unirme

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>