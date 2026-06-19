<?php

session_start();

if (
    !isset($_SESSION['id']) ||
    $_SESSION['rol'] != 'maestro'
) {
    exit;
}

include '../../includes/conexion.php';

$id_clase = intval($_GET['id']);

$clase = mysqli_fetch_assoc(

    mysqli_query(

        $conexion,

        "SELECT *
         FROM clases
         WHERE id = $id_clase"

    )

);

if (!$clase) {

    die("Clase no encontrada");

}

header('Content-Type: text/csv; charset=utf-8');

header(

    'Content-Disposition: attachment; filename="Reporte_' .
    preg_replace('/[^A-Za-z0-9_-]/', '_', $clase['nombre']) .
    '.csv"'

);

$output = fopen('php://output', 'w');

fputcsv($output, [

    'Alumno',
    'Correo',
    'Asistencias',
    'Ausencias',
    'Tareas Entregadas',
    'Tareas Pendientes',
    'Puntos Obtenidos',
    'Calificación Final (%)',
    '% Asistencia'

]);

$alumnos = mysqli_query(

    $conexion,

    "SELECT

    u.id,
    u.nombre,
    u.correo

    FROM alumnos_clases ac

    INNER JOIN usuarios u
    ON ac.alumno_id = u.id

    WHERE ac.clase_id = $id_clase

    ORDER BY u.nombre"

);

while ($a = mysqli_fetch_assoc($alumnos)) {

    $id_alumno = $a['id'];

    /* ASISTENCIAS */

    $asistencias = mysqli_num_rows(

        mysqli_query(

            $conexion,

            "SELECT *
             FROM asistencias
             WHERE alumno_id = $id_alumno
             AND clase_id = $id_clase
             AND asistencia = 1"

        )

    );

    $ausencias = mysqli_num_rows(

        mysqli_query(

            $conexion,

            "SELECT *
             FROM asistencias
             WHERE alumno_id = $id_alumno
             AND clase_id = $id_clase
             AND asistencia = 0"

        )

    );

    /* TAREAS ENTREGADAS */

    $entregadas = mysqli_num_rows(

        mysqli_query(

            $conexion,

            "SELECT e.*

             FROM entregas e

             INNER JOIN tareas t
             ON e.tarea_id = t.id

             WHERE e.alumno_id = $id_alumno
             AND t.clase_id = $id_clase
             AND e.entregado = 1"

        )

    );

    /* TOTAL DE TAREAS */

    $totalTareas = mysqli_num_rows(

        mysqli_query(

            $conexion,

            "SELECT *
             FROM tareas
             WHERE clase_id = $id_clase"

        )

    );

    $pendientes = max(
        0,
        $totalTareas - $entregadas
    );

    /* CALIFICACIÓN FINAL */

    $datos = mysqli_fetch_assoc(

        mysqli_query(

            $conexion,

            "SELECT

            SUM(e.calificacion) AS obtenidos,
            SUM(t.puntos) AS posibles

            FROM entregas e

            INNER JOIN tareas t
            ON e.tarea_id = t.id

            WHERE e.alumno_id = $id_alumno
            AND t.clase_id = $id_clase
            AND e.calificacion IS NOT NULL"

        )

    );

    $obtenidos = $datos['obtenidos'] ?? 0;
    $posibles = $datos['posibles'] ?? 0;

    $puntosObtenidos = round(
        $obtenidos,
        2
    );

    $calificacionFinal =

        $posibles > 0

        ? round(
            ($obtenidos / $posibles) * 100,
            2
        )

        : 0;

    /* PORCENTAJE DE ASISTENCIA */

    $totalAsistencia =
        $asistencias + $ausencias;

    $porcentajeAsistencia =

        $totalAsistencia > 0

        ? round(
            ($asistencias * 100) /
            $totalAsistencia,
            2
        )

        : 0;

    fputcsv($output, [

        $a['nombre'],
        $a['correo'],
        $asistencias,
        $ausencias,
        $entregadas,
        $pendientes,
        $puntosObtenidos,
        $calificacionFinal . '%',
        $porcentajeAsistencia . '%'

    ]);

}

fclose($output);
exit;

?>