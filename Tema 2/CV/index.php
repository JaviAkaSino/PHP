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
        if ($_POST["nombre_foto"] != "no_imagen.jpg")
            unlink("Img/" . $_POST["nombre_foto"]);
    } catch (Exception $e) {

        $mensaje = "No ha sido posible borrar el usuario. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die(pag_error("Práctica 8", "Borrar usuario", $mensaje));
    }
}


/***************************  EDITAR - CONFIRMACIÓN   **************************/

if (isset($_POST["boton_confirmar_editar"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_formato($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_sexo = !isset($_POST["sexo"]);
    $error_foto = $_FILES["foto"]["name"] != "" &&
        ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000);

    $error_form = $error_nombre || $error_usuario || $error_dni || $error_sexo || $error_foto;

    //Si usuario y dni no dan los errores "normales" accedemos a la bd para ver si están repetidos
    if (!$error_usuario || !$error_dni) {

        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(pag_error("Práctica 8", "Editar usuario", "Imposible conectar. Error Nº " .
                mysqli_connect_errno() . ": " . mysqli_connect_error()));
        }

        if (!$error_usuario) {

            $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"], "id_usuario", $_POST["boton_confirmar_editar"]);

            if (is_string($error_usuario)) {

                mysqli_close($conexion);
                die(pag_error("Práctica 8", "Editar usuario", $error_usuario));
            }
        }

        if (!$error_dni) {

            $error_dni = repetido($conexion, "usuarios", "dni", $_POST["dni"], "id_usuario", $_POST["boton_confirmar_editar"]);

            if (is_string($error_dni)) {

                mysqli_close($conexion);
                die(pag_error("Práctica 8", "Editar usuario", $error_dni));
            }
        }

        $error_form = $error_nombre || $error_usuario || $error_dni || $error_sexo || $error_foto;

        if (!$error_form) {
        }
        if ($_POST["clave"] != "") {
            //Cambia clave
            $consulta = "UPDATE usuarios SET nombre = '" . $_POST["nombre"] . "', usuario = '" . $_POST["usuario"] . "', clave = '" . $_POST["clave"] . "', dni = '" . strtoupper($_POST["dni"]) . "', sexo = '" . $_POST["sexo"] . "' WHERE id_usuario = '" . $_POST["boton_confirmar_editar"] . "'";
        } else {
            //No cambia clave
            $consulta = "UPDATE usuarios SET nombre = '" . $_POST["nombre"] . "', usuario = '" . $_POST["usuario"] . "', dni = '" . strtoupper($_POST["dni"]) . "', sexo = '" . $_POST["sexo"] . "' WHERE id_usuario = '" . $_POST["boton_confirmar_editar"] . "'";
        }

        try {

            $resultado = mysqli_query($conexion, $consulta);
            $mensaje_accion = "Usuario editado con éxito";

            //Ahora añadimos la foto si la hay
            if ($_FILES["foto"]["name"] != "") {
                //Extension
                $array_nombre = explode(".", $_FILES["foto"]["name"]);
                $extension = "";
                if (count($array_nombre) > 1)
                    $extension = "." . strtolower(end($array_nombre));
                //Nombre
                $nombre_imagen = "img_" . $_POST["boton_confirmar_editar"] . $extension;
                //Mover
                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Img/" . $nombre_imagen);
                if ($var) {

                    if ($nombre_imagen != $_POST["nombre_foto"]) { //Si la foto cambia

                        try { //Actualizamos
                            $consulta = "UPDATE usuarios SET foto = '" . $nombre_imagen . "' WHERE id_usuario = '" . $_POST["boton_confirmar_editar"] . "'";
                            mysqli_query($conexion, $consulta);

                            if ($_POST["nombre_foto"] != "no_imagen.jpg") { //Si ya tenoia foto
                                if (is_file("Img/" . $_POST["nombre_foto"])){
                                    unlink("Img/" . $_POST["nombre_foto"]);
                                }                             
                            }
                        } catch (Exception $e) {
                            $mensaje = "Imposible subir la imagen. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                            mysqli_close($conexion);
                            die(pag_error("Práctica 8", "Añadir imagen", $mensaje));
                        }
                    }
                } else { //Si no se puede mover la foto

                    $mensaje_accion = "Usuario editado a falta de la imagen. No ha sido posible subir la imagen al servidor";
                }
            }
        } catch (Exception $e) {

            $mensaje = "No ha sido posible editar el usuario. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die(pag_error("Práctica 8", "Editar usuario", $mensaje));
        }
    }
}

/***********************  NUEVO USUARIO - CONFIRMACIÓN   **********************/
if (isset($_POST["boton_confirmar_nuevo"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_formato($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_sexo = !isset($_POST["sexo"]);
    $error_foto = $_FILES["foto"]["name"] != "" &&
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

            //Hacemos el INSERT sin la foto
            $consulta = "INSERT INTO usuarios (nombre, usuario, clave, dni, sexo) 
                VALUES ('" . $_POST["nombre"] . "', '" . $_POST["usuario"] . "', '" . md5($_POST["clave"]) . "', '" . strtoupper($_POST["dni"]) . "', '" . $_POST["sexo"] . "')";

            try {
                mysqli_query($conexion, $consulta);
                $mensaje_accion = "Usuario añadido con éxito";

                //Ahora añadimos la foto si la hay
                if ($_FILES["foto"]["name"] != "") {
                    //Extension
                    $array_nombre = explode(".", $_FILES["foto"]["name"]);
                    $extension = "";
                    if (count($array_nombre) > 1)
                        $extension = "." . strtolower(end($array_nombre));
                    //Nombre
                    $ultimo_id = mysqli_insert_id($conexion); //Último id
                    $nombre_imagen = "img_" . $ultimo_id . $extension;
                    //Mover
                    @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Img/" . $nombre_imagen);
                    if ($var) {

                        try {
                            $consulta = "UPDATE usuarios SET foto = '" . $nombre_imagen . "' WHERE id_usuario = '" . $ultimo_id . "'";
                            mysqli_query($conexion, $consulta);
                        } catch (Exception $e) {
                            $mensaje = "Imposible subir la imagen. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                            mysqli_close($conexion);
                            die(pag_error("Práctica 8", "Añadir imagen", $mensaje));
                        }
                    } else { //Si no se puede mover la foto

                        $mensaje_accion = "Usuario añadido con imagen por defecto. No ha sido posible subir la imagen al servidor";
                    }
                }

                mysqli_close($conexion);
            } catch (Exception $e) {
                $mensaje = "Imposible añadir al usuario. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                mysqli_close($conexion);
                die(pag_error("Práctica 8", "Nuevo usuario", $mensaje));
            }
        }
    }
}

/*****************************  PÁGINA PRINCIPAL   ****************************/

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
            height: 50px;
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
        .flexible{
            display:flex;
        }
        .columna{
            flex-flow: column;
        }
        .fila{
            flex-flow: row;
        }

        div#edicion{
            align-items: center;
        }

        div#editar_foto>img {
            height: 15rem;
            box-shadow: 0px 2px 10px 5px black;
        }

    </style>
