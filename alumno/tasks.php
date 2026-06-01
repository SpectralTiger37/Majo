<?php

session_start();

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
    exit();
}

include "../includes/conexion.php";

$id = $_SESSION['id'];

/* ========================================= */
/* TAREAS */
/* ========================================= */

$sql = "SELECT tareas.*
FROM tareas
INNER JOIN clases
ON tareas.clase_id = clases.id
INNER JOIN alumnos_clases
ON clases.id = alumnos_clases.clase_id
WHERE alumnos_clases.alumno_id = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i",$id);

$stmt->execute();

$resultado = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Tareas</title>

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

        <a href="tasks.php"
        class="active">

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

    <!-- TOPBAR -->

    <div class="topbar">

        <h1>
            Tareas
        </h1>

    </div>

    <!-- TASK GRID -->

    <div class="tasks-grid">

    <?php

    if($resultado->num_rows > 0){

        while($tarea =
        $resultado->fetch_assoc()){

    ?>

        <!-- TASK CARD -->

        <div class="task-card">

            <div class="task-top">

                <span class="task-badge">

                    TASK

                </span>

                <span class="xp-badge">

                    +<?php
                    echo $tarea['puntos'];
                    ?> XP

                </span>

            </div>

            <h2>

                <?php
                echo $tarea['titulo'];
                ?>

            </h2>

            <p>

                Completa esta actividad
                para ganar experiencia
                y subir de nivel.

            </p>

            <div class="task-footer">

                <button>

                    Entregar

                </button>

            </div>

        </div>

    <?php

        }

    }else{

    ?>

        <!-- EMPTY -->

        <div class="empty-state">

            <h2>

                No tienes tareas

            </h2>

            <p>

                Las tareas aparecerán aquí
                cuando un maestro las publique.

            </p>

        </div>

    <?php } ?>

    </div>

</div>

</body>
</html>