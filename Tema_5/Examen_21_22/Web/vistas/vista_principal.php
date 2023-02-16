<?php

if (isset($_POST["quitar_grupo"])) {

    $url = DIR_SERV . "/borrarGrupo/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["profesores"] . "/" . $_POST["quitar_grupo"];
    $respuesta = consumir_servicios_rest($url, "DELETE");
    $obj = json_decode($respuesta);

    if (!$obj) {
        $url = DIR_SERV . "/salir";
        consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("Examen4 PHP", "<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta));
    }

    if (isset($obj->error)) {
        $url = DIR_SERV . "/salir";
        consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("Examen4 PHP", "<h1>Examen4 PHP</h1><p>" . $obj->error . "</p>"));
    }

    if (isset($obj->no_login)) {
        session_unset();
        $_SESSION["seguridad"] = "Tiempo API excedido";
        header("Location:index.php");
        exit;
    }



    $_SESSION["mensaje_accion"] = $obj->mensaje;

    $_SESSION["profesor"] = $_POST["profesores"];
    $_SESSION["dia"] = $_POST["dia"];
    $_SESSION["hora"] = $_POST["hora"];

    header("Location:index.php");
    exit;
}


if (isset($_POST["add_grupo"])) {

    $url = DIR_SERV . "/insertarGrupo/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["profesores"] . "/" . $_POST["grupos_libres"];
    $respuesta = consumir_servicios_rest($url, "POST");
    $obj = json_decode($respuesta);

    if (!$obj) {
        $url = DIR_SERV . "/salir";
        consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("Examen4 PHP", "<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta));
    }

    if (isset($obj->error)) {
        $url = DIR_SERV . "/salir";
        consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("Examen4 PHP", "<h1>Examen4 PHP</h1><p>" . $obj->error . "</p>"));
    }

    if (isset($obj->no_login)) {
    }

    $_SESSION["mensaje_accion"] = $obj->mensaje;

    $_SESSION["profesor"] = $_POST["profesores"];
    $_SESSION["dia"] = $_POST["dia"];
    $_SESSION["hora"] = $_POST["hora"];

    header("Location:index.php");
    exit;
}


