<?php
require "src/bd_config.php";
require "src/funciones.php";

/***************************  BORRAR - CONFIRMACIÓN   **************************/

if (isset($_POST["boton_confirmar_borrar"])) {

    try {

        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        pag_error("Práctica 8", "Borrar usuario", "Imposible conectar. Error Nº " .
            mysqli_connect_errno() . ": " . mysqli_connect_error());
    }

    $consulta = "DELETE FROM usuarios WHERE id_usuario = '" . $_POST["boton_confirmar_borrar"] . "'";

    try {

        $resultado = mysqli_query($conexion, $consulta);
        $mensaje_accion = "Usuario borrado con éxito";
    } catch (Exception $e) {

        $mensaje = "No ha sido posible borrar al usuario. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die(pag_error("Práctica 8", "Borrar usuario", $mensaje));
    }
}


/***************************  EDITAR - CONFIRMACIÓN   **************************/

if (isset($_POST["boton_confirmar_editar"])) {

    try {

        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        pag_error("Práctica 8", "Borrar usuario", "Imposible conectar. Error Nº " .
            mysqli_connect_errno() . ": " . mysqli_connect_error());
    }

    $consulta = "DELETE FROM usuarios WHERE id_usuario = '" . $_POST["boton_confirmar_borrar"] . "'";

    try {

        $resultado = mysqli_query($conexion, $consulta);
        $mensaje_accion = "Usuario borrado con éxito";
    } catch (Exception $e) {

        $mensaje = "No ha sido posible borrar al usuario. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die(pag_error("Práctica 8", "Borrar usuario", $mensaje));
    }
}


/***************************  NUEVO USUARIO - CONFIRMACIÓN   **************************/
if (isset($_POST["boton_confirmar_nuevo"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_valido($_POST["dni"]);
    $error_sexo = !isset($_POST["sexo"]);
    $error_foto = isset($_FILES["foto"]["tmp_name"]) != "" &&
        ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000);

    $error_form = $error_nombre || $error_usuario || $error_clave || $error_dni || $error_sexo || $error_foto;

    //Si usuario y dni no dan los errores "normales" accedemos a la bd para ver si están repetidos
    if (!$error_usuario || !$error_dni) {

        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(pag_error("Práctica 8", "Nuevo usuario", "Imposible conectar. Error Nº " .
                mysqli_connect_errno() . ": " . mysqli_connect_error()));
        }

        if (!$error_usuario) {

            $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

            if (is_string($error_usuario)) {

                mysqli_close($conexion);
                die(pag_error("Práctica 8", "Nuevo usuario", $error_usuario));
            }
        }

        if (!$error_dni) {

            $error_dni = repetido($conexion, "usuarios", "dni", $_POST["dni"]);

            if (is_string($error_dni)) {

                mysqli_close($conexion);
                die(pag_error("Práctica 8", "Nuevo usuario", $error_dni));
            }
        }

        $error_form = $error_nombre || $error_usuario || $error_clave || $error_dni || $error_sexo || $error_foto;

        if (!$error_form) {

            if (isset($_FILES["foto"]["tmp_name"])) {
                $consulta = "INSERT INTO usuarios (nombre, usuario, clave, dni, sexo, foto) 
                VALUES ('" . $_POST["nombre"] . "', '" . $_POST["usuario"] . "', '" . $_POST["clave"] . "', '" . $_POST["dni"] . "', '" . $_POST["sexo"] . "', '" . $_POST["foto"] . "')";
            } else {
                $consulta = "INSERT INTO usuarios (nombre, usuario, clave, dni, sexo) 
                VALUES ('" . $_POST["nombre"] . "', '" . $_POST["usuario"] . "', '" . $_POST["clave"] . "', '" . $_POST["dni"] . "', '" . $_POST["sexo"] . "')";
            }

            try {
                mysqli_query($conexion, $consulta);
                mysqli_close($conexion);
                $mensaje_accion = "Usuario añadido con éxito";
            } catch (Exception $e) {
                $mensaje = "Imposible añadir al usuario. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                mysqli_close($conexion);
                die(pag_error("Práctica 8", "Nuevo usuario", $mensaje));
            }
        }
    }
}
?>





