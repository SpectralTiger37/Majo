<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EduNova</title>

    <link rel="stylesheet" href="assets/css/index.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

</head>

<body>

    <nav class="navbar">

        <div class="logo-container">

            <h1 class="logo">
                EduNova
            </h1>

            <div class="divider"></div>

            <span class="system-name">
                Sistema Academico
            </span>

        </div>

        <button class="login-btn" id="openLogin">

            Iniciar sesión

        </button>

    </nav>

    <section class="hero">


        <div class="hero-left">

            <span class="badge">
                NEXT GENERATION ACADEMIC PLATFORM
            </span>

            <h1>

                Transforma el rendimiento académico
                en una experiencia interactiva.

            </h1>

            <p>

                Gestiona clases, monitorea progreso
                estudiantil y analiza métricas académicas
                mediante una plataforma moderna y gamificada.

            </p>

            <div class="hero-buttons">

                <button class="primary-btn">

                    Explorar sistema

                </button>

                <button class="secondary-btn">

                    Ver demostración

                </button>

            </div>


            <div class="stats-container">

                <div class="stat-card">

                    <h2>+12K</h2>

                    <span>
                        Academic Events
                    </span>

                </div>

                <div class="stat-card">

                    <h2>97%</h2>

                    <span>
                        Performance Accuracy
                    </span>

                </div>

                <div class="stat-card">

                    <h2>24/7</h2>

                    <span>
                        Student Tracking
                    </span>

                </div>

            </div>

        </div>


        <div class="hero-right">

            <div class="dashboard-preview">


                <div class="dashboard-top">

                    <div class="top-dots">

                        <span></span>
                        <span></span>
                        <span></span>

                    </div>

                    <div class="dashboard-title">

                        spectral.dashboard

                    </div>

                </div>


                <div class="dashboard-content">

                    <div class="preview-card">

                        <h3>LEVEL</h3>

                        <p>18</p>

                    </div>


                    <div class="preview-card">

                        <h3>XP</h3>

                        <p>2450</p>

                    </div>


                    <div class="preview-card">

                        <h3>STATUS</h3>

                        <p class="stable">

                            STABLE

                        </p>

                    </div>



                    <div class="chart-card">

                        <div class="fake-chart">

                            <div class="line"></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <div class="modal" id="loginModal">

        <div class="modal-content auth-box">

            <div class="auth-tabs">

                <button class="tab-btn active" id="loginTab">

                    Login

                </button>

                <button class="tab-btn" id="signupTab">

                    Sign Up

                </button>

            </div>


            <div class="auth-form" id="loginForm">

                <h2>
                    ACCESS SYSTEM
                </h2>

                <form action="auth/login.php" method="POST">
                    <?php if (isset($_SESSION['error_login'])): ?>

                        <div style="
background:#ffebee;
color:#c62828;
padding:10px;
border-radius:10px;
margin-bottom:15px;
text-align:center;">

                            <?= $_SESSION['error_login'] ?>

                        </div>

                    <?php endif; ?>


                    <input type="email" name="correo" placeholder="Email" required>

                    <input type="password" name="password" placeholder="Password" required>

                    <button type="submit">

                        LOGIN

                    </button>

                </form>
                <?php if (isset($_SESSION['error_login'])): ?>

                    <script>

                        document.addEventListener("DOMContentLoaded", () => {

                            document.getElementById("loginModal")
                                .style.display = "flex";

                        });

                    </script>

                    <?php
                    unset($_SESSION['error_login']);
                endif;
                ?>

                <p class="teacher-text">

                    Teacher accounts require
                    institutional authorization.

                </p>

            </div>

            <div class="auth-form hidden" id="signupForm">

                <h2>
                    CREATE ACCOUNT
                </h2>

                <form action="auth/signup.php" method="POST">

                    <input type="text" name="nombre" placeholder="Full Name" required>

                    <input type="email" name="correo" placeholder="Email" required>

                    <input type="password" name="password" placeholder="Password" required>

                    <button type="submit">

                        CREATE ACCOUNT

                    </button>

                </form>

                <p class="teacher-text">

                    Student registration only.

                </p>

            </div>

        </div>

    </div>

    <script src="assets/js/index.js"></script>
    <?php if (isset($_SESSION['error_login'])): ?>

        <script>

            document.addEventListener("DOMContentLoaded", () => {

                document.getElementById("loginModal")
                    .style.display = "flex";

            });

        </script>

        <?php
        unset($_SESSION['error_login']);
    endif;
    ?>

</body>

</html>