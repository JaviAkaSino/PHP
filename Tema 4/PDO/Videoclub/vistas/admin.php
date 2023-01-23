<?php





if (isset($_POST["boton_salir"])) {
    session_unset();
    header("Location:../index.php");
    exit;
}

if (isset($_POST["boton_agregar"])) {





    $mensaje_accion = "Usuario agregado con éxito";
}

if (isset($_POST["boton_editar"])) {



    $mensaje_accion = "Usuario " . $_POST["boton_editar"] . " editado con éxito";
}

if (isset($_POST["boton_borrar"])) {




    $mensaje_accion = "Usuario " . $_POST["boton_borrar"] . " borrado con éxito";
}




?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    <title>Videoclub</title>
</head>

<body>
    <h1>Videoclub</h1>

    <?php

    echo "<p>
            Bienvenido <strong>" . $_SESSION["usuario"] . "</strong> - 
            <form action='index.php' method='post'>
                <button type='submit' name= 'boton_salir'>Salir</button>
            </form>
        </p>";

    echo "<h2>Clientes</h2>";


    if (isset($mensaje_accion)) {
        echo "<p>" . $mensaje_accion . "</p>";
    }


    echo "<h3>Listado de los clientes (no 'admin')</h3>";


    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die(pag_error("Imposible conectar. Error: " . $e->getMessage()));
    }


    try {

        $consulta = "SELECT * FROM clientes WHERE tipo = 'normal'";

        $sentencia = $conexion->prepare($consulta);

        $sentencia->execute();

        $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);


        echo "<table>
                <tr>
                    <th>Usuario</th><th>Foto</th><th></th>
                </tr>";

        foreach ($resultado as $tupla) {

            echo "<tr>";

            echo "<td>" . $tupla["usuario"] . "</td>";
            echo "<td><img width=150px src='Images/" . $tupla["foto"] . "' alt='" . $tupla["foto"] . "'/></td>";
            echo "<td>
                        <form action='index.php' method='post'>
                            <button type='submit' name= 'boton_editar' value='" . $tupla["id_cliente"] . "'>Editar</button>
                             - 
                             <button type='submit' name= 'boton_borrar' value='" . $tupla["id_cliente"] . "'>Borrar</button> 
                        </form>
                        </td>";

            echo "</tr>";
        }

        echo "</table>";


        echo "<h3>Agregar nuevo usuario</h3>";

    ?>

        <form action="index.php" method="post" enctype="multipart/form-data">

            <p>
                <label for="usuario">Nombre del usuario</label>
                <br />
                <input type="text" name="usuario" id="usuario">
            </p>
            <p>
                <label for="clave">Nombre del clave</label>
                <br />
                <input type="password" name="clave" id="clave">
            </p>
            <p>
                <label for="foto">Foto:</label>
                <input type="file" name="foto" id="foto" accept="image/*">
            </p>
            <p>
                <button type="submit" name="boton_agregar">Agregar cliente</button>
            </p>

        </form>

    <?php



    } catch (PDOException $e) {

        $conexion = null;
        $sentencia = null;
        die(pag_error("Imposible realizar consulta. Error: " . $e->getMessage()));
    }

    ?>

</body>

</html>