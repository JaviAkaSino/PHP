<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Teoría acceso a BD</title>
</head>

<body>
    <?php


    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_teoria");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("Imposible conectar; Error nº " . mysqli_connect_errno() . ": " . mysqli_connect_error());
    }

    $consulta = "SELECT * FROM t_alumnos";

    try {
        $resultado = mysqli_query($conexion, $consulta);

        //Cuando hago un select, puedo obtener o no tuplas, por lo que hay que limpiar para liberar espacio

        mysqli_free_result($resultado);


        mysqli_close($conexion);
    } catch (Exception $e) {
        $mensaje = "Imposible conectar; Error nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die($mensaje);
    }





    ?>
</body>

</html>