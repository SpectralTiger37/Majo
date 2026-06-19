<?php

session_start();

if (
    !isset($_SESSION['id']) ||
    $_SESSION['rol'] != 'maestro'
) {
    header("Location: ../../auth/login.html");
    exit;
}

include '../../includes/conexion.php';

$id = intval($_GET['id']);

$tarea = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM tareas
         WHERE id = $id"

    )

);

if (!$tarea) {

    die("Tarea no encontrada");

}

$id_clase = $tarea['clase_id'];

/* Eliminar calificaciones relacionadas */

mysqli_query(

    $conexion,

    "DELETE FROM calificaciones
     WHERE tarea_id = $id"

);

/* Eliminar entregas relacionadas */

mysqli_query(

    $conexion,

    "DELETE FROM entregas
     WHERE tarea_id = $id"

);

/* Eliminar tarea */

mysqli_query(

    $conexion,

    "DELETE FROM tareas
     WHERE id = $id"

);

header(

    "Location: ../clases/clase.php?id=" . $id_clase . "&tab=tareas"

);

exit;

?>