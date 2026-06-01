<!-- auth/logout.php -->

<?php

session_start();

/* ========================================= */
/* ELIMINAR SESIÓN */
/* ========================================= */

session_unset();

session_destroy();

/* ========================================= */
/* REDIRECT */
/* ========================================= */

header("Location: ../index.php");

exit();

?>