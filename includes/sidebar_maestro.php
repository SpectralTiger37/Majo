<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

include_once __DIR__.'/conexion.php';

$id_usuario = $_SESSION['id'];

$usuario = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM usuarios
         WHERE id=$id_usuario"

    )

);

$paginaActual = basename($_SERVER['PHP_SELF']);

$rutaBase = "/Majo";

?>

<style>

.sidebar{

    position:fixed;

    top:0;
    left:0;

    width:280px;

    height:100vh;

    background:white;

    padding:25px;

    overflow-y:auto;

    box-shadow:
    0 0 25px rgba(0,0,0,.08);

    z-index:1000;

}

.foto-perfil{

    width:100px;

    height:100px;

    border-radius:50%;

    object-fit:cover;

    border:4px solid #4f46e5;

    display:block;

    margin:auto;

}

.sidebar h4{

    text-align:center;

    margin-top:15px;

    font-weight:700;

}

.sidebar h6{

    text-align:center;

    color:#6b7280;

}

.btn-menu{

    display:block;

    width:100%;

    padding:14px 18px;

    margin-bottom:10px;

    border-radius:14px;

    text-decoration:none;

    color:#333;

    background:#f3f4f6;

    transition:.3s;

}

.btn-menu:hover{

    background:#4f46e5;

    color:white;

}

.btn-menu.active{

    background:#4f46e5;

    color:white;

}

.btn-danger-menu{

    background:#dc3545;

    color:white !important;

}

.btn-danger-menu:hover{

    background:#bb2d3b;

}

.sidebar hr{

    margin:20px 0;

}

.sidebar::-webkit-scrollbar{

    width:6px;

}

.sidebar::-webkit-scrollbar-thumb{

    background:#4f46e5;

    border-radius:20px;

}

</style>

<div class="sidebar">

    <img

    class="foto-perfil"

    src="<?= !empty($usuario['foto'])
? $rutaBase.'/profesor/uploads/perfil/'.$usuario['foto']
: 'https://ui-avatars.com/api/?name='.urlencode($usuario['nombre']).'&background=4f46e5&color=ffffff'
?>"

    alt="Perfil">

    <h4>

        <?= htmlspecialchars($usuario['nombre']) ?>

    </h4>

    <h6>

        👨‍🏫 Maestro

    </h6>

    <hr>

  <a href="<?= $rutaBase ?>/profesor/dashboard.php" class="btn-menu">
    📊 Dashboard
</a>

<a href="<?= $rutaBase ?>/profesor/clases/crear.php" class="btn-menu">
    ➕ Crear Clase
</a>

<a href="<?= $rutaBase ?>/profesor/clases/ver.php" class="btn-menu">
    📚 Mis Clases
</a>

<a href="<?= $rutaBase ?>/profesor/asistencias/historial.php" class="btn-menu">
    ✅ Asistencias
</a>

<a href="<?= $rutaBase ?>/profesor/reportes/excel.php" class="btn-menu">
    📊 Reportes
</a>

<a href="<?= $rutaBase ?>/profesor/perfil.php" class="btn-menu">
    👤 Perfil
</a>

<a href="<?= $rutaBase ?>/auth/logout.php" class="btn-menu btn-danger-menu">
    🚪 Cerrar sesión
</a>

</div>