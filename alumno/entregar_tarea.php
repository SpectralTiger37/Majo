<?php

session_start();

include '../includes/conexion.php';

$tarea_id = intval($_GET['id']);

$alumno_id = $_SESSION['id'];

$existe = mysqli_num_rows(

    mysqli_query(

        $conexion,

        "SELECT *
FROM entregas
WHERE tarea_id=$tarea_id
AND alumno_id=$alumno_id"

    )

);

if ($existe) {

    header("Location: " . $_SERVER['HTTP_REFERER']);

    exit;

}

mysqli_query(

    $conexion,

    "INSERT INTO entregas
(tarea_id, alumno_id, entregado)
VALUES
($tarea_id,$alumno_id,1)"

);

$tarea = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT puntos
FROM tareas
WHERE id=$tarea_id"

    )

);

$puntos = $tarea['puntos'];

mysqli_query(

    $conexion,

    "UPDATE usuarios
SET xp = xp + $puntos
WHERE id=$alumno_id"

);

header("Location: " . $_SERVER['HTTP_REFERER']);