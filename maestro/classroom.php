<?php

session_start();

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
    exit();
}

include "../includes/conexion.php";

if(!isset($_GET['id'])){
    die("Clase no encontrada");
}

$idClase = $_GET['id'];

/* ========================================= */
/* CLASE */
/* ========================================= */

$sql = "SELECT * FROM clases
WHERE id = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i",$idClase);

$stmt->execute();

$resultado = $stmt->get_result();

$clase = $resultado->fetch_assoc();

/* ========================================= */
/* POSTS */
/* ========================================= */

$sqlPosts = "SELECT *
FROM publicaciones
WHERE clase_id = ?
ORDER BY id DESC";

$stmtPosts =
$conexion->prepare($sqlPosts);

$stmtPosts->bind_param(
    "i",
    $idClase
);

$stmtPosts->execute();

$posts =
$stmtPosts->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
<?php echo $clase['nombre']; ?>
</title>

<link rel="stylesheet"
href="../assets/css/maestro.css">

<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap"
rel="stylesheet">

</head>
<body>

<!-- TOPBAR -->

<div class="classroom-topbar">

    <div class="top-left">

        <a href="dashboard.php"
        class="back-btn">

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

    <div class="teacher-avatar">

        <?php

        echo strtoupper(
        substr(
        $_SESSION['nombre'],
        0,
        1
        ));

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

    <a href="#"
    class="active">

        Novedades

    </a>

    <a href="#">

        Trabajo en clase

    </a>

    <a href="#">

        Personas

    </a>

</div>

<!-- CONTENT -->

<div class="classroom-content">

    <!-- LEFT -->

    <div class="left-panel">

        <div class="mini-card">

            <h3>
                Próximas tareas
            </h3>

            <p>

                Revisa las publicaciones
                recientes de la clase.

            </p>

        </div>

    </div>

    <!-- RIGHT -->

    <div class="right-panel">

        <!-- CREATE -->

        <div class="post-box">

            <a href="create_post.php?id=<?php echo $idClase; ?>">

                <button>

                    + Nuevo anuncio

                </button>

            </a>

        </div>

        <!-- POSTS -->

        <?php

        if($posts->num_rows > 0){

            while($post =
            $posts->fetch_assoc()){

        ?>

            <div class="post-card">

                <!-- TOP -->

                <div class="post-top">

                    <div class="avatar">

                        M

                    </div>

                    <div>

                        <h3>

                            Maestro

                        </h3>

                        <span>

                            <?php
                            echo $post['created_at'];
                            ?>

                        </span>

                    </div>

                </div>

                <!-- CONTENT -->

                <div class="post-content">

                    <div class="post-type">

                        <?php

                        echo strtoupper(
                        $post['tipo']
                        );

                        ?>

                    </div>

                    <h2>

                        <?php
                        echo $post['titulo'];
                        ?>

                    </h2>

                    <p>

                        <?php
                        echo $post['descripcion'];
                        ?>

                    </p>

                    <!-- IMAGE -->

                    <?php if($post['imagen'] != ""){ ?>

                        <img src="../uploads/<?php echo $post['imagen']; ?>"
                        class="post-image">

                    <?php } ?>

                    <!-- LINK -->

                    <?php if($post['link'] != ""){ ?>

                        <a href="<?php echo $post['link']; ?>"
                        target="_blank"
                        class="post-link">

                            Abrir link

                        </a>

                    <?php } ?>

                </div>

            </div>

        <?php

            }

        }else{

        ?>

        <!-- EMPTY -->

        <div class="empty-state">

            <h2>

                No hay publicaciones

            </h2>

            <p>

                Crea el primer anuncio
                de esta clase.

            </p>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>