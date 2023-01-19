<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 2 DWESE Curso 22-23</title>
</head>

<body>
    <h1>Notas de los alumnos</h1>

    <?php

    //Conexion
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_exam_colegio");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>Error en la conexión a la bbdd Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error()."</p></body></html>");
    }


    //Consulta alumnos

    try {
        $consulta = "SELECT nombre, cod_alu FROM alumnos";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        $mensaje = "Imposible realizar consulta. Error " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die($mensaje);
    }


    if (mysqli_num_rows($resultado) > 0) { //Si hay alumnos los enseña

        echo "<form action='index.php'  method='post'>
                    <label for='alumno'>Seleccione un alumno</label>
                    <select name='alumno' id='alumno'>";

        while ($tupla = mysqli_fetch_assoc($resultado)) {
            if ($_POST["alumno"] == $tupla["cod_alu"]) {
                echo "<option value='" . $tupla["cod_alu"] . "' selected>" . $tupla["nombre"] . "</option>";
                $nombre = $tupla["nombre"];
            } else
                echo "<option value='" . $tupla["cod_alu"] . "'>" . $tupla["nombre"] . "</option>";
        }

        echo "</select>";

        echo " <button type='submit' name='boton_ver' >Ver notas</button>";
        if (isset($nombre)) {
            echo "<input type='hidden' name ='nombre' value= '" . $nombre . "'/>";
        }

        echo "</form>";

        mysqli_free_result($resultado);
    } else { //Si no hay alumnos, mensaje
        echo "<p>En estos momentos no tenemos ningún alumno registrado en la BD</p>";
    }

    /****************BORRAR****************/

    if (isset($_POST["boton_borrar"])) {

        try {
            $consulta = "DELETE FROM notas WHERE cod_asig = '" . $_POST['boton_borrar'] . "' AND cod_alu ='" . $_POST['alumno'] . "'";
            mysqli_query($conexion, $consulta);

            $mensaje_accion = "¡¡Asignatura descalificada con éxito!!";
        } catch (Exception $e) {
            $mensaje = "Imposible realizar consulta. Error " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die($mensaje);
        }
    }


    /**************************BOTON CAMBIAR******************** */

    if (isset($_POST["boton_cambiar"])) {

        $error_nota = !is_numeric($_POST["nota_nueva"]) || $_POST["nota_nueva"] < 0 || $_POST["nota_nueva"] > 10;


        if (!$error_nota) {

            try {
                $consulta = "UPDATE notas SET nota = '" . $_POST["nota_nueva"] . "' WHERE cod_asig = '" . $_POST['boton_cambiar'] . "' AND cod_alu ='" . $_POST['alumno'] . "'";
                mysqli_query($conexion, $consulta);

                $mensaje_accion = "¡¡Nota cambiada con éxito!!";
            } catch (Exception $e) {
                $mensaje = "Imposible realizar consulta. Error " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                mysqli_close($conexion);
                die($mensaje);
            }
        }
    }


    /****************************CALIFICAR ************ */

    if(isset($_POST["boton_calificar"])){

        try {
            $consulta = "INSERT INTO notas (cod_asig, cod_alu, nota) VALUES (".$_POST["asignatura"].", ".$_POST["alumno"].", 0)";
            mysqli_query($conexion, $consulta);

            $mensaje_accion = "Nota calificada con un 0. Cambie la nota si lo estima necesario";
        } catch (Exception $e) {
            $mensaje = "Imposible realizar consulta. Error " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die($mensaje);
        }

    }

    /************************VISTA NOTAS ********************* */

    if (isset($_POST["boton_ver"]) || isset($_POST["boton_borrar"]) || isset($_POST["boton_editar"]) || isset($_POST["boton_cambiar"]) || isset($_POST["boton_atras"]) || isset($_POST["boton_calificar"])) {


        try {
            $consulta = "SELECT notas.nota, asignaturas.denominacion, notas.cod_asig
                        FROM notas, asignaturas
                        WHERE notas.cod_asig = asignaturas.cod_asig
                        AND notas.cod_alu = '" . $_POST['alumno'] . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            $mensaje = "Imposible realizar consulta. Error " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die($mensaje);
        }

        echo "<h2>Notas del alumno " . $nombre . "</h2>";

        /***************TABLA NOTAS*****************/

        $calificadas = [];

        echo "<table>";
        echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";

        while ($tupla = mysqli_fetch_assoc($resultado)) {

            echo "<tr><td>" . $tupla["denominacion"] . "</td>";

            //SI SE PULSA EDITAR
            if ((isset($_POST["boton_cambiar"]) && $error_nota) || (isset($_POST["boton_editar"]) && $_POST["boton_editar"] == $tupla["cod_asig"]) || isset($_POST["boton_calificar"])) {

                echo "<form action='index.php' method='post'>";



                if (isset($_POST["boton_cambiar"]) && $error_nota) {

                    echo    "<td><input type='text' name = 'nota_nueva' placeholder='Teclee un valor entre 0 y 10'/>";
                    echo "<p class='error'>* No has introducido un valor válido de nota *</p>";
                } else {
                    echo    "<td><input type='text' name = 'nota_nueva' value='" . $tupla["nota"] . "'/>";
                }



                echo        "</td>";
                echo "<td>
                    
                    <button name='boton_cambiar' value='" . $tupla["cod_asig"] . "'type='submit'>Cambiar</button>
                     - 
                    <button name='boton_atras' value='" . $tupla["cod_asig"] . "'type='submit'>Atras</button>

                    <input type='hidden' name='alumno' value='" . $_POST['alumno'] . "'/>
                    </form>
                </td></tr>";
            } else { //SI NO NORMAL

                echo    "<td>" . $tupla["nota"] . "</td>
                <td>
                    <form action='index.php' method='post'>
                    <button name='boton_editar' value='" . $tupla["cod_asig"] . "'type='submit'>Editar</button>
                     - 
                    <button name='boton_borrar' value='" . $tupla["cod_asig"] . "'type='submit'>Borrar</button>

                    <input type='hidden' name='alumno' value='" . $_POST['alumno'] . "'/>
                    </form>
                </td></tr>";
            }

            $calificadas[] = $tupla["cod_asig"];
        }

        echo "</table>";
        mysqli_free_result($resultado);



        /*************MENSAJE DE ACCION **********************/

        if (isset($mensaje_accion))
            echo "<p class='accion'>" . $mensaje_accion . "</p>";


        /****************ASIGNATURAS POR CALIFICAR*****************/

        //SACA TODAS LAS ASIGNATURAS QUE NO ESTEN YA CALIFICADAS

        try {
            if (count($calificadas)>0)
            $consulta = "SELECT * FROM asignaturas WHERE cod_asig NOT IN (" . implode(", ", $calificadas) . ")";
            else
            $consulta = "SELECT * FROM asignaturas WHERE cod_asig";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            $mensaje = "Imposible realizar consulta. Error " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die($mensaje);
        }

        if (mysqli_num_rows($resultado) > 0) {

            echo "<p></p>";

            echo "<form action='index.php'  method='post'>
            <label for='asignatura'>Asignaturas que a <strong>" . $nombre . "</strong> aún le quedan por calificar: </label>
            <select name='asignatura' id='asignatura'>";

            while ($tupla = mysqli_fetch_assoc($resultado)) {
                if ($_POST["asignatura"] == $tupla["cod_asig"]) {
                    echo "<option value='" . $tupla["cod_asig"] . "' selected>" . $tupla["denominacion"] . "</option>";
                } else
                    echo "<option value='" . $tupla["cod_asig"] . "'>" . $tupla["denominacion"] . "</option>";
            }

            echo "</select>";


            echo " <button type='submit' name='boton_calificar' >Calificar</button>";
            echo "<input type='hidden' name ='alumno' value= '" . $_POST["alumno"] . "'/>";
            if (isset($nombre)) {
                echo "<input type='hidden' name ='nombre' value= '" . $nombre . "'/>";
            }

            echo "</form>";

            mysqli_free_result($resultado);
        } else {

            echo "<p>A <strong>" . $nombre . "</strong> no le quedan asignaturas por calificar</p>";
        }
    }


    ?>



</body>

</html>