</head>

<body>
    <h1 class="texto-centrado">Práctica 8</h1>

    <?php

    //Si no hay conexión, conecta
    if (!isset($conexion)) {

        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {

            die("<p class='centrar'>Imposible conectar. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");
        }
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
        <form action="index.php" method="post" enctype="multipart/form-data" class="centrar">
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
                    elseif (!dni_formato($_POST["dni"])) {
                        echo "<span class='error'> Escriba un DNI con formato válido</span>";
                    } elseif (!dni_valido($_POST["dni"]))
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
                <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked" ?>>
                <label for="mujer"> Mujer</label>
            </p>

            <p>
                <label for="foto">Incluir mi foto (max. 500KB) </label>
                <input type="file" name="foto" id="foto" accept="image/*" />
                <?php
                if (isset($_POST["boton_confirmar_nuevo"]) && $error_foto) {

                    if ($_FILES["foto"]["error"]) {
                        echo "<span class='error'>Error en la subida del fichero</span>";
                    } elseif (!getimagesize($_FILES["foto"]["tmp_name"])) {
                        echo "<span class='error'>El archivo debe ser una imagen</span>";
                    } else {
                        echo "<span class='error'>La imagen no debe exceder los 500KB</span>";
                    }
                }
                ?>
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
                <input type='hidden' name = 'nombre_foto' value='" . $_POST["nombre_foto"] . "'/>
            </form>";
        echo "</div>";
    }

    /***************************   EDITAR USUARIO  **************************/

    if (isset($_POST["boton_editar"]) || (isset($_POST["boton_confirmar_editar"]) && $error_form)) {


        if (isset($_POST["boton_editar"])) {

            $id_usuario = $_POST["boton_editar"];
            $consulta = "SELECT * FROM usuarios WHERE id_usuario = '" . $_POST["boton_editar"] . "'";

            try {

                $resultado = mysqli_query($conexion, $consulta);
                if (mysqli_num_rows($resultado) > 0) {

                    $tupla = mysqli_fetch_assoc($resultado);
                    $nombre = $tupla["nombre"];
                    $usuario = $tupla["usuario"];
                    $dni = $tupla["dni"];
                    $sexo = $tupla["sexo"];
                    $foto = $tupla["foto"];
                } else {
                    $error_consistencia = "El usuario seleccionado ya no se encuentra en la base de datos";
                }

                mysqli_free_result($resultado);
            } catch (Exception $e) {
                $mensaje = "<p class='centrar'>Imposible realizar consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p>";
                mysqli_close($conexion);
                die($mensaje);
            }
        } else {

            $id_usuarioo = $_POST["boton_confirmar_editar"];
            $nombre = $_POST["nombre"];
            $usuario = $_POST["usuario"];
            $dni = $_POST["dni"];
            $sexo = $_POST["sexo"];
            $foto = $_POST["foto"];
        }

        echo "<h2 class='centrar'>Editando al usuario con ID: " . $id_usuario . "</h2>";
        if (isset($error_consistencia)) {
            echo "<div class='centrar'>";
            echo "<p>" . $error_consistencia . "</p>";
            echo "<form method='post' action='index.php'>";
            echo "<p><button type='submit'>Volver</button></p>";
            echo "</form>";
            echo "</div>";
        }


    ?>
        <div id ="edicion" class="flexible fila">


            <div>
                <form action="index.php" method="post" enctype="multipart/form-data" class="centrar">
                    <p>
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php echo $nombre; ?>">
                        <?php if (isset($_POST["nombre"]) && $error_nombre) echo "<span class='error'> Campo vacío </span>" ?>
                    </p>
                    <p>
                        <label for="usuario">Usuario:</label>
                        <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php echo $usuario; ?>">
                        <?php if (isset($_POST["usuario"]) && $error_usuario) {
                            if ($_POST["usuario"] == "")
                                echo "<span class='error'> Campo vacío </span>";
                            else
                                echo "<span class='error'> Usuario ya existente </span>";
                        }  ?>
                    </p>
                    <p>
                        <label for="clave">Contraseña:</label>
                        <input type="password" name="clave" id="clave" maxlength="20" placeholder="Editar contraseña">
                    </p>

                    <p>
                        <label for="dni">DNI:</label>
                        <input type="text" name="dni" id="dni" maxlength="10" value="<?php echo $dni; ?>" placeholder="DNI: 11223344Z">
                        <?php if (isset($_POST["dni"]) && $error_dni) {
                            if ($_POST["dni"] == "")
                                echo "<span class='error'> Campo vacío </span>";
                            elseif (!dni_formato($_POST["dni"])) {
                                echo "<span class='error'> Escriba un DNI con formato válido</span>";
                            } elseif (!dni_valido($_POST["dni"]))
                                echo "<span class='error'> DNI no válido</span>";
                            else
                                echo "<span class='error'>DNI ya en uso</span>";
                        } ?>
                    <p>
                        <label>Sexo:</label>
                        <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_sexo) echo "<span class='error'> Debe seleccionar un sexo </span>" ?>
                        <br />
                        <input type="radio" name="sexo" id="hombre" value="hombre" <?php if ($sexo == "hombre") echo "checked" ?>>
                        <label for="hombre"> Hombre</label><br />
                        <input type="radio" name="sexo" id="mujer" value="mujer" <?php if ($sexo == "mujer") echo "checked" ?>>
                        <label for="mujer"> Mujer</label>
                    </p>

                    <p>
                        <label for="foto">Incluir mi foto (max. 500KB) </label>
                        <input type="file" name="foto" id="foto" accept="image/*" />
                        <?php
                        if (isset($_POST["boton_confirma_nuevo"]) && $error_foto) {

                            if ($_FILES["foto"]["error"]) {
                                echo "<span class='error'>Error en la subida del fichero</span>";
                            } elseif (!getimagesize($_FILES["foto"]["tmp_name"])) {
                                echo "<span class='error'>El archivo debe ser una imagen</span>";
                            } else {
                                echo "<span class='error'>La imagen no debe exceder los 500KB</span>";
                            }
                        }
                        ?>
                    </p>

                    <p>
                        <button type="submit" name="boton_volver">Volver</button>
                        <input type="hidden" name="nombre_foto" value="<?php echo $foto; ?>">
                        <!--input type="hidden" name ="id_usuario" value = ""-->
                        <button type="submit" name="boton_confirmar_editar" value="<?php echo $id_usuario; ?>">Guardar cambios</button>
                    </p>
            </div>
            <div class="flexible columna" id ="editar_foto">
                <img src="Img/<?php echo $foto; ?>" alt="Foto de perfil" title="Foto de perfil" />
                <?php
                if ($foto != "no_imagen.jpg")
                    echo "<p class='texto-centrado'><button type='submit' name='borrar_foto' value='".$foto."'>Borrar</button></p>"
                ?>
            </div>
            </form>
        </div>
    <?php

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
                        <input type='hidden' name= 'nombre_foto' value='" . $tupla["foto"] . "'/>
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

        $mensaje = "<p>Imposible realizar la conexión. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p>";
        mysqli_close($conexion);
        die($mensaje);
    }


    ?>
</body>

</html>