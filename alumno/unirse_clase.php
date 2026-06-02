<?php

session_start();

include '../includes/conexion.php';

$id_alumno = $_SESSION['id'];

if(isset($_POST['codigo'])){

    $codigo = mysqli_real_escape_string(
        $conexion,
        $_POST['codigo']
    );

    $clase = mysqli_fetch_assoc(

        mysqli_query(

            $conexion,

            "SELECT *
             FROM clases
             WHERE codigo='$codigo'"

        )

    );

    if($clase){

        $id_clase = $clase['id'];

        $existe = mysqli_num_rows(

            mysqli_query(

                $conexion,

                "SELECT *
                 FROM alumnos_clases
                 WHERE alumno_id=$id_alumno
                 AND clase_id=$id_clase"

            )

        );

        if($existe == 0){

            mysqli_query(

                $conexion,

                "INSERT INTO alumnos_clases
                (
                    alumno_id,
                    clase_id
                )
                VALUES
                (
                    $id_alumno,
                    $id_clase
                )"

            );

            header("Location: dashboard.php?ok=1");
            exit;

        }else{

            header("Location: dashboard.php?error=ya");
            exit;

        }

    }else{

        header("Location: dashboard.php?error=codigo");
        exit;

    }

}