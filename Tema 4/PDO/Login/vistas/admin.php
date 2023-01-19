<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login con PDO - ADMIN</title>
</head>

<body>
    <h1>Login con PDO</h1>

    <div>
        <form class="en_linea" action="index.php" method="post">
            <label><strong><?php echo $datos_usuario_log["usuario"] ?></strong> - </label>
            <button type="submit" name="boton_salir">Salir</button>
        </form>
    </div>


    <?php

    try {

        $consulta = "SELECT * FROM usuarios WHERE tipo <>'admin'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia = null; //Libera sentencia

        echo "<h3>Usuarios: </h3>";

        echo "<table>";
        echo "<tr>
                <th>Nombre</th>
                <th>Usuario</th>
            </tr>";

        foreach ($respuesta as $tupla) {

            echo "<tr>
                    <td>" . $tupla["nombre"] . "</td>
                    <td>" . $tupla["usuario"] . "</td>
                </tr>";
        }

        echo "</table>";
    } catch (PDOException $e) {

        session_destroy(); //Borramos la sesión (deslogeo)
        $sentencia = null; //Libera sentencia
        $conexion = null; //Cierra conexión
        die("<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>");
    }

    ?>


</body>

</html>