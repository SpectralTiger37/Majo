<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

include "../includes/conexion.php";

$id = $_SESSION['id'];

/* ========================================= */
/* USUARIO */
/* ========================================= */

$sql = "SELECT * FROM usuarios
WHERE id = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();

$usuario = $resultado->fetch_assoc();

/* ========================================= */
/* XP Y NIVEL */
/* ========================================= */

$xp = $usuario['xp'];

$nivel = floor($xp / 100) + 1;

/* ========================================= */
/* STATUS */
/* ========================================= */

$status = "BIEN";
$statusColor = "#7bffb2";

if ($xp < 300) {

    $status = "MASO MENOS";
    $statusColor = "#ffd36b";

}

if ($xp < 100) {

    $status = "MAL";
    $statusColor = "#ff6b81";

}

/* ========================================= */
/* CLASES */
/* ========================================= */

$sqlClases = "SELECT clases.*
FROM clases
INNER JOIN alumnos_clases
ON clases.id = alumnos_clases.clase_id
WHERE alumnos_clases.alumno_id = ?";

$stmtClases = $conexion->prepare($sqlClases);

$stmtClases->bind_param("i", $id);

$stmtClases->execute();

$clases = $stmtClases->get_result();

/* ========================================= */
/* FALTAS */
/* ========================================= */

$sqlFaltas = "SELECT COUNT(*) AS faltas
FROM asistencias
WHERE alumno_id = ?
AND asistencia = 0";

$stmtFaltas = $conexion->prepare($sqlFaltas);

$stmtFaltas->bind_param("i", $id);

$stmtFaltas->execute();

$faltasResultado =
    $stmtFaltas->get_result();

$faltas =
    $faltasResultado->fetch_assoc()['faltas'];

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SPECTRAL Dashboard</title>

    <link rel="stylesheet" href="../assets/css/alumno.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

</head>

<body>

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="sidebar-logo">

            SPECTRAL

        </div>

        <div class="sidebar-menu">

            <a href="dashboard.php" class="active">

                Dashboard

            </a>

            <a href="classes.php">

                Clases

            </a>

            <a href="tasks.php">

                Tareas

            </a>

            <a href="faltas.php">

                Faltas

            </a>

            <a href="../auth/logout.php">

                Cerrar sesión

            </a>

        </div>

    </div>

    <!-- MAIN -->

    <div class="main">

        <!-- NAVBAR -->

        <div class="topbar">

            <div>

                <h1>
                    Página principal
                </h1>

            </div>

            <div class="user-info">

                <!-- STATUS -->

                <div class="status-box">

                    <span class="status-dot" style="background:
                <?php echo $statusColor; ?>">
                    </span>

                    <?php echo $status; ?>

                </div>

                <!-- LEVEL -->

                <div class="level-circle">

                    <?php echo $nivel; ?>

                </div>

            </div>

        </div>

        <!-- STATS -->

        <div class="stats-grid">

            <div class="stat-card">

                <h3>XP</h3>

                <p>
                    <?php echo $xp; ?>
                </p>

            </div>

            <div class="stat-card">

                <h3>FALTAS</h3>

                <p>
                    <?php echo $faltas; ?>
                </p>

            </div>

            <div class="stat-card">

                <h3>NIVEL</h3>

                <p>
                    <?php echo $nivel; ?>
                </p>

            </div>

        </div>

        <!-- CLASSROOM -->

        <div class="classroom-grid">

            <?php while ($clase = $clases->fetch_assoc()) { ?>

                <div class="class-card">

                    <div class="class-header">

                        <h2>

                            <?php
                            echo $clase['nombre'];
                            ?>

                        </h2>

                        <span>

                            Código:
                            <?php
                            echo $clase['codigo'];
                            ?>

                        </span>

                    </div>

                    <div class="class-body">

                        <p>
                            Sistema académico
                            interactivo.
                        </p>

                    </div>

                    <div class="class-footer">

                        <a href="classroom.php?id=<?php echo $clase['id']; ?>">

                            <button>

                                Entrar

                            </button>

                        </a>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</body>

</html>