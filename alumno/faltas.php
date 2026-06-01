<?php

session_start();

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
    exit();
}

include "../includes/conexion.php";

$id = $_SESSION['id'];

/* ========================================= */
/* FALTAS */
/* ========================================= */

$sql = "SELECT *
FROM asistencias
WHERE alumno_id = ?
AND asistencia = 0
ORDER BY fecha DESC";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i",$id);

$stmt->execute();

$resultado = $stmt->get_result();

/* ========================================= */
/* TOTAL */
/* ========================================= */

$totalFaltas =
$resultado->num_rows;

/* ========================================= */
/* STATUS */
/* ========================================= */

$status = "BIEN";
$statusColor = "#7bffb2";

if($totalFaltas >= 3){

    $status = "MASO MENOS";
    $statusColor = "#ffd36b";

}

if($totalFaltas >= 6){

    $status = "MAL";
    $statusColor = "#ff6b81";

}

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Faltas</title>

<link rel="stylesheet"
href="../assets/css/alumno.css">

<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap"
rel="stylesheet">

</head>
<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <div class="sidebar-logo">

        SPECTRAL

    </div>

    <div class="sidebar-menu">

        <a href="dashboard.php">

            Dashboard

        </a>

        <a href="classes.php">

            Clases

        </a>

        <a href="tasks.php">

            Tareas

        </a>

        <a href="faltas.php"
        class="active">

            Faltas

        </a>

        <a href="../auth/logout.php">

            Cerrar sesión

        </a>

    </div>

</div>

<!-- MAIN -->

<div class="main">

    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h1>
                Faltas
            </h1>

            <p class="subtitle">

                Historial de asistencias
                registradas.

            </p>

        </div>

        <!-- STATUS -->

        <div class="status-box">

            <span class="status-dot"
            style="background:
            <?php echo $statusColor; ?>">
            </span>

            <?php echo $status; ?>

        </div>

    </div>

    <!-- STATS -->

    <div class="stats-grid">

        <!-- TOTAL -->

        <div class="stat-card">

            <h3>
                TOTAL DE FALTAS
            </h3>

            <p>

                <?php
                echo $totalFaltas;
                ?>

            </p>

        </div>

        <!-- STATUS -->

        <div class="stat-card">

            <h3>
                STATUS
            </h3>

            <p style="color:
            <?php echo $statusColor; ?>">

                <?php
                echo $status;
                ?>

            </p>

        </div>

        <!-- ALERTA -->

        <div class="stat-card">

            <h3>
                ALERTA
            </h3>

            <p>

                <?php

                if($totalFaltas >= 6){

                    echo "RIESGO";

                }else{

                    echo "ESTABLE";

                }

                ?>

            </p>

        </div>

    </div>

    <!-- FALTAS -->

    <div class="faltas-grid">

    <?php

    if($resultado->num_rows > 0){

        while($falta =
        $resultado->fetch_assoc()){

    ?>

        <!-- CARD -->

        <div class="falta-card">

            <div class="falta-top">

                <span class="falta-badge">

                    FALTA

                </span>

            </div>

            <h2>

                Inasistencia registrada

            </h2>

            <p>

                Fecha:
                <?php
                echo $falta['fecha'];
                ?>

            </p>

        </div>

    <?php

        }

    }else{

    ?>

        <!-- EMPTY -->

        <div class="empty-state">

            <h2>

                No tienes faltas

            </h2>

            <p>

                Excelente asistencia 😮‍💨

            </p>

        </div>

    <?php } ?>

    </div>

</div>

</body>
</html>