<!-- REEMPLAZA TODO classroom.php POR ESTO -->

<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

include "../includes/conexion.php";

if (!isset($_GET['id'])) {
    die("Clase no encontrada");
}

$clase_id = $_GET['id'];

/* ========================================= */
/* CLASE */
/* ========================================= */

$sql = "SELECT * FROM clases
WHERE id = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $clase_id);

$stmt->execute();

$resultado = $stmt->get_result();

$clase = $resultado->fetch_assoc();

/* ========================================= */
/* TAB */
/* ========================================= */

$tab = "novedades";

if (isset($_GET['tab'])) {

    $tab = $_GET['tab'];

}

/* ========================================= */
/* TAREAS */
/* ========================================= */

$sqlTareas = "SELECT * FROM tareas
WHERE clase_id = ?";

$stmtTareas =
    $conexion->prepare($sqlTareas);

$stmtTareas->bind_param(
    "i",
    $clase_id
);

$stmtTareas->execute();

$tareas =
    $stmtTareas->get_result();

/* ========================================= */
/* PERSONAS */
/* ========================================= */

$sqlPersonas = "SELECT usuarios.*
FROM usuarios
INNER JOIN alumnos_clases
ON usuarios.id = alumnos_clases.alumno_id
WHERE alumnos_clases.clase_id = ?";

$stmtPersonas =
    $conexion->prepare($sqlPersonas);

$stmtPersonas->bind_param(
    "i",
    $clase_id
);

$stmtPersonas->execute();

$personas =
    $stmtPersonas->get_result();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $clase['nombre']; ?>
    </title>

    <link rel="stylesheet" href="../assets/css/classroom.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

</head>

<body>

    <!-- TOPBAR -->

    <div class="classroom-topbar">

        <div class="top-left">

            <a href="classes.php" class="back-btn">

                ← Regresar

            </a>

            <div class="classroom-title">

                <h1>

                    <?php
                    echo $clase['nombre'];
                    ?>

                </h1>

                <span>

                    Código:
                    <?php
                    echo $clase['codigo'];
                    ?>

                </span>

            </div>

        </div>

        <div class="user-circle">

            <?php
            echo strtoupper(
                substr(
                    $_SESSION['nombre'],
                    0,
                    1
                )
            );
            ?>

        </div>

    </div>

    <!-- HERO -->

    <div class="class-hero">

        <div class="hero-overlay">

            <h2>

                <?php
                echo $clase['nombre'];
                ?>

            </h2>

            <p>
                Sistema académico interactivo.
            </p>

        </div>

    </div>

    <!-- NAV -->

    <div class="class-nav">

        <a href="?id=<?php echo $clase_id; ?>&tab=novedades" class="<?php
           if ($tab == 'novedades') {
               echo 'active';
           }
           ?>">

            Novedades

        </a>

        <a href="?id=<?php echo $clase_id; ?>&tab=trabajo" class="<?php
           if ($tab == 'trabajo') {
               echo 'active';
           }
           ?>">

            Trabajo en clase

        </a>

        <a href="?id=<?php echo $clase_id; ?>&tab=personas" class="<?php
           if ($tab == 'personas') {
               echo 'active';
           }
           ?>">

            Personas

        </a>

    </div>

    <!-- CONTENT -->

    <div class="classroom-content">

        <?php

        /* ========================================= */
        /* NOVEDADES */
        /* ========================================= */

        if ($tab == "novedades") {

            ?>

            <!-- LEFT -->

            <div class="left-panel">

                <div class="mini-card">

                    <h3>
                        Próximas tareas
                    </h3>

                    <p>

                        Revisa el apartado
                        de trabajo en clase.

                    </p>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="right-panel">

                <div class="post-box">



                </div>

                <div class="post-card">

                    <div class="post-top">

                        <div class="avatar">

                            M

                        </div>

                        <div>

                            <h3>
                                Maestro
                            </h3>

                            <span>
                                Hoy
                            </span>

                        </div>

                    </div>

                    <div class="post-content">

                        <h2>

                            Bienvenidos a la clase

                        </h2>

                        <p>

                            Aquí aparecerán
                            anuncios importantes,
                            tareas y actividades.

                        </p>

                    </div>

                </div>

            </div>

        <?php } ?>

        <!-- ========================================= -->
        <!-- TRABAJO EN CLASE -->
        <!-- ========================================= -->

        <?php

        if ($tab == "trabajo") {

            ?>

            <div class="tasks-section">

                <div class="tasks-grid">

                    <?php

                    if ($tareas->num_rows > 0) {

                        while (
                            $tarea =
                            $tareas->fetch_assoc()
                        ) {

                            ?>

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
                                    para aumentar tu experiencia.

                                </p>

                                <div class="task-footer">

                                    <button>

                                        Entregar

                                    </button>

                                </div>

                            </div>

                            <?php

                        }

                    } else {

                        ?>

                        <div class="empty-state">

                            <h2>

                                No hay tareas

                            </h2>

                            <p>

                                El maestro aún no
                                publica actividades.

                            </p>

                        </div>

                    <?php } ?>

                </div>

            </div>

        <?php } ?>

        <!-- ========================================= -->
        <!-- PERSONAS -->
        <!-- ========================================= -->

        <?php

        if ($tab == "personas") {

            ?>

            <div class="people-section">

                <div class="people-box">

                    <h2>
                        Alumnos
                    </h2>

                    <?php

                    while (
                        $persona =
                        $personas->fetch_assoc()
                    ) {

                        ?>

                        <div class="person-item">

                            <div class="person-avatar">

                                <?php

                                echo strtoupper(
                                    substr(
                                        $persona['nombre'],
                                        0,
                                        1
                                    )
                                );

                                ?>

                            </div>

                            <span>

                                <?php
                                echo $persona['nombre'];
                                ?>

                            </span>

                        </div>

                    <?php } ?>

                </div>

            </div>

        <?php } ?>

    </div>

</body>

</html>