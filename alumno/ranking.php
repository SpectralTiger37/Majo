<?php

session_start();

include '../includes/conexion.php';

$id_usuario = $_SESSION['id'];

$ranking = mysqli_query(
    $conexion,
    "SELECT id,nombre,nivel,xp
     FROM usuarios
     WHERE rol='alumno'
     ORDER BY xp DESC"
);

$usuarios = [];

while ($u = mysqli_fetch_assoc($ranking)) {
    $usuarios[] = $u;
}

$miPosicion = 0;
$posicion = 1;

foreach ($usuarios as $u) {

    if ($u['id'] == $id_usuario) {

        $miPosicion = $posicion;
        break;

    }

    $posicion++;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ranking</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .content {
            margin-left: 300px;
            padding: 35px;
        }

        .titulo {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .mi-posicion {
            background: white;
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .05);
        }

        .podio {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 40px;
        }

        .top {
            background: white;
            border-radius: 25px;
            text-align: center;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .05);
        }

        .primero {
            width: 220px;
            min-height: 220px;
        }

        .segundo {
            width: 180px;
            min-height: 180px;
        }

        .tercero {
            width: 180px;
            min-height: 160px;
        }

        .ranking-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .05);
        }

        .posicion {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4f46e5;
        }

        .usuario {
            font-size: 1.1rem;
            font-weight: 600;
        }
    </style>

</head>

<body>

    <?php include '../includes/sidebar.php'; ?>

    <div class="content">

        <h1 class="titulo">
            🥇 Ranking Spectral
        </h1>

        <div class="mi-posicion">

            📍 Tu posición actual:
            <strong>#<?= $miPosicion ?></strong>

        </div>

        <?php if (count($usuarios) >= 3): ?>

            <div class="podio">

                <div class="top segundo">

                    <h2>🥈</h2>

                    <h4><?= htmlspecialchars($usuarios[1]['nombre']) ?></h4>

                    <p>
                        <?= $usuarios[1]['xp'] ?> XP
                    </p>

                </div>

                <div class="top primero">

                    <h1>🥇</h1>

                    <h3><?= htmlspecialchars($usuarios[0]['nombre']) ?></h3>

                    <p>
                        <?= $usuarios[0]['xp'] ?> XP
                    </p>

                </div>

                <div class="top tercero">

                    <h2>🥉</h2>

                    <h4><?= htmlspecialchars($usuarios[2]['nombre']) ?></h4>

                    <p>
                        <?= $usuarios[2]['xp'] ?> XP
                    </p>

                </div>

            </div>

        <?php endif; ?>

        <?php

        $posicion = 1;

        foreach ($usuarios as $u):

            ?>

            <div class="ranking-card">

                <div>

                    <span class="posicion">

                        #<?= $posicion ?>

                    </span>

                    &nbsp;&nbsp;

                    <span class="usuario">

                        <?= htmlspecialchars($u['nombre']) ?>

                    </span>

                </div>

                <div>

                    Nivel <?= $u['nivel'] ?> ⭐

                    &nbsp;|&nbsp;

                    <?= $u['xp'] ?> XP

                </div>

            </div>

            <?php

            $posicion++;

        endforeach;

        ?>

    </div>

</body>

</html>