<?php
require "src/bd_config.php";
require "src/funciones.php";

if (isset($_POST["boton_continuar_registro"])) {

    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {

        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            $mensaje = "Imposible realizar la conexion. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error();
            die(pag_error("Examen 2 18/19", "Videoclub", $mensaje));
        }

        $error_usuario = repetido($conexion, "clientes", "usuario", $_POST["usuario"]);

        if (is_string($error_usuario)) {

            mysqli_close($conexion);
            die(pag_error("Examen 2 18/19", "Videoclub", $error_usuario));
        }
    }
    $error_clave = $_POST["clave"] == "";
    $error_clave2 = $_POST["clave2"] != $_POST["clave"];

    $error_foto = $_FILES["foto"]["name"] != "" &&
        ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000);

    $error_form_registro = $error_usuario || $error_clave || $error_clave2 || $error_foto;


    if (!$error_form_registro) {

        //INSERTAMOS EL CLIENTE SIN FOTO
        try {
            $consulta = "INSERT INTO clientes(usuario, clave)
                            VALUES ('" . $_POST["usuario"] . "', '" . $_POST["clave"] . "'')";
            mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die(pag_error("Examen 2 18/19", "Videoclub", $mensaje));
        }

        $mensaje_registro = "Usuario registrado correctamente";

        //SI FOTO LA INSERTAMOS
        if ($_FILES["foto"]["name"] != "") {

            $ultima_id = mysqli_insert_id($conexion);

            $extension = "";
            $arr_nombre = explode(".", $_FILES["foto"]["name"]);
            if (count($arr_nombre) > 1)
                $extension = "." . end($arr_nombre);

            $nombre_foto = "img" . $ultima_id . $extension;

            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Images/" . $nombre_foto);

            if ($var) { //Si se mueve el archivo

                try {
                    $consulta = "UPDATE clientes SET foto=$nombre_foto WHERE id_cliente = $ultima_id";
                    mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    if (is_file("Images/" . $nombre_foto))
                        unlink("Images/" . $nombre_foto);
                    $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                    mysqli_close($conexion);
                    die(pag_error("Examen 2 18/19", "Videoclub", $mensaje));
                }
            } else {
                $mensaje_registro = "Usuario registrado correctamente con la imagen por defecto, debido a un error en la subida";
            }
        }
    }

    session_name("examen2_18_19");
    session_start();
    $_SESSION["usuario"] = $_POST["usuario"];
    $_SESSION["clave"] = md5($_POST["clave"]);
    $_SESSION["ultimo_acceso"] = time();
    $_SESSION["mensaje_registro"] = $mensaje_registro;
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 2 18/19</title>
</head>

<body>
    <h1>Videoclub</h1>
    <form action="registro_usuario.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Nombre de usuario: </label>
            <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" />
            <?php if (isset($_POST["usuario"]) && $error_usuario) {
                if ($_POST["usuario"] == "")
                    echo "* Campo vacío *";
                else
                    echo "* Usuario ya existente *";
            }
            ?>
        </p>

        <p>
            <label for="clave">Contraseña: </label>
            <input type="text" name="clave" id="clave" />
            <?php if (isset($_POST["clave"]) && $error_clave)
                echo "* Campo vacío *"
            ?>
        </p>

        <p>
            <label for="clave2">Repita la contraseña: </label>
            <input type="text" name="clave2" id="clave2" />
            <?php if (isset($_POST["clave2"]) && $error_clave2)
                echo "* Las claves no coinciden *"; ?>
        </p>

        <p>
            <label for="foto">Foto (Máx 500KB): </label>
            <input type="file" name="foto" id="foto" />
            <?php if (isset($_POST["foto"]) && $error_foto) {

                if ($_FILES["foto"]["error"])
                    echo "* Error en la subida del archivo *";
                else if (!getimagesize($_FILES["foto"]["tmp_name"]))
                    echo "El archivo seleccionado no es una imagen";
                else
                    echo "* Campo vacío *";
            } ?>
        </p>

        <p>
            <button type="submit" formaction="index.php">Volver</button>
            <button type="submit" name="boton_continuar_registro">Continuar</button>
        </p>
    </form>
</body>

</html>