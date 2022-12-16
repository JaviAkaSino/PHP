<?php
if (isset($_POST["btnSalir"])) {
    session_destroy();
    mysqli_close($conexion);
    header("Location:index.php");
    exit;
}


if (isset($_POST["boton_confirmar_nuevo"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

    if (!$error_usuario) {

        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

        if (is_string($error_usuario)) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Primer CRUD", "Primer CRUD", $error_usuario));
        }
    }

    if (!$error_email) {

        $error_email = repetido($conexion, "usuarios", "email", $_POST["email"]);

        if (is_string($error_email)) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Primer CRUD", "Primer CRUD", $error_email));
        }
    }

    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;


    if (!$error_form) {

        try {
            $consulta = "INSERT INTO usuarios (nombre, usuario, clave, email) 
                VALUES ( '" . $_POST["nombre"] . "', '" . $_POST["usuario"] . "', '" . md5($_POST["clave"]) . "', '" . $_POST["email"] . "')";
            mysqli_query($conexion, $consulta);

            $_SESSION["mensaje_accion"] = "Usuario registrado con éxito";
            mysqli_close($conexion);
            header("Location:index.php");
            exit;
        } catch (Exception $e) {
            $mensaje = "Imposible realizar la inserción. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Primer CRUD", "Primer CRUD", $mensaje));
        }
    }
}


if(isset($_POST["boton_confirmar_borrar"])){

    try {
        $consulta = "DELETE FROM usuarios WHERE id_usuario = '".$_POST["boton_confirmar_borrar"]."'";
        mysqli_query($conexion, $consulta);
        $_SESSION["mensaje_accion"] = "Usuario borrado con éxito";
        mysqli_close($conexion);
        header("Location:index.php");
        exit;
    } catch (Exception $e) {
        $mensaje = "Imposible borrar el usuario. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Primer CRUD", "Primer CRUD", $mensaje));
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login - ADMINISTRADOR</title>
    <style>
        table {
            border-collapse: collapse;
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        img {
            height: 100px;
            width: auto;
        }

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
    </style>
</head>

<body>
    <h1>Primer Login - ADMINISTRADOR</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> -
        <form class="enlinea" action="index.php" method="post">
            <button class='enlace' name='btnSalir'>Salir</button>
        </form>
    </div>


    <h2>Listado de usuarios</h2>

    <?php

    $consulta = "SELECT nombre, id_usuario FROM usuarios WHERE tipo = 'normal'";

    try {

        $resultado = mysqli_query($conexion, $consulta);

        echo "<table>";

        echo "<tr>
                <th>Nombre de Usuario <form action='index.php' method='post'><button type='submit' name='boton_nuevo'>[ + ]</button></form></th>
                <th>Borrar</th>
                <th>Editar</th>
            </tr>";

        while ($tupla = mysqli_fetch_assoc($resultado)) {

            echo "<tr>
                        <td>
                            <form action='index.php' method='post'>
                                <button type='submit' name='boton_listar' value='" . $tupla["id_usuario"] . "'>
                                    " . $tupla["nombre"] . "
                                </button>
                            </form>                           
                        </td>
                        <td>
                            <form action='index.php' method='post'>
                                <button type='submit' name='boton_borrar' value='" . $tupla["id_usuario"] . "'>
                                    <img src='img/delete.png' alt='Borrar Usuario' title='Borrar Usuario'/>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action='index.php' method='post'>
                                <button type='submit' name='boton_editar' value='" . $tupla["id_usuario"] . "'>
                                    <img src='img/edit.png' alt='Editar Usuario' title='Editar Usuario'/>
                                </button>
                            </form>
                        </td>
                    </tr>";
        }

        echo "</table>";
        mysqli_free_result($resultado);
    } catch (Exception $e) {

        $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        session_destroy();
        die($mensaje);
    }

    if (isset($_SESSION["mensaje_accion"])) {

        echo "<p class='centrar'>" . $_SESSION["mensaje_accion"] . "</p>";
        unset($_SESSION["mensaje_accion"]);
    }

    if (isset($_POST["boton_listar"])) {

        try {

            $consulta = "SELECT * FROM usuarios WHERE id_usuario = '" . $_POST["boton_listar"] . "'";
            $resultado = mysqli_query($conexion, $consulta);

            if (mysqli_num_rows($resultado) > 0) { //Si el usuario sigue existiendo

                $tupla = mysqli_fetch_assoc($resultado);
                echo "<h3>Datos del usuario " . $_POST["boton_listar"] . "</h3>";
                echo "<p><strong>Nombre: </strong>" . $tupla["nombre"] . "</p>";
                echo "<p><strong>Usuario: </strong>" . $tupla["usuario"] . "</p>";
                echo "<p><strong>E-mail: </strong>" . $tupla["email"] . "</p>";
                echo "<form action='index.php' method='post'><button type='submit'>Atrás</button></form>";
            } else { //Si el usuario se borra durante

                echo "<p class ='error'>Error de consistencia. El usuario seleccionado ya no existe</p>";
            }

            mysqli_free_result($resultado);
        } catch (Exception $e) {

            $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            session_destroy();
            die($mensaje);
        }
    }

    if (isset($_POST["boton_nuevo"]) || isset($_POST["boton_confirmar_nuevo"])) {

    ?>
        <h3>Nuevo usuario</h3>
        <form action="index.php" method="post">
            <p>
                <label for="nombre">Nombre: </label>
                <input type="text" id="nombre" name="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
                <?php if (isset($_POST["nombre"]) && $error_nombre)
                    echo "<span class='error'>* Campo vacío * </span>"; ?>
            </p>

            <p>
                <label for="usuario">Usuario: </label>
                <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
                <?php if (isset($_POST["usuario"]) && $error_usuario) {

                    if ($_POST["usuario"] == "")
                        echo "<span class='error'>* Campo vacío * </span>";
                    else
                        echo "<span class='error'>* Usuario ya existente * </span>";
                }
                ?>
            </p>

            <p>
                <label for="clave">Contraseña: </label>
                <input type="text" id="clave" name="clave" value="<?php if (isset($_POST["clave"])) echo $_POST["clave"]; ?>">
                <?php if (isset($_POST["clave"]) && $error_clave)
                    echo "<span class='error'>* Campo vacío * </span>"; ?>
            </p>

            <p>
                <label for="email">E-mail: </label>
                <input type="text" id="email" name="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>">
                <?php if (isset($_POST["email"]) && $error_email) {

                    if ($_POST["email"] == "")
                        echo "<span class='error'>* Campo vacío * </span>";
                    else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                        echo "<span class='error'>* Formato de e-mail no válido * </span>";
                    else
                        echo "<span class='error'>* E-mail ya existente * </span>";
                }
                ?>
            </p>

            <p>
                <button type="submit">Atrás</button>
                <button type="submit" name="boton_confirmar_nuevo">Continuar</button>
            </p>
        </form>
    <?php
    }

    if (isset($_POST["boton_editar"])) {
    }

    if (isset($_POST["boton_borrar"])) {

        echo "<h3>Borrar usuario</h3>";
        echo "<p>¿Desea borrar el usuario ".$_POST["boton_borrar"]."?</p>";
        echo "<form action='index.php' method='post'>
                <button type='submit'>Atras</button>
                <button type='submit' name='boton_confirmar_borrar' value='".$_POST["boton_borrar"]."'>Confirmar</button>
            </form>";
    }


    ?>


</body>

</html>