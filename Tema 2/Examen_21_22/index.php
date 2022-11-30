<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
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


    try {
        $consulta = "SELECT id_usuario, nombre FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        $mensaje = "<p>No ha sido posible realizar la consulta. Error Nº" . mysqli_errno($conexion) . ":" . mysqli_error($conexion) . "</p></body></html>";
        mysqli_close($conexion);
        die($mensaje);
    }
    ?>

    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="profesor">Seleccione un profesor:</label>
            <select name="profesor" id="profesor">
                <?php
                while ($tupla = mysqli_fetch_assoc($resultado)) {

                    echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
                }
                mysqli_free_result($resultado);
                mysqli_close($conexion);
                ?>
            </select>
            <button name="boton_ver_horario" type="submit">Ver horario</button>
        </p>
    </form>
</body>

</html>