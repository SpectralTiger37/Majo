<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id_usuario = $_SESSION['id'];

$usuario = mysqli_fetch_assoc(

    mysqli_query(
        $conexion,
        "SELECT *
         FROM usuarios
         WHERE id = $id_usuario"
    )

);

$xpActual = $usuario['xp'] ?? 0;

$xpNivel = 1000;

$xpActualNivel = $xpActual % $xpNivel;

$porcentaje = ($xpActualNivel / $xpNivel) * 100;

$paginaActual = basename($_SERVER['PHP_SELF']);

?>

<style>

.sidebar{

    position:fixed;

    left:0;
    top:0;

    width:280px;

    height:100vh;

    overflow-y:auto;

    background:white;

    padding:25px;

    box-shadow:
    0 0 25px rgba(0,0,0,.08);

}

.sidebar img{

    width:100px !important;

    height:100px !important;

    min-width:100px !important;

    min-height:100px !important;

    border-radius:50% !important;

    object-fit:cover !important;

    display:block !important;

    margin:auto !important;

}

.sidebar h4{

    margin-top:15px;

    font-weight:700;
}

.sidebar h6{

    color:#6b7280;
}

.xp-bar{

    height:18px;

    border-radius:20px;
}

.progress-bar{

    background:#4f46e5;
}

.btn-menu{

    display:block;

    width:100%;

    text-align:left;

    padding:14px 18px;

    margin-bottom:10px;

    border-radius:14px;

    text-decoration:none;

    color:#333;

    transition:.3s;

}

.btn-menu.active{

    background:#4f46e5;

    color:white;
}

.btn-menu:hover{

    background:#4f46e5;

    color:white;
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

    <center>

        <img
        src="../uploads/default.png"
        alt="Perfil">

        <h4>

            <?= htmlspecialchars($usuario['nombre']) ?>

        </h4>

        <h6>

            Nivel <?= $usuario['nivel'] ?>

        </h6>

    </center>

    <div class="progress xp-bar mt-3">

        <div
        class="progress-bar"
        style="width:<?= $porcentaje ?>%">
        </div>

    </div>

    <center class="mt-2">

        <?= $xpActualNivel ?>

        /

        <?= $xpNivel ?>

        XP

    </center>

    <hr>

    <a
    href="dashboard.php"
    class="btn-menu <?= $paginaActual == 'dashboard.php' ? 'active' : '' ?>">

        🏠 Dashboard

    </a>

    <a
    href="mis_clases.php"
    class="btn-menu <?= $paginaActual == 'mis_clases.php' ? 'active' : '' ?>">

        📚 Mis Clases

    </a>

    <a
    href="calendario.php"
    class="btn-menu <?= $paginaActual == 'calendario.php' ? 'active' : '' ?>">

        📅 Calendario

    </a>

    <a
    href="logros.php"
    class="btn-menu <?= $paginaActual == 'logros.php' ? 'active' : '' ?>">

        🏆 Logros

    </a>

    <a
    href="ranking.php"
    class="btn-menu <?= $paginaActual == 'ranking.php' ? 'active' : '' ?>">

        🥇 Ranking

    </a>

    <a
    href="../auth/logout.php"
    class="btn-menu">

        🚪 Cerrar sesión

    </a>

</div>