<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

include "../includes/conexion.php";

$id = $_SESSION['id'];

/* ========================================= */
/* UNIRSE A CLASE */
/* ========================================= */

if (isset($_POST['codigo'])) {

    $codigo = $_POST['codigo'];

    $buscar = "SELECT * FROM clases
    WHERE codigo = ?";

    $stmtBuscar =
        $conexion->prepare($buscar);

    $stmtBuscar->bind_param(
        "s",
        $codigo
    );

    $stmtBuscar->execute();

    $resultadoBuscar =
        $stmtBuscar->get_result();

    if ($resultadoBuscar->num_rows > 0) {

        $clase =
            $resultadoBuscar->fetch_assoc();

        $clase_id = $clase['id'];

        /* VALIDAR SI YA ESTÁ */

        $check = "SELECT * FROM alumnos_clases
        WHERE alumno_id = ?
        AND clase_id = ?";

        $stmtCheck =
            $conexion->prepare($check);

        $stmtCheck->bind_param(
            "ii",
            $id,
            $clase_id
        );

        $stmtCheck->execute();

        $resultadoCheck =
            $stmtCheck->get_result();

        if ($resultadoCheck->num_rows == 0) {

            $insert = "INSERT INTO alumnos_clases
            (alumno_id,clase_id)
            VALUES (?,?)";

            $stmtInsert =
                $conexion->prepare($insert);

            $stmtInsert->bind_param(
                "ii",
                $id,
                $clase_id
            );

            $stmtInsert->execute();

        }

    }

}

/* ========================================= */
/* CLASES */
/* ========================================= */

$sql = "SELECT clases.*
FROM clases
INNER JOIN alumnos_clases
ON clases.id = alumnos_clases.clase_id
WHERE alumnos_clases.alumno_id = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mis Clases</title>

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

            <a href="dashboard.php">

                Dashboard

            </a>

            <a href="classes.php" class="active">

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

        <!-- TOPBAR -->

        <div class="topbar">

            <h1>
                Mis Clases
            </h1>

        </div>

        <!-- JOIN CLASS -->

        <div class="join-box">

            <form method="POST">

                <input type="text" name="codigo" placeholder="Ingresa el código de clase">

                <button>

                    Unirse

                </button>

            </form>

        </div>

        <!-- CLASSROOM GRID -->

        <div class="classroom-grid">

            <?php

            if ($resultado->num_rows > 0) {

                while (
                    $clase =
                    $resultado->fetch_assoc()
                ) {

                    ?>

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

                                Plataforma interactiva
                                de seguimiento académico.

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

                    <?php

                }

            } else {

                ?>

                <div class="empty-state">

                    <h2>
                        No estás en ninguna clase
                    </h2>

                    <p>

                        Usa un código para unirte
                        a una clase.

                    </p>

                </div>

            <?php } ?>

        </div>

    </div>

</body>

</html>