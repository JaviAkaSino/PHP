<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 PHP</title>
    <style>
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }

        table,
        th,
        td {

            border-collapse: collapse;
            border: 1px solid black;
        }

        th {
            background-color: grey;
        }
    </style>
</head>

<body>
    <h1>Examen4 PHP</h1>
    <div>
        Bienvenido <strong><?php echo $_SESSION["usuario"]; ?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <h2>Su horario</h2>


    <?php

    //SACAMOS HORARIO
    $url = DIR_SERV . "/horario/" . $datos_usuario_log->id_usuario;

    $respuesta = consumir_servicios_rest($url, "GET", $_SESSION["api_session"]);

    $obj = json_decode($respuesta);

    if (!$obj) {
        $url = DIR_SERV . "/salir";
        consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
        die("<p>Error al consumir servicios REST: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    if (isset($obj->error)) {
        $url = DIR_SERV . "/salir";
        consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
        die("<p>Error en la BD: " . $obj->error);
    }

    if (isset($obj->no_login)) {
        session_unset();
        $_SESSION["seguridad"] = "Tiempo de la API excedido";
        header("Location:index.php");
        exit;

    }

    //Creo array grupos
    foreach ($obj->horario as $tupla) {

        //Si ya hay un grupo se concatena
        if (isset($horario[$tupla->dia][$tupla->hora])) {
            $horario[$tupla->dia][$tupla->hora] .= " / " . $tupla->grupo;
        } else { // Si no, normal
            $horario[$tupla->dia][$tupla->hora] = $tupla->grupo;
        }
    }



    //SI TODO OK, TABLA

    echo "<h3>Horario del Profesor: " . $datos_usuario_log->nombre . "</h3>";

    $dias[] = "";
    $dias[] = "Lunes";
    $dias[] = "Martes";
    $dias[] = "Miércoles";
    $dias[] = "Jueves";
    $dias[] = "Viernes";

    $horas[1] = "8:15 - 9:15";
    $horas[] = "9:15 - 10:15";
    $horas[] = "10:15 - 11:15";
    $horas[] = "11:15 - 11:45";
    $horas[] = "11:45 - 12:45";
    $horas[] = "12:45 - 13:45";
    $horas[] = "13:45 - 14:45";

    echo "<table>";

    echo "<tr>";
    foreach ($dias as $num => $dia) {
        echo "<th>" . $dia . "</th>";
    }

    echo "</tr>";

    foreach ($horas as $num => $hora) {

        echo "<tr>";

        echo "<th>" . $hora . "</th>";

        if ($num == 4) {
            echo "<td colspan='5'>RECREO</td>";
        } else {

            for ($i = 1; $i <= 5; $i++) {
                if (isset($horario[$i][$num]))
                    echo "<td>" . $horario[$i][$num] . "</td>";
                else
                    echo "<td></td>";
            }
        }
        echo "</tr>";
    }
    echo "</table>";

    ?>
</body>

</html>