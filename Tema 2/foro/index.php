<?php
require "src/bd_config.php";

function pag_error($title, $encabezado, $mensaje)
{

    return "<!DOCTYPE html>
    <html lang='es''>
    <head>
        <meta charset='UTF-8'>
        <title>" . $title . "</title>
    </head>
    <body>
        <h1>" . $encabezado . "</h1><p>" . $mensaje . "</p>
    </body>
    </html>";
}

function repetido($conexion, $tabla, $columna, $valor)
{

    $consulta = "select " . $columna . " from " . $tabla . " where " . $columna . " = '" . $valor . "'";

    try {

        $resultado = mysqli_query($conexion, $consulta);

        $respuesta = mysqli_num_rows($resultado) > 0;

        mysqli_free_result($resultado);
    } catch (Exception $e) {
        $respuesta = "Imposible conectar. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
    }

    return $respuesta;
}

if (isset($_POST["boton_confirma_borrar"])) {

    try {

        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        die(pag_error("Prácitca 1º CRUD", "Nuevo Usuario", "Imposible conectar. Error Nº " .
            mysqli_connect_errno() . ": " . mysqli_connect_error()));
    }

    $consulta = "DELETE FROM usuarios WHERE id_usuario='" . $_POST["boton_confirma_borrar"] . "'";

    try {

        $resultado = mysqli_query($conexion, $consulta);
        $mensaje_accion = "Usuario borrado con éxito";
        //No cerramos conexión para seuir con la web

    } catch (Exception $e) {

        $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die(pag_error("Prácitca 1º CRUD", "Nuevo Usuario", $consulta . $mensaje));
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Foro</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;

        }

        .texto-centrado {
            text-align: center;
        }

        .centrar {
            margin: 1em auto;
            width: 80%;
        }

        table img {
            width: 50px;
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
        }

        .boton-accion {

            border: none;
            background: none;
        }
    </style>
</head>

<body>
    <h1 class="texto-centrado">Listado de usuarios</h1>
    <?php
    if (!isset($conexion)) { //Si ya de ha borrado ya está creada la conexión

        try {

            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {

            die("<p>Imposible conectar. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");
        }
    }



    $consulta = "SELECT * FROM usuarios";

    try {

        $resultado = mysqli_query($conexion, $consulta);
        echo "<table class='texto-centrado centrar'>";
        echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";

        while ($tupla = mysqli_fetch_assoc($resultado)) {

            echo "<tr>";
            echo "<td><form action='index.php' method='post'><button type= 'submit' name='boton_listar' 
                value='" . $tupla["id_usuario"] . "' class='enlace'>" . $tupla["nombre"] . "</button></form></td>";

            echo "<td><form action='index.php' method='post'>
                    <input type='hidden' name='nombre' value='" . $tupla["nombre"] . "'/>
                    <button type='submit' name='boton_borrar' value='" . $tupla["id_usuario"] . "' class='boton-accion'>
                        <img src='img/delete.png' alt='borrar' title='borrar'/>
                    </button></form></td>";
            echo "<td><form action='index.php' method='post'>
                    <button type='submit' name='boton_editar' value='" . $tupla["id_usuario"] . "' class='boton-accion'>
                        <img src='img/edit.png' alt='editar' title='editar'/>
                    </button></form></td></tr>";
        }
        echo "</table>";

        mysqli_free_result($resultado);

        if (isset($_POST["usuario_nuevo"]))
            echo "<p class='centrar'>Usuario registrado con éxito</p>";

        if (isset($mensaje_accion))
            echo "<p class='centrar'>" . $mensaje_accion . "</p>";

        if (isset($_POST["boton_listar"])) {

            echo "<h2 class='centrar'>Listado del Usuario " . $_POST["boton_listar"] . "</h2>";
            $consulta = "SELECT * FROM usuarios WHERE id_usuario = '" . $_POST["boton_listar"] . "'";

            try {

                $resultado = mysqli_query($conexion, $consulta);

                echo "<div class='centrar'>";

                if (mysqli_num_rows($resultado) > 0) {

                    $datos_usuario = mysqli_fetch_assoc($resultado);
                    echo "<p><strong>Nombre: </strong>" . $datos_usuario["nombre"] . "</p>";
                    echo "<p><strong>Usuario: </strong>" . $datos_usuario["usuario"] . "</p>";
                    echo "<p><strong>E-mail: </strong>" . $datos_usuario["email"] . "</p>";
                } else {
                    echo "<p>El usuario seleccionado ya no se encuentra registrado</p>";
                }
                echo "<form method='post' action='index.php'>";
                echo "<p><button type='submit'>Volver</button></p>";
                echo "</form>";
                echo "</div>";

                mysqli_free_result($resultado);
            } catch (Exception $e) {

                $mensaje = "<p>Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p>";
                mysqli_close($conexion);
                die($mensaje);
            }
        } elseif (isset($_POST["boton_borrar"])) {

            echo "<p class='centrar'>Se dispone a eliminar al usuario " . $_POST["nombre"] . "</p>";
            echo "<form action='index.php' method='post' class='centrar'>";
            echo "<button type='submit' name='boton_volver'>Volver</button>";
            echo "<button type='submit' name='boton_confirma_borrar' value='" . $_POST["boton_borrar"] . "'>Continuar</button>";
            echo "</form>";

        } elseif (isset($_POST["boton_editar"])) {

            echo "<h2 class='centrar'>Editar Usuario " . $_POST["boton_editar"] . "</h2>";
            $consulta = "SELECT * FROM usuarios WHERE id_usuario = '" . $_POST["boton_editar"] . "'";
            $resultado = mysqli_query($conexion, $consulta);

            $tupla = mysqli_fetch_assoc($resultado);

            ?>

<form action="index.php" method="post" class="centrar">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php echo $tupla["nombre"] ?>"/>
        </p>
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php echo $tupla["usuario"] ?>"/>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" maxlength="20" placeholder="Nueva contraseña">
        </p>

        <p>
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" maxlength="50" value="<?php echo $tupla["email"]; if (isset($_POST["email"])) echo $_POST["email"] ?>">
            
                <?php if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                    echo "<span class='error'> E-mail no válido</span>";
                    //Si el email ha cambiado y es igual que otro
                elseif ($tupla["email"] != $_POST["email"] && repetido($conexion, "usuarios", "email", $_POST["email"]))
                    echo "<span class='error'>E-mail ya en uso</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="boton_volver">Volver</button>
            <button type="submit" name="boton_continuar">Continuar</button>
        </p>
    </form>

            <?php

        } else {

            echo "<form class='centrar' action='usuario_nuevo.php' method='post'>";
            echo "<button type='submit' name='boton_nuevo'>Nuevo usuario</button>";
            echo "</form>";
        }


        mysqli_close($conexion);
    } catch (Exception $e) {

        $mensaje = "Imposible conectar; Error nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion); //Cierra conexión
        die($mensaje);
    }

    ?>



</body>

</html>