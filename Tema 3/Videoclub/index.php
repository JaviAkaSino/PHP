<?php

require "src/bd_config.php";
require "src/funciones.php";

session_name("examen2_18_19");
session_start();

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
    <form action="index.php" method="post">
        <p>
             <label for="usuario">Nombre de usuario: </label>
             <input type="text" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>"/>
             <?php /*if(isset($_POST["usuario"]) && $error_usuario) 
                        echo "* Campo vacío *" */?>
        </p>

        <p>
             <label for="clave">Contraseña: </label>
             <input type="text" id="clave"/>
             <?php /*if(isset($_POST["clave"]) && $error_clave) 
                        echo "* Campo vacío *" */?>
        </p>
       
        <p>
            <button type="submit" name="boton_login">Entrar</button>
            <button type="submit" formaction="registro_usuario.php" name="boton_registro">Registrarse</button>
        </p>
    </form>

    <?php
        if (isset($_SESSION["baneo"])){
            echo "<p>".$_SESSION["baneo"]."</p>";
            session_unset($_SESSION["baneo"]);
        }

        if (isset($_SESSION["tiempo"])){
            echo "<p>".$_SESSION["tiempo"]."</p>";
            session_unset($_SESSION["tiempo"]);
        }
            
    ?>

</body>
</html>