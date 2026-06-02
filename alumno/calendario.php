<?php

session_start();


include '../includes/conexion.php';
include '../includes/sidebar.php';
?>

<!DOCTYPE html>
<html>

<head>

    <title>Calendario</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .content {
            margin-left: 300px;
            padding: 35px;
        }

        .card-evento {

            background: white;

            border-radius: 20px;

            padding: 20px;

            margin-bottom: 15px;

            box-shadow:
                0 5px 15px rgba(0, 0, 0, .05);

        }
        #calendar{

    background:white;

    padding:20px;

    border-radius:25px;

    box-shadow:
    0 5px 20px rgba(0,0,0,.06);

}
    </style>

</head>

<body>

    <div class="content">

        <h2>

            📅 Calendario Académico

        </h2>

        <div id="calendar"></div>
        <?php

        $eventos = [];

        $tareas = mysqli_query(

            $conexion,

            "SELECT
t.titulo,
t.fecha_entrega
FROM tareas t"

        );

        while ($t = mysqli_fetch_assoc($tareas)) {

            $eventos[] = [

                'title' => '📄 ' . $t['titulo'],
                'start' => $t['fecha_entrega']

            ];

        }

        ?>
        <?php

        $tareas = mysqli_query(

            $conexion,

            "SELECT

t.*,
c.nombre AS clase

FROM tareas t

INNER JOIN clases c
ON t.clase_id=c.id

ORDER BY fecha_entrega ASC"

        );

        ?>
        <?php while ($t = mysqli_fetch_assoc($tareas)): ?>

            <div class="card-evento">

                <h5>

                    📄 <?= $t['titulo'] ?>

                </h5>

                <p>

                    Clase:
                    <strong>

                        <?= $t['clase'] ?>

                    </strong>

                </p>

                <p>

                    Fecha:

                    <?= $t['fecha_entrega'] ?>

                </p>

            </div>

        <?php endwhile; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>

document.addEventListener('DOMContentLoaded', function(){

    var calendarEl =
    document.getElementById('calendar');

    var calendar =
    new FullCalendar.Calendar(

        calendarEl,

        {

            initialView:'dayGridMonth',

            locale:'es',

            events:
            <?= json_encode($eventos) ?>

        }

    );

    calendar.render();

});

</script>
</body>

</html>