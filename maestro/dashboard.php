<?php

session_start();

if(!isset($_SESSION['id'])){

    header("Location: ../index.php");
    exit();

}

include "../includes/conexion.php";

$id = $_SESSION['id'];

/* ========================================= */
/* MAESTRO */
/* ========================================= */

$sql = "SELECT * FROM usuarios
WHERE id = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i",$id);

$stmt->execute();

$resultado = $stmt->get_result();

$maestro = $resultado->fetch_assoc();

/* ========================================= */
/* CLASES */
/* ========================================= */

$sqlClases = "SELECT *
FROM clases
WHERE maestro_id = ?";

$stmtClases =
$conexion->prepare($sqlClases);

$stmtClases->bind_param("i",$id);

$stmtClases->execute();

$clases =
$stmtClases->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Panel Maestro</title>

<link rel="stylesheet"
href="../assets/css/maestro.css">

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

        <a href="dashboard.php"
        class="active">

            Dashboard

        </a>

        <a href="create_class.php">

            Crear clase

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

                Panel Maestro

            </h1>

            <p class="subtitle">

                Bienvenido,
                <?php
                echo $maestro['nombre'];
                ?>

            </p>

        </div>

        <div class="teacher-avatar">

            <?php

            echo strtoupper(
            substr(
            $maestro['nombre'],
            0,
            1
            ));

            ?>

        </div>

    </div>

    <!-- STATS -->

    <div class="stats-grid">

        <div class="stat-card">

            <h3>

                CLASES

            </h3>

            <p>

                <?php
                echo $clases->num_rows;
                ?>

            </p>

        </div>

        <div class="stat-card">

            <h3>

                STATUS

            </h3>

            <p>

                ACTIVO

            </p>

        </div>

    </div>

    <!-- CLASES -->

    <div class="classroom-grid">

    <?php

    if($clases->num_rows > 0){

        while($clase =
        $clases->fetch_assoc()){

    ?>

        <div class="class-card">

            <!-- HEADER -->

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

            <!-- BODY -->

            <div class="class-body">

                <p>

                    Gestiona alumnos,
                    tareas y anuncios.

                </p>

            </div>

            <!-- FOOTER -->

            <div class="class-footer">

                <a href="classroom.php?id=<?php echo $clase['id']; ?>">

                    <button>

                        Administrar

                    </button>

                </a>

            </div>

        </div>

    <?php

        }

    }else{

    ?>

        <div class="empty-state">

            <h2>

                No tienes clases

            </h2>

            <p>

                Crea una clase
                para comenzar.

            </p>

        </div>

    <?php } ?>

    </div>

</div>

</body>
</html>