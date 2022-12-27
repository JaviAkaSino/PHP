<?php
session_name("Examen2_curso18_19");
session_start();
require "src/bd_config.php";
require "src/funciones.php";

if(isset($_POST["btnLogin"]))
{
    $error_usuario=$_POST["usuario_log"]=="";
    $error_clave= $_POST["clave_log"]=="";
    $error_form_login= $error_usuario|| $error_clave;
    if(!$error_form_login)
    {
        try
        {
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");

        }
        catch(Exception $e)
        {
            $mensaje="Imposible conectar con la BD. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error();
            session_destroy();
            die(error_page("Examen2 Curso 18-19","Video Club",$mensaje));
        }

        try
        {
            $consulta="select * from clientes where usuario='".$_POST["usuario_log"]."' and clave='".md5($_POST["clave_log"])."'";
            $resultado=mysqli_query($conexion,$consulta);
            $registrado=mysqli_num_rows($resultado)>0;

            mysqli_free_result($resultado);
            mysqli_close($conexion);
            if($registrado)
            {
                $_SESSION["usuario"]=$_POST["usuario_log"];
                $_SESSION["clave"]=md5($_POST["clave_log"]);
                $_SESSION["ultimo_acceso"]=time();
                header("Location:clientes.php");
                exit;

            }
            else
            {
                $error_usuario=true;
            }

        }
        catch(Exception $e)
        {
            $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Examen2 Curso 18-19","Video Club",$mensaje));
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
    <title>Examen2 Curso 18-19"</title>
    <style>
        .mensaje{color:blue;font-size:1.2em}
        .error{color:red}
    </style>
</head>
<body>
    <h1>Video Club</h1>
    
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario_log" id="usuario" value="<?php if(isset($_POST["usuario_log"])) echo $_POST["usuario_log"];?>"/>
            <?php 
            if(isset($_POST["btnLogin"]) && $error_usuario)
                if($_POST["usuario_log"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* Usuario no registrado en la BD *</span>";
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave_log" id="clave"/>
            <?php 
            if(isset($_POST["btnLogin"]) && $error_clave)
                echo "<span class='error'>* Campo vacío *</span>";
            ?>
        </p>
        <p>
            <button name="btnLogin">Entrar</button> <button formaction="registro_usuario.php">Registrarse</button>
        </p>

    </form>
    <?php
    if(isset($_SESSION["tiempo"]))
    {
        echo "<p class='mensaje'>".$_SESSION["tiempo"]."</p>";
        unset($_SESSION["tiempo"]);
    }
    if(isset($_SESSION["baneo"]))
    {
        echo "<p class='mensaje'>".$_SESSION["baneo"]."</p>";
        unset($_SESSION["baneo"]);
    }
    ?>  
</body>
</html>