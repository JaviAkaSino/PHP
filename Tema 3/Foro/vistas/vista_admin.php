<?php
if (isset($_POST["btnSalir"])) {
    session_destroy();
    mysqli_close($conexion);
    header("Location:index.php");
    exit;
}

/*************************************CONFIRMA NUEVO***********************************/
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
            $_SESSION["buscar"] = $_POST["nombre"];
            $_SESSION["pagina"] = 1;
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


/********************************** CONFIRMAR EDITAR ******************************/

if (isset($_POST["boton_confirma_editar"])) { //Al pulsar botón, revisamos errores normales

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $error_form = $error_nombre || $error_usuario || $error_email;

    if (!$error_usuario || !$error_email) { //Si ya están rellenos, mirar si están repetidos

        try { //Try catch de la conexión

            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {

            die(pag_error("Prácitca 1º CRUD", "Editar usuario", "Imposible conectar. Error Nº " .
                mysqli_connect_errno() . ": " . mysqli_connect_error()));
        }

        if (!$error_usuario) { //SI USUARIO YA ESTÁ RELLENO

            $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"], "id_usuario", $_POST["boton_confirma_editar"]); //Error si repetido

            if (is_string($error_usuario)) { //Si se obtiene un mensaje de error, se enseña

                mysqli_close($conexion);
                die(pag_error("Prácitca 1º CRUD", "Nuevo Usuario", $error_usuario));
            }
        }

        if (!$error_email) { // IGUAL PARA EMAIL

            $error_email = repetido($conexion, "usuarios", "email", $_POST["email"], "id_usuario", $_POST["boton_confirma_editar"]);

            if (is_string($error_email)) {

                mysqli_close($conexion);
                die(pag_error("Prácitca 1º CRUD", "Nuevo Usuario", $error_email));
            }
        }


        $error_form = $error_nombre || $error_usuario || $error_email;

        if (!$error_form) {

            if ($_POST["clave"] == "") //Si no se ha metido clave nueva
                $consulta = "UPDATE usuarios SET nombre='" . $_POST["nombre"] . "', usuario = '" . $_POST["usuario"] . "', email = '" . $_POST["email"] . "' WHERE id_usuario = '" . $_POST["boton_confirma_editar"] . "'";
            else
                $consulta = "UPDATE usuarios SET nombre='" . $_POST["nombre"] . "', usuario = '" . $_POST["usuario"] . "', clave ='" . md5($_POST["clave"]) . "',email = '" . $_POST["email"] . "' WHERE id_usuario = '" . $_POST["boton_confirma_editar"] . "'";

            try {

                mysqli_query($conexion, $consulta);
                $_SESSION["mensaje_accion"] = "Usuario editado con éxito";
            } catch (Exception $e) {

                $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                mysqli_close($conexion);
                die(pag_error("Prácitca 1º CRUD", "Nuevo Usuario", $mensaje));
            }
        }
    }
}


/********************************** CONFIRMAR BORRAR ******************************/

if (isset($_POST["boton_confirmar_borrar"])) {

    try {
        $consulta = "DELETE FROM usuarios WHERE id_usuario = '" . $_POST["boton_confirmar_borrar"] . "'";
        mysqli_query($conexion, $consulta);
        $_SESSION["mensaje_accion"] = "Usuario borrado con éxito";
        $_SESSION["pagina"] = 1;
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

        .centrar {
            width: 80%;
            margin: 1rem auto;
        }

        .centrar-texto {
            text-align: center;
        }

        .flexible {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <h1 class="centrar-texto">Primer Login - ADMINISTRADOR</h1>
    <div class="centrar">
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> -
        <form class="enlinea" action="index.php" method="post">
            <button class='enlace' name='btnSalir'>Salir</button>
        </form>
    </div>


    <h2 class="centrar">Listado de usuarios</h2>

    <?php
    //PAGINACIÓN
    if (!isset($_SESSION["regs_x_pag"])) {
        $_SESSION["regs_x_pag"] = 2;
        $_SESSION["buscar"] = "";
    }

    if (isset($_POST["regs_x_pag"])) {
        $_SESSION["regs_x_pag"] = $_POST["regs_x_pag"];
        $_SESSION["buscar"] = $_POST["buscar"];
        $_SESSION["pagina"] = 1;
    }


    if (!isset($_SESSION["pagina"]))
        $_SESSION["pagina"] = 1;

    if (isset($_POST["pagina"]))
        $_SESSION["pagina"] = $_POST["pagina"];

    $inicio = ($_SESSION["pagina"] - 1) * $_SESSION["regs_x_pag"];


    ?>

    <form class='centrar flexible' method='post' action='index.php'>
        <div>
            <label for="regs_x_pag">Registros a mostrar:</label>
            <select name="regs_x_pag" id="regs_x_pag" onchange="document.getElementById('boton_buscar').click();">
                <option value="2" <?php if ($_SESSION["regs_x_pag"] == 2) echo "selected" ?>>2</option>
                <option value="4" <?php if ($_SESSION["regs_x_pag"] == 4) echo "selected" ?>>4</option>
                <option value="-1" <?php if ($_SESSION["regs_x_pag"] == -1) echo "selected" ?>>ALL</option>
            </select>
        </div>
        <div>
            <input type="text" name="buscar" value="<?php echo $_SESSION["buscar"] ?>" />
            <button type="submit" id="boton_buscar">Buscar</button>
        </div>
    </form>

    <?php
    if ($_SESSION["regs_x_pag"] == -1) { //Si es ALL, no limit

        $consulta = "SELECT nombre, id_usuario 
                        FROM usuarios 
                        WHERE tipo = 'normal'
                        AND nombre LIKE '%" . $_SESSION["buscar"] . "%'";
    } else {

        $consulta = "SELECT nombre, id_usuario 
                        FROM usuarios 
                        WHERE tipo = 'normal'
                        AND nombre LIKE '%" . $_SESSION["buscar"] . "%'
                        LIMIT " . $inicio . "," . $_SESSION["regs_x_pag"];
    }


    try {

        $resultado = mysqli_query($conexion, $consulta);

        echo "<table class='centrar'>";

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
    } catch (Exception $e) {

        $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        session_destroy();
        die($mensaje);
    }

    //BOTONES DEL NÚMERO DE PÁGINA

    if ($_SESSION["regs_x_pag"] != -1) { //Si se muestran ALL, no hay botones

        try { //Sacamos el total de registros
            $consulta = "SELECT * FROM usuarios WHERE nombre LIKE '%" . $_SESSION["buscar"] . "%'";
            $resultado = mysqli_query($conexion, $consulta);
            $numero_registros = mysqli_num_rows($resultado);

            $numero_paginas = ceil($numero_registros / $_SESSION["regs_x_pag"]); //Total de los registros entre los regs por pag

            if ($numero_paginas > 1) { //Si hay mas de una pagina ponemos botones

                echo "<form method='post' action='index.php' class='centrar'>";

                if ($_SESSION["pagina"] > 1) { //Si no estamos en la 1, aparecen flechas pabajo
                    echo "<button type='submit' name='pagina' value='1'>|<</button>";
                    echo "<button type='submit' name='pagina' value='" . ($_SESSION["pagina"] - 1) . "'><</button>";
                }

                for ($i = 1; $i <= $numero_paginas; $i++) {

                    if ($i == $_SESSION["pagina"]) //Desactiva el boton de la página en la que está
                        echo "<button disabled type='submit' name='pagina' value = '" . $i . "'>" . $i . "</button>";
                    else
                        echo "<button type='submit' name='pagina' value = '" . $i . "'>" . $i . "</button>";
                }

                if ($_SESSION["pagina"] < $numero_paginas) { //Si no estamos en la última, aparecen flechas hacia delante
                    echo "<button type='submit' name='pagina' value='" . ($_SESSION["pagina"] + 1) . "'>></button>";
                    echo "<button type='submit' name='pagina' value='" . $numero_paginas . "'>>|</button>";
                }
                echo "</form>";
            }
        } catch (Exception $e) {

            $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            session_destroy();
            die($mensaje);
        }
    }

    mysqli_free_result($resultado);

    /**** FIN TABLA ****/


    if (isset($_SESSION["mensaje_accion"])) {

        echo "<p class='centrar'>" . $_SESSION["mensaje_accion"] . "</p>";
        unset($_SESSION["mensaje_accion"]);
    }

    if (isset($_POST["boton_listar"])) {

        require "admin/vista_listar.php";
    }


    /************  NUEVO USUARIO  ***************/

    if (isset($_POST["boton_nuevo"]) || isset($_POST["boton_confirmar_nuevo"])) {

        require "admin/vista_nuevo.php";
    }

    /************  EDITAR USUARIO  ***************/

    if (isset($_POST["boton_editar"]) || isset($_POST["boton_confirma_editar"]) && $error_form) {

        require "admin/vista_editar.php";
    }

    /************  BORRAR USUARIO  ***************/

    if (isset($_POST["boton_borrar"])) {

        require "admin/vista_borrar.php";
    }


    ?>


</body>

</html>