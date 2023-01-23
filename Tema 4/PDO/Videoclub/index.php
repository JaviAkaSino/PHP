<?php

require "src/bd_config.php";
require "src/functions.php";

session_name("Videoclub_Examen");
session_start();



if (isset($_POST["boton_salir"])) {
    session_unset();
    header("Location:index.php");
    exit;
}

if (isset($_POST["boton_borrar_foto"])) {

    //$_POST["boton_borrar_foto"]
    //$_POST["foto_borrar"]

    if ($_POST["foto_borrar"] != "no_imagen.jpg") {


        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die(pag_error("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
        }


        try {

            $consulta = "UPDATE clientes SET foto = 'no_imagen.jpg' WHERE id_cliente = ?";

            $sentencia = $conexion->prepare($consulta);
            $datos_borrar_foto[] = $_POST["boton_borrar_foto"];

            $sentencia->execute($datos_borrar_foto);

            //si se ha ejecutado borramos archivo

            if (is_file("Images/" . $_POST["foto_borrar"])) //si existe la foto
                unlink("Images/" . $_POST["foto_borrar"]);
        } catch (PDOException $e) {

            $conexion = null;
            $sentencia = null;
            die(pag_error("Imposible realizar consulta. Error: " . $e->getMessage()));
        }
    }
}

if (isset($_POST["boton_editar_foto"])) {


    $error_foto = $_FILES["foto"]["name"] == "" || $_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000;


    if (!$error_foto) {

        //Nombre foto nueva

        //extension 
        $extension = "";

        $array_nombre = explode(".", $_FILES["foto"]["name"]);
        if (count($array_nombre) > 1)
            $extension = "." . end($array_nombre);

        //img + id + ext
        $foto_nueva = "img" . $_POST["boton_editar_foto"] . $extension;


        //prueba mover

        @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Images/" . $foto_nueva);

        if ($var) {


            try {
                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
                die(pag_error("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
            }

            try {

                $consulta = "UPDATE clientes SET foto = ? WHERE id_cliente = ?";

                $sentencia = $conexion->prepare($consulta);
                $datos_editar_foto[] = $foto_nueva;
                $datos_editar_foto[] = $_POST["boton_editar_foto"];

                $sentencia->execute($datos_editar_foto);
            } catch (PDOException $e) {
                //si NO se ha ejecutado borramos archivo

                if (is_file("Images/" . $_POST["foto_borrar"])) //si existe la foto
                    unlink("Images/" . $_POST["foto_borrar"]);
                $conexion = null;
                $sentencia = null;
                die(pag_error("Imposible realizar consulta. Error: " . $e->getMessage()));
            }
        } else {

            $error_foto = "No se ha podido mover la imagen por falta de permisos";
        }
    }
}



if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {

    require "src/seguridad.php";



    if ($datos_usuario_log["tipo"] == "admin") {


        require "vistas/admin.php";
    } else {

        require "vistas/normal.php";
    }
} else { // Si NO está logado

    if (isset($_POST["boton_continuar_registro"])) {

        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";
        $error_clave2 = $_POST["clave2"] == "";
        $error_foto = $_FILES["foto"]["name"] != "" &&
            ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000);

        if (!$error_clave && !$error_clave2)
            $error_clave = $_POST["clave"] != $_POST["clave2"];

        if (!$error_usuario) {

            try {
                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
                die(pag_error("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
            }

            $error_usuario = repetido($conexion, "clientes", "usuario", $_POST["usuario"]);

            if (is_string($error_usuario)) {

                $conexion = null;
                die(pag_error("Videoclub", "Videoclub", $error_usuario));
            }
        }

        $error_form = $error_usuario || $error_clave || $error_clave2 || $error_foto;

        if (!$error_form) {

            try {

                $consulta = "INSERT INTO clientes (usuario, clave) VALUES (?,?)";

                $sentencia = $conexion->prepare($consulta);
                $datos[] = $_POST["usuario"];
                $datos[] = md5($_POST["clave"]);
                $sentencia->execute($datos);

                $_SESSION["usuario"] = $datos[0];
                $_SESSION["clave"] = $datos[1];
                $_SESSION["ultimo_acceso"] = time();

                unset($datos);
                $sentencia = null;

                header("Location:index.php");
                exit;
            } catch (PDOException $e) {

                $conexion = null;
                $sentecia = null;
                die(pag_error("", "", "Imposible insertar. Error: " . $e->getMessage()));
            }
        }
    }

    if (isset($_POST["boton_registro"])) {


?>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Videoclub</title>
        </head>

        <body>
            <h1>Videoclub</h1>

            <form action="index.php" method="post" enctype="multipart/form-data">
                <p>
                    <label for="usuario">Nombre de usuario: </label>
                    <input type="text" name="usuario" id="usuario" value='<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>' />
                    <?php if (isset($_POST["boton_entrar"]) && $error_usuario) {
                        if ($_POST["usuario"] == "")
                            echo "<span>*Campo vacío</span>";
                        else
                            echo "<span>*Usuario ya existente</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="clave">Contraseña: </label>
                    <input type="password" name="clave" id="clave" />
                    <?php if (isset($_POST["boton_entrar"]) && $error_clave) {
                        if ($_POST["clave"] == "")
                            echo "<span>*Campo vacío</span>";
                        else
                            echo "<span>*Las contraseñas no coinciden</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="clave2">Repita la contraseña: </label>
                    <input type="password" name="clave2" id="clave2" />
                    <?php if (isset($_POST["boton_entrar"]) && $error_clave2)
                        echo "<span>*Campo vacío</span>" ?>
                </p>
                <p>
                    <label for="foto">Foto:</label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                </p>
                <p>
                    <button type="submit">Volver</button>
                    <button type="submit" name="boton_continuar_registro">Continuar</button>
                </p>
            </form>
        </body>

        </html>


    <?php

    } else {

        if (isset($_POST["boton_entrar"])) {
            $error_usuario = $_POST["usuario"] == "";
            $error_clave = $_POST["clave"] == "";

            $error_form = $error_usuario || $error_clave;

            if (!$error_form) {

                $error_login = true;

                try {
                    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                } catch (PDOException $e) {
                    die(pag_error("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
                }


                try {

                    $consulta = "SELECT * FROM clientes WHERE usuario = ? AND clave = ?";
                    $sentencia = $conexion->prepare($consulta);
                    $datos[] = $_POST["usuario"];
                    $datos[] = md5($_POST["clave"]);

                    $sentencia->execute($datos);


                    if ($sentencia->rowCount() > 0) { //Si esta el usuario y clave
                        $_SESSION["usuario"] = $datos[0];
                        $_SESSION["clave"] = $datos[1];
                        $_SESSION["ultimo_acceso"] = time();

                        $sentencia = null;
                        unset($datos);

                        header("Location:index.php");
                        exit;
                    }
                } catch (PDOException $e) {
                    $sentencia = null;
                    unset($datos);
                    die(pag_error("Videoclub", "Videoclub", "Imposible comprobar usuario y contraseña. Error: " . $e->getMessage()));
                }
            }
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

            <form action="index.php" method="post">
                <p>
                    <label for="usuario">Nombre de usuario: </label>
                    <input type="text" name="usuario" id="usuario" value='<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>' />
                    <?php if (isset($_POST["boton_entrar"]) && $error_usuario)
                        echo "<span>*Campo vacío</span>" ?>
                </p>
                <p>
                    <label for="clave">Contraseña: </label>
                    <input type="password" name="clave" id="clave" />
                    <?php if (isset($_POST["boton_entrar"]) && $error_clave)
                        echo "<span>*Campo vacío</span>" ?>
                </p>
                <p>
                    <?php if (isset($error_login) && $error_login) echo "<span class='error'>Usuario o contraseña incorrectos</span>"; ?>
                </p>
                <p>
                    <button type="submit" name="boton_entrar">Entrar</button>
                    <button type="submit" name="boton_registro">Registrarse</button>
                </p>
            </form>
        </body>

        </html>


<?php



    }
}
