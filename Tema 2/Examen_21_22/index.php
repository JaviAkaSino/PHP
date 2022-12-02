<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
    <style>
        table {
            text-align: center;
            border-collapse: collapse;
        }

        table,
        td,
        th {
            padding: 0.5rem 0.2rem;
            border: 1px solid black;
        }

        th {
            background-color: #AAA;
        }
    </style>
</head>

<body>
    <h1>Examen2 PHP 21 - 22</h1>
    <h2>Horario de los Profesores</h2>

    <?php
    //Realizamos la conexión
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_horarios_exam");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        $mensaje = "<p>No ha sido posible realizar la conexión. Error Nº" . mysqli_connect_errno() . ":" . mysqli_connect_error() . "</p></body></html>";
        die($mensaje);
    }


//AÑADIR GRUPO

if (isset($_POST["boton_add"])) {

    try { //Lista de los usuarios
        $consulta = "INSERT INTO horario_lectivo (usuario, dia, hora, grupo, aula) VALUES ('".$_POST["profesor"]."', '".$_POST["dia"]."', '".$_POST["hora"]."', '".$_POST["grupo"]."', 'AÑADIDA')";
        mysqli_query($conexion, $consulta);
        $mensaje_accion = "Grupo añadido con éxito";
    } catch (Exception $e) {
        $mensaje = "<p>No ha sido posible añadir el grupo. Error Nº" . mysqli_errno($conexion) . " :" . mysqli_error($conexion) . "</p></body></html>";
        mysqli_close($conexion);
        die($consulta);
    }
}



    //BORRAR GRUPO

    if (isset($_POST["boton_borrar"])) {

        try { //Lista de los usuarios
            $consulta = "DELETE FROM horario_lectivo WHERE id_horario = '" . $_POST["boton_borrar"] . "'";
            mysqli_query($conexion, $consulta);
            $mensaje_accion = "Grupo eliminado con éxito";
        } catch (Exception $e) {
            $mensaje = "<p>No ha sido posible realizar la consulta. Error Nº" . mysqli_errno($conexion) . ":" . mysqli_error($conexion) . "</p></body></html>";
            mysqli_close($conexion);
            die($mensaje);
        }
    }

    try { //Lista de los usuarios
        $consulta = "SELECT id_usuario, nombre FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        $mensaje = "<p>No ha sido posible realizar la consulta. Error Nº" . mysqli_errno($conexion) . ":" . mysqli_error($conexion) . "</p></body></html>";
        mysqli_close($conexion);
        die($mensaje);
    }

    if (mysqli_num_rows($resultado) < 1) { //Si no hay ningún profesor

        echo "<p class='mensaje'>No existe ningún registro de profesores en la base de datos</p>";
    } else { //Si hay profesores

    ?>

        <form action="index.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="profesor">Seleccione un profesor:</label>
                <select name="profesor" id="profesor">
                    <?php
                    while ($tupla = mysqli_fetch_assoc($resultado)) {
                        //Mantiene el profesor seleccionado si lo hay
                        if ((isset($_POST["profesor"]) && $_POST["profesor"] == $tupla["id_usuario"])) {
                            echo "<option value='" . $tupla["id_usuario"] . "' selected >" . $tupla["nombre"] . "</option>";
                            $nombre_profesor = $tupla["nombre"]; //Guardamos su nombre
                        } else
                            echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
                    }

                    ?>
                </select>
                <button name="boton_ver_horario" type="submit">Ver horario</button>
            </p>
        </form>

    <?php

        if (isset($_POST["boton_ver_horario"]) || isset($_POST["boton_editar"]) || isset($_POST["boton_borrar"]) || isset($_POST["boton_add"])) { //Cuando se pulse el boton ver horario

            echo "<h2>Horario del profesor: " . $nombre_profesor . "</h2>";


            try { //Sacamos el array $horario

                $consulta = "SELECT horario_lectivo.dia, horario_lectivo.hora, grupos.nombre 
                                FROM horario_lectivo, grupos 
                                WHERE grupos.id_grupo = horario_lectivo.grupo
                                    AND usuario = '" . $_POST["profesor"] . "'";

                $resultado = mysqli_query($conexion, $consulta);

                while ($tupla = mysqli_fetch_assoc($resultado)) {
                    //Si ya hay algún grupo, concatena
                    if (isset($horario[$tupla["dia"]][$tupla["hora"]]))
                        $horario[$tupla["dia"]][$tupla["hora"]] .= "/" . $tupla["nombre"];
                    else //Si no, guarda
                        $horario[$tupla["dia"]][$tupla["hora"]] = $tupla["nombre"];
                }
            } catch (Exception $e) {
                $mensaje = "<p>No ha sido posible realizar la consulta. Error Nº" . mysqli_errno($conexion) . ":" . mysqli_error($conexion) . "</p></body></html>";
                mysqli_close($conexion);
                die($mensaje);
            }
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
            for ($i = 0; $i < count($dias); $i++) {

                echo "<th>";
                echo $dias[$i];
                echo "</th>";
            }



            for ($hora = 1; $hora <= count($horas); $hora++) {

                echo "<tr>";
                echo "<th>" . $horas[$hora] . "</th>"; //Hora - hora

                if ($hora == 4) { //Si es el recreo
                    echo "<td colspan='5'>RECERO</td>";
                } else { //Para las horas normales

                    for ($dia = 1; $dia < 6; $dia++) { //Para los 5 días de la semana

                        echo "<td>";

                        if (isset($horario[$dia][$hora])) {
                            echo "<p>" . $horario[$dia][$hora] . "</p>";
                        }

                        //Botón de editar
                        echo "<form action='index.php' method='post'> 
                                <button type='submit' name='boton_editar'/>Editar</button>
                                <input type='hidden' name='hora' value='" . $hora . "'/>
                                <input type='hidden' name='dia' value='" . $dia . "'/>
                                <input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/>
                            </form>";

                        echo "</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        //Una vez terminada la tabla
        if (isset($_POST["boton_editar"]) || isset($_POST["boton_borrar"]) || isset($_POST["boton_add"])) {

            //Sacamos la hora (1ª, 2ª...)
            $numero_hora = $_POST["hora"];
            if ($numero_hora > 3) //Quitamos una despues del recreo
                $numero_hora--;

            //Sacamos el rango de hora
            $rango_hora = $horas[$_POST["hora"]];

            //TITULO EDICION
            echo "<h2>Editando la " . $numero_hora . "ª hora (" . $rango_hora . ") del " . $dias[$_POST["dia"]] . "</h2>";

            //MENSAJE DE ACCIÓN
            if (isset($mensaje_accion))
                echo "<p>" . $mensaje_accion . "</p>";


            //DATOS DE LA TABLA DE EDICION
            try {
                $consulta = "SELECT grupos.nombre, grupos.id_grupo, horario_lectivo.id_horario
                                FROM grupos, horario_lectivo
                                WHERE horario_lectivo.grupo = grupos.id_grupo
                                    AND horario_lectivo.usuario = '" . $_POST["profesor"] . "'
                                    AND horario_lectivo.dia = '" . $_POST["dia"] . "'
                                    AND horario_lectivo.hora = '" . $_POST["hora"] . "'";

                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                $mensaje = "<p>Imposible realizar la consulta. Error Nº" . mysqli_errno($conexion) . ":" . mysqli_error($conexion) . "</p></body></html>";
                mysqli_close($conexion);
                die($mensaje);
            }

            $grupos = []; //Guardaremos aquí los id de los grupos para la tabla añadir

            //TABLA DE EDICIÓN
            echo "<table>";
            echo "<tr><th>Grupo</th><th>Acción</th></tr>";

            while ($tupla = mysqli_fetch_assoc($resultado)) {
                $grupos[] = $tupla["id_grupo"]; //Guardamos cada grupo

                echo "<tr>";
                echo "<td>" . $tupla["nombre"] . "</td>";
                echo "<td>
                            <form action='index.php' method='post'>
                                <button name='boton_borrar' value='" . $tupla["id_horario"] . "' type='submit'>Borrar</button>
                                <input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/>
                                <input type='hidden' name='dia' value='" . $_POST["dia"] . "'/>
                                <input type='hidden' name='hora' value='" . $_POST["hora"] . "'/>              
                            </form>    
                        </td>";
                echo "</tr>";
            }
            echo "</table>";

            //DATOS DEL SELECT DEL FINAL CON LOS GRUPOS
            try {
                $clausula_where = "";
                if (count($grupos) > 0) //Si hay algún grupo
                    $clausula_where = " WHERE id_grupo NOT IN (" . implode(", ", $grupos) . ")";
                //GRUPOS POSIBLES DE AÑADIR
                $consulta = "SELECT * FROM grupos " . $clausula_where;
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                $mensaje = "<p>No ha sido posible realizar la consulta. Error Nº" . mysqli_errno($conexion) . ":" . mysqli_error($conexion) . "</p></body></html>";
                mysqli_close($conexion);
                die($mensaje);
            }

            if (mysqli_num_rows($resultado) > 0) { //  Si el profesor no tiene ya todos los grupos (casi imposible)

                echo "<form action='index.php' method='post'><p>";
                echo "<select name='grupo'>";
                    while( $tupla = mysqli_fetch_assoc($resultado))
                    echo "<option value='".$tupla["id_grupo"]."'>".$tupla["nombre"]."</option>";

                echo "</select>";
                echo "<button name='boton_add' type='submit'>Añadir</button>";
                echo "<input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/>";
                echo "<input type='hidden' name='dia' value='" . $_POST["dia"] . "'/>";
                echo "<input type='hidden' name='hora' value='" . $_POST["hora"] . "'/>";
                echo "</p></form>";
            }
        }
    } //Haya resultados o no, tras operar liberamos y cerramos
    mysqli_free_result($resultado);
    mysqli_close($conexion);


    ?>
</body>

</html>