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

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

</head>

<body>


    <nav class="navbar">

        <h2>EduNova</h2>

        <div class="nav-links">

            <a href="#inicio">Inicio</a>

            <a href="#servicios">Servicios</a>

            <button id="openLogin">
                Iniciar sesión
            </button>

        </div>

    </nav>



    <section class="hero" id="inicio">

        <div class="hero-text">

            <h1>
                Sistema académico EduNova
            </h1>

            <p>
                Una plataforma para consultar materias,
                actividades y progreso académico.
            </p>

            <button id="heroLogin">
                Comenzar
            </button>

        </div>


        <div class="hero-box">

            <h3>EduNova</h3>

            <p>
                Tu información académica
                en un solo lugar.
            </p>

            <div class="info">

                <div>

                    <strong>Materias</strong>

                    <span>Consulta tus clases</span>

                </div>


                <div>

                    <strong>Actividades</strong>

                    <span>Revisa tus tareas</span>

                </div>


                <div>

                    <strong>Progreso</strong>

                    <span>Consulta tu avance</span>

                </div>

            </div>

        </div>

    </section>



    <section class="services" id="servicios">

        <h2>
            Servicios
        </h2>

        <p class="description">
            Algunas funciones disponibles dentro de EduNova.
        </p>


        <div class="cards">


            <div class="card">

                <h3>Materias</h3>

                <p>
                    Consulta las materias que tienes registradas.
                </p>

            </div>


            <div class="card">

                <h3>Actividades</h3>

                <p>
                    Revisa las actividades y tareas disponibles.
                </p>

            </div>


            <div class="card">

                <h3>Calificaciones</h3>

                <p>
                    Consulta las calificaciones de tus materias.
                </p>

            </div>


            <div class="card">

                <h3>Progreso</h3>

                <p>
                    Observa tu progreso durante el curso.
                </p>

            </div>


        </div>

    </section>



    <footer>

        <p>
            EduNova - Sistema Académico
        </p>

    </footer>



    <!-- MODAL LOGIN -->

    <div class="modal" id="loginModal">

        <div class="modal-content">


            <div class="tabs">

                <button class="tab active" id="loginTab">

                    Login

                </button>


                <button class="tab" id="signupTab">

                    Registro

                </button>

            </div>



            <!-- LOGIN -->

            <div id="loginForm">

                <h2>
                    Iniciar sesión
                </h2>


                <?php if (isset($_SESSION['error_login'])): ?>

                    <div class="error">

                        <?= htmlspecialchars($_SESSION['error_login']) ?>

                    </div>

                <?php endif; ?>


                <form action="auth/login.php" method="POST">

                    <input type="email" name="correo" placeholder="Correo" required>


                    <input type="password" name="password" placeholder="Contraseña" required>


                    <button type="submit">
                        Entrar
                    </button>

                </form>

            </div>



            <!-- REGISTRO -->

            <div id="signupForm" class="hidden">

                <h2>
                    Crear cuenta
                </h2>


                <form action="auth/signup.php" method="POST">

                    <input type="text" name="nombre" placeholder="Nombre completo" required>


                    <input type="email" name="correo" placeholder="Correo" required>


                    <input type="password" name="password" placeholder="Contraseña" required>


                    <button type="submit">
                        Registrarse
                    </button>

                </form>

            </div>


        </div>

    </div>



    <?php if (isset($_SESSION['error_login'])): ?>

        <script>
            window.errorLogin = true;
        </script>

        <?php unset($_SESSION['error_login']); ?>

    <?php endif; ?>


    <script src="assets/js/index.js"></script>

</body>

</html>