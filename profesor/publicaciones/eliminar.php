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

$publicacion = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM publicaciones
         WHERE id = $id"

    )

);

if (!$publicacion) {

    die("Publicación no encontrada");

}

$id_clase = $publicacion['clase_id'];


if (!empty($publicacion['imagen'])) {

    $rutaImagen =
        __DIR__ .
        "/../uploads/publicaciones/" .
        $publicacion['imagen'];

    if (file_exists($rutaImagen)) {

        unlink($rutaImagen);

    }

}


mysqli_query(

    $conexion,

    "DELETE FROM publicaciones
     WHERE id = $id"

);


header(

    "Location: ../clases/clase.php?id=" . $id_clase . "&tab=publicaciones"

);

exit;

?>