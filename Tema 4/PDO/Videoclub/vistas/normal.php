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
            Bienvenido <strong>" . $datos_usuario_log["usuario"] . "</strong> - 
            <form action='index.php' method='post'>
                <button type='submit' name= 'boton_salir'>Salir</button>
            </form>
        </p>";


    echo "<p>
                <strong>Foto de perfil</strong>
                <img width= 150px src='Images/" . $datos_usuario_log["foto"] . "' alt='" . $datos_usuario_log["foto"] . "'/>
            </p>";

    echo "<form action='index.php' method='post' enctype='multipart/form-data'>
                <p>
                    <button type='submit' name= 'boton_borrar_foto' value='" . $datos_usuario_log["id_cliente"] . "'>Eliminar foto</button>
                    <input type='hidden' name='foto_borrar' value='" . $datos_usuario_log["foto"] . "'/>
                </p>

                <p>
                    <label for='foto'>Seleccione foto de perfil:</label>
                    <input type='file' name='foto' id='foto' accept='image/*'>";

    if (isset($_POST["boton_editar_foto"]) && $error_foto) {

        if (is_string($error_foto))
            echo "<span class='error'>" . $error_foto . "</<span>";

        if ($_FILES["foto"]["name"] != "") {

            if ($_FILES["foto"]["error"])
                echo "<span class='error'>Error en la subida de la imagen</span>";
            else if (!getimagesize($_FILES["foto"]["tmp_name"]))
                echo "<span class='error'>El archivo seleccionado NO es una imagen</span>";
            else
                echo "<span class='error'>Debe seleccionar una imagen inferior a 500KB</span>";
        }
    }

    echo "       <br/>
                    <button type='submit' name= 'boton_editar_foto' value='" . $datos_usuario_log["id_cliente"] . "'>Cambiar foto</button>
                </p>
                
            </form>";
