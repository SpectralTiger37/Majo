<?php

session_start();

if(
    !isset($_SESSION['id']) ||
    $_SESSION['rol'] != 'maestro'
){
    header("Location: ../../auth/login.html");
    exit;
}

include '../../includes/conexion.php';

$id_clase = intval($_GET['id']);
$id_maestro = $_SESSION['id'];

/* Verificar que la clase pertenece al maestro */

$clase = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM clases
         WHERE id = $id_clase
         AND maestro_id = $id_maestro"

    )

);

if(!$clase){

    die("Clase no encontrada");

}

/* Eliminar imagen */

if(!empty($clase['imagen'])){

    $rutaImagen =
    "../uploads/clases/" .
    $clase['imagen'];

    if(file_exists($rutaImagen)){

        unlink($rutaImagen);

    }

}

/* Eliminar alumnos inscritos */

mysqli_query(

    $conexion,

    "DELETE FROM alumnos_clases
     WHERE clase_id = $id_clase"

);

/* Eliminar asistencias */

mysqli_query(

    $conexion,

    "DELETE FROM asistencias
     WHERE clase_id = $id_clase"

);


/* Eliminar tareas */

mysqli_query(

    $conexion,

    "DELETE FROM tareas
     WHERE clase_id = $id_clase"

);

/* Eliminar publicaciones */

mysqli_query(

    $conexion,

    "DELETE FROM publicaciones
     WHERE clase_id = $id_clase"

);

/* Finalmente eliminar clase */

mysqli_query(

    $conexion,

    "DELETE FROM clases
     WHERE id = $id_clase"

);

header("Location: ver.php");
exit;