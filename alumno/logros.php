<?php

session_start();

include '../includes/conexion.php';
include '../includes/sidebar.php';

$id_usuario = $_SESSION['id'];

$usuario = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
FROM usuarios
WHERE id=$id_usuario"

    )

);

$xp = $usuario['xp'];

$logros = mysqli_query(

    $conexion,

    "SELECT *
FROM logros
ORDER BY xp_requerida"

);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Logros</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .content {
            margin-left: 300px;
            padding: 35px;
        }

        .logro {

            background: white;

            border-radius: 20px;

            padding: 20px;

            margin-bottom: 15px;

            display: flex;

            align-items: center;

            gap: 20px;

            box-shadow:
                0 4px 12px rgba(0, 0, 0, .05);

        }

        .desbloqueado {
            border-left: 8px solid #22c55e;
        }

        .bloqueado {
            opacity: .6;
        }

        .icono {

            font-size: 3rem;

            min-width: 80px;

            text-align: center;

        }

        .info-logro {
            flex: 1;
        }

        .info-logro h4 {
            margin-bottom: 8px;
            font-weight: 700;
        }

        .estado {
            min-width: 150px;
            text-align: right;
        }
    </style>

</head>

<body>

    <div class="content">

        <h1 class="mb-4">
            🏆 Logros
        </h1>

        <div class="alert alert-primary">

            ⭐ XP Actual:
            <strong><?= $xp ?></strong>

            &nbsp; | &nbsp;

            ⭐ Nivel:
            <strong><?= $usuario['nivel'] ?></strong>

        </div>

        <?php while ($l = mysqli_fetch_assoc($logros)):

            $desbloqueado = $xp >= $l['xp_requerida'];

            $iconos = [

                50 => "🥉",
                250 => "🥈",
                500 => "🥇",
                1000 => "👑",
                5000 => "🔥"

            ];

            $icono = $iconos[$l['xp_requerida']] ?? "🏆";

            ?>

            <div class="logro <?= $desbloqueado ? 'desbloqueado' : 'bloqueado' ?>">

                <div class="icono">
                    <?= $icono ?>
                </div>

                <div class="info-logro">

                    <h4>
                        <?= htmlspecialchars($l['nombre']) ?>
                    </h4>

                    <p class="mb-1">
                        <?= htmlspecialchars($l['descripcion']) ?>
                    </p>

                    <small>
                        Requiere <?= $l['xp_requerida'] ?> XP
                    </small>

                </div>

                <div class="estado">

                    <?php if ($desbloqueado): ?>

                        <span class="badge bg-success">
                            ✅ Desbloqueado
                        </span>

                    <?php else: ?>

                        <span class="badge bg-secondary">
                            🔒 Bloqueado
                        </span>

                    <?php endif; ?>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</body>

</html>