?>

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

    <?php
    // Sacamos los usuarios

    $url = DIR_SERV . "/usuarios";
    $respuesta = consumir_servicios_rest($url, "GET", $_SESSION["api_session"]);
    $obj = json_decode($respuesta);

    if (!$obj) {
        $url = DIR_SERV . "/salir";
        consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
        die("<p>Error al consumir servicios REST: " . $url . "</p>" . $respuesta);
    }

    if (isset($obj->error)) {
        $url = DIR_SERV . "/salir";
        consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
        die("<p>" . $obj->error . "</p>");
    }



    //Si todo OK, select
    echo "<form action='index.php' method='post'>";
    echo "<label for ='profesores'>Selecciona el Profesor: </label>";
    echo "<select id='profesores' name='profesores'>";

    foreach ($obj->usuarios as $tupla) {

        if ((isset($_POST["profesores"]) && $_POST["profesores"] == $tupla->id_usuario) || isset($_SESSION["profesor"]) && $_SESSION["profesor"] == $tupla->id_usuario) {
            echo "<option selected value='" . $tupla->id_usuario . "'>$tupla->nombre</option>";
            $profe = $tupla;
        } else
            echo "<option value='" . $tupla->id_usuario . "'>$tupla->nombre</option>";
    }

    echo "</select>";
    echo "<button name='ver_horario'>Ver Horario</button>";
    echo "</form>";

    if (isset($_POST["profesores"]) || isset($_SESSION["profesor"])) { //Cuando se pulse ver horario

        if (isset($_SESSION["profesor"])) {
            $profesor = $_SESSION["profesor"];
            unset($_SESSION["profesor"]);
        } else
            $profesor = $_POST["profesores"];

        //SACAMOS SU HORARIO
        $url = DIR_SERV . "/horario/" . $profesor;

        $respuesta = consumir_servicios_rest($url, "GET", $_SESSION["api_session"]);

        $obj = json_decode($respuesta);

        if (!$obj) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
            session_destroy();
            die("<p>Error al consumir servicios REST: " . $url . "</p>" . $respuesta . "</body></html>");
        }

        if (isset($obj->error)) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
            session_destroy();
            die("<p>Error en la BD: " . $obj->error);
        }

        if (isset($obj->no_login)) {
            //NO hace falta salir de la api
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

        echo "<h3>Horario del Profesor: " . $profe->nombre . "</h3>";

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

                    echo "<td>";

                    if (isset($horario[$i][$num]))
                        echo $horario[$i][$num];

                    echo "<form action='index.php' method='post'>
                            <button name='editar_hora' class='enlace'>Editar</button>
                            <input type='hidden' name='dia' value='" . $i . "'/>
                            <input type='hidden' name='hora' value='" . $num . "'/>
                            <input type='hidden' name='profesores' value='" . $profesor . "'/>
                        </form>";
                    echo "</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";


        if (isset($_POST["dia"]) || isset($_SESSION["dia"])) {

            // SACAMOS LOS GRUPOS
            if (isset($_SESSION["dia"])) {
                $dia = $_SESSION["dia"];
                $hora = $_SESSION["hora"];

                unset($_SESSION["dia"]);
                unset($_SESSION["hora"]);
            } else {

                $dia = $_POST["dia"];
                $hora = $_POST["hora"];
            }



            $url = DIR_SERV . "/grupos/" . $dia . "/" . $hora . "/" . $profesor;
            $respuesta = consumir_servicios_rest($url, "GET", $_SESSION["api_session"]);
            $obj = json_decode($respuesta);

            if (!$obj) {
                $url = DIR_SERV . "/salir";
                consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
                session_destroy();
                die("<p>Error al consumir servicios REST: " . $url . "</p>" . $respuesta . "</body></html>");
            }

            if (isset($obj->error)) {
                $url = DIR_SERV . "/salir";
                consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
                session_destroy();
                die("<p>Error en la BD: " . $obj->error);
            }

            if (isset($obj->no_login)) {
                //NO hace falta salir de la api
                session_unset();
                $_SESSION["seguridad"] = "Tiempo de la API excedido";
                header("Location:index.php");
                exit;
            }


            //Si todo OK TABLA
            $numero_hora =  $hora;
            if ($hora > 4)
                $numero_hora -= 1;

            echo "<h2>Editando la " . $numero_hora . "ª hora (" . $horas[$hora] . ") del " . $dias[$dia] . "</h2>";

            if (isset($_SESSION["mensaje_accion"])) {

                echo "<p>" . $_SESSION["mensaje_accion"] . "</p>";
                unset($_SESSION["mensaje_accion"]);
            }


            echo "<table>
                    <tr><th>Grupo</th><th>Acción</th></tr>";

            foreach ($obj->grupos as $tupla) {
                echo "<tr>
                        <td>" . $tupla->nombre . "</td>
                        <td>
                            <form method='post' action='index.php'>
                                <button name='quitar_grupo' value='" . $tupla->id_grupo . "' class='enlace'>Quitar</button>
                                <input type='hidden' name='dia' value='" . $dia . "'/>
                                <input type='hidden' name='hora' value='" . $hora . "'/>
                                <input type='hidden' name='profesores' value='" . $profesor . "'/>
                            </form>
                        </td>
                    </tr>";
            }

            echo "</table><br/>";


            //SACAMOS GRUPOS LIBRES

            $url = DIR_SERV . "/gruposLibres/" . $dia . "/" . $hora . "/" . $profesor;
            $respuesta = consumir_servicios_rest($url, "GET", $_SESSION["api_session"]);
            $obj = json_decode($respuesta);

            if (!$obj) {
                $url_salir = DIR_SERV . "/salir";
                consumir_servicios_rest($url_salir, "POST", $_SESSION["api_session"]);
                session_destroy();
                die("<p>Error al consumir servicios REST: " . $url . "</p>" . $respuesta . "</body></html>");
            }

            if (isset($obj->error)) {
                $url_salir = DIR_SERV . "/salir";
                consumir_servicios_rest($url_salir, "POST", $_SESSION["api_session"]);
                session_destroy();
                die("<p>Error en la BD: " . $obj->error);
            }

            if (isset($obj->no_login)) {
                //NO hace falta salir de la api
                session_unset();
                $_SESSION["seguridad"] = "Tiempo de la API excedido";
                header("Location:index.php");
                exit;
            }

            //SI TODO OK, SELECT

            echo "<form action='index.php' method='post'>";
            echo "<select name='grupos_libres' id='grupos_libres' >";

            foreach ($obj->grupos_libres as $tupla) {

                if (isset($_POST["grupos_libres"]) && $_POST["grupos_libres"] == $tupla->id_grupo) {
                    echo "<option selected value='" . $tupla->id_grupo . "'>" . $tupla->nombre . "</option>";
                } else {
                    echo "<option value='" . $tupla->id_grupo . "'>" . $tupla->nombre . "</option>";
                }
            }
            echo "</select>";

            echo "<button name ='add_grupo'>Añadir</button>
                <input type='hidden' name='dia' value='" . $dia . "'/>
                <input type='hidden' name='hora' value='" . $hora . "'/>
                <input type='hidden' name='profesores' value='" . $profesor . "'/>";


            echo "</form>";
        }
    }

    ?>

</body>

</html>