<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Practica 8 - Javier Parodi</title>
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

        p img {
            height: 150px;
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
    <h1 class="texto-centrado">Práctica 8</h1>

    <?php

    if (!isset($conexion)) {
    }
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        die("<p class='centrar'>Imposible conectar. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");
    }


    /***************************  BOTON LISTAR  **************************/

    if (isset($_POST["boton_listar"])) {

        echo "<h2>Listado del usuario " . $_POST["boton_listar"] . "</h2>";
        $consulta = "SELECT * FROM usuarios WHERE id_usuario = '" . $_POST["boton_listar"] . "'";

        try {

            $resultado = mysqli_query($conexion, $consulta);
            if (mysqli_num_rows($resultado) > 0) {

                $tupla = mysqli_fetch_assoc($resultado);

                echo "<div id='datos_listados'>";
                echo "<p><img src='Img/" . $tupla["foto"] . "' alt='Foto de perfil' title='Foto de perfil'/></p>";
                echo "<p><strong>Nombre: </strong>" . $tupla["nombre"] . "</p>";
                echo "<p><strong>Usuario: </strong>" . $tupla["usuario"] . "</p>";
                echo "<p><strong>DNI: </strong>" . $tupla["dni"] . "</p>";
                echo "<p><strong>Sexo: </strong>" . $tupla["sexo"] . "</p>";
            }
        } catch (Exception $e) {

            die("<p class='centrar'>Imposible realizar consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p>");
        }
    }


    /***************************   NUEVO USUARIO  **************************/

    if (isset($_POST["boton_nuevo"]) || (isset($_POST["boton_confirmar_nuevo"]) && $error_form)) {
    ?>
        <h2 class="centrar">Nuevo usuario</h2>
        <form action="index.php" method="post" class="centrar">
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>" placeholder="Nombre...">
                <?php if (isset($_POST["nombre"]) && $error_nombre) echo "<span class='error'> Campo vacío </span>" ?>
            </p>
            <p>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" placeholder="Usuario...">
                <?php if (isset($_POST["usuario"]) && $error_usuario) {
                    if ($_POST["usuario"] == "")
                        echo "<span class='error'> Campo vacío </span>";
                    else
                        echo "<span class='error'> Usuario ya existente </span>";
                }  ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" id="clave" maxlength="20" placeholder="Contraseña...">
                <?php if (isset($_POST["clave"]) && $error_clave) echo "<span class='error'> Campo vacío </span>" ?>
            </p>

            <p>
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni" maxlength="10" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"] ?>" placeholder="DNI: 11223344Z">
                <?php if (isset($_POST["dni"]) && $error_dni) {
                    if ($_POST["dni"] == "")
                        echo "<span class='error'> Campo vacío </span>";
                    elseif (!dni_valido($_POST["dni"]))
                        echo "<span class='error'> DNI no válido</span>";
                    else
                        echo "<span class='error'>DNI ya en uso</span>";
                } ?>
            <p>
                <label>Sexo:</label>
                <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_sexo) echo "<span class='error'> Debe seleccionar un sexo </span>" ?>
                <br /> 
                <input type="radio" name="sexo" id="hombre" value="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked" ?>>
                <label for="hombre"> Hombre</label><br />
                <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "selected" ?>>
                <label for="mujer"> Mujer</label>
            </p>

            <p>
                <label for="foto">Incluir mi foto (max. 500KB) </label>
                <input type="file" name="foto" id="foto" accept="image/*" />
            </p>

            <p>
                <button type="submit" name="boton_volver">Volver</button>
                <button type="submit" name="boton_confirmar_nuevo">Guardar cambios</button>
            </p>
        </form>



    <?php
    }
    /*************************** BOTON BORRAR **************************/

    if (isset($_POST["boton_borrar"])) {

        echo "<div class='centrar'>";
        echo "<h3>Borrado de usuario</h3>";
        echo "<p>¿Seguro que desea borrar el usuario " . $_POST["boton_borrar"] . "?</p>";
        echo "<form action='index.php' method='post'>
                <button type='submit'>Volver</button>
                <button name='boton_confirmar_borrar' type='submit' value='" . $_POST["boton_borrar"] . "'>Borrar</button>
            </form>";
        echo "</div>";
    }

    /************************** TABLA PRINCIPAL **************************/

    try {
        $consulta = "SELECT * FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);

        echo "<h3 class='centrar'>Listado de los usuarios</h3>";

        if (isset($mensaje_accion)) {
            echo "<p class='centrar'>" . $mensaje_accion . "</p>";
        }

        echo "<table class='centrar texto-centrado'>";
        echo "<tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>
                    <form action='index.php' method='post'>
                        <button type='submit' name='boton_nuevo' class='enlace'>
                            Usuario +</button>
                    </form>
                </th>
            </tr>";

        while ($tupla = mysqli_fetch_assoc($resultado)) {

            echo "<tr>";
            echo "<td>" . $tupla["id_usuario"] . "</td>";
            echo "<td><img src='Img/" . $tupla["foto"] . "' alt='Foto de perfil' title='Foto de perfil' /></td>";
            echo "<td>
                    <form method='post' action='index.php'>
                        <button class='enlace' name='boton_listar' value='" . $tupla["id_usuario"] . "' type='submit'>" . $tupla["nombre"] . "</button>
                    </form>
                </td>";
            echo "<td>
                    <form method='post' action='index.php'>
                        <button name='boton_borrar' value='" . $tupla["id_usuario"] . "' class='enlace' type='submit'>Borrar</button>
                        -
                        <button name='boton_editar' value='" . $tupla["id_usuario"] . "' class='enlace' type='submit'>Editar</button>
                    </form>
                </td>";
        }

        echo "</table>";
        mysqli_free_result($resultado);
        mysqli_close($conexion);
    } catch (Exception $e) {

        $mensaje = "<p>Imposible realizar la conexión. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>";
        mysqli_close($conexion);
        die($mensaje);
    }

    ?>
</body>

</html>