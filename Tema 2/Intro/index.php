<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Teoría acceso a BD</title>
    <style>
        table, th, td{
            border: 1px solid black;         
        }
        table{
            width: 80%;
            border-collapse: collapse;
            text-align: center;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <?php


    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_teoria");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("Imposible conectar; Error nº " . mysqli_connect_errno() . ": " . mysqli_connect_error());
    }

    $consulta = "SELECT * FROM t_alumnos"; //Creamos la consulta SQL

    try {
        $resultado = mysqli_query($conexion, $consulta); //Crea la query con la conexión y la consulta
        //var_dump($resultado);

        echo "<p><strong>Nº de tuplas obtenidas: </strong>".mysqli_num_rows($resultado)."</p>";

        $tupla = mysqli_fetch_row($resultado); //Guarda en un array una fila
        var_dump($tupla);
        echo "<p><strong>Nombre: </strong>".$tupla[1]."</p>";

        $tupla = mysqli_fetch_assoc($resultado); //Igual pero asociativa
        var_dump($tupla);
        echo "<p><strong>Nombre: </strong>".$tupla["nombre"]."</p>";

        $tupla = mysqli_fetch_array($resultado); //Trae ambas
        var_dump($tupla);
        echo "<p><strong>Nombre: </strong>".$tupla[1]."</p>";
        echo "<p><strong>Nombre: </strong>".$tupla["nombre"]."</p>";

        $tupla = mysqli_fetch_object($resultado); //Crea un objeto con tantas props como columnas
        var_dump($tupla);
        echo "<p><strong>Nombre: </strong>".$tupla->nombre."</p>";

        mysqli_data_seek($resultado, 0); //Vuelve al índice que le pasemos

        echo "<table>";

            echo "<tr>
                    <th>Código Alumno</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Código Postal</th>
                </tr>";

            while ($tupla = mysqli_fetch_assoc($resultado)){

                echo "<tr>";
                    echo "<td>".$tupla["cod_alu"]."</td>";
                    echo "<td>".$tupla["nombre"]."</td>";
                    echo "<td>".$tupla["telefono"]."</td>";
                    echo "<td>".$tupla["cp"]."</td>";
                echo "</tr>";
            }

        echo "</table>";


        mysqli_free_result($resultado); //Liberamos espacio por usar consulta
        mysqli_close($conexion); //Y cerramos conexión

    } catch (Exception $e) {
        //Guarda mensaje
        $mensaje = "Imposible conectar; Error nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        
        mysqli_close($conexion); //Cierra conexión

        die($mensaje);
    }





    ?>
</body>

</html>