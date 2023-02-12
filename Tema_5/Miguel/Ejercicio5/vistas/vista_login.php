<?php
if(isset($_POST["btnLogin"]))
{
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form=$error_usuario||$error_clave;
    if(!$error_form)
    {
        $datos_login["usuario"]=$_POST["usuario"];
        $datos_login["clave"]=md5($_POST["clave"]);
        $url=DIR_SERV."/login";
        $respuesta=consumir_servicios_REST($url,"POST",$datos_login);
        $obj=json_decode($respuesta);
        if(!$obj)
            die(error_page("Login SW","Login SW","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));
        
        if(isset($obj->error))
            die(error_page("Login SW","Login SW","<p>".$obj->error."</p>"));
        
        if(isset($obj->mensaje))
        {
            $error_usuario=true;
        }
        else
        {
            $_SESSION["usuario"]=$datos_login["usuario"];
            $_SESSION["clave"]=$datos_login["clave"];
            $_SESSION["ultimo_acceso"]=time();
            $_SESSION["api_session"]=$obj->api_session;
            
            header("Location:index.php");
            exit;
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
    <title>Login SW</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <h1>Login SW</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php
            if(isset($_POST["btnLogin"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                else
                    echo "<span class='error'> Usuario y/o Contraseña incorrectos </span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" />
            <?php
            if(isset($_POST["btnLogin"])&& $error_clave)
            {
                echo "<span class='error'> Campo vacío </span>";
            }
            ?>
        </p>
        <p>
            <input type="submit" name="btnLogin" value="Login"/>
        </p>
    </form>
    <?php
    if(isset($_SESSION["seguridad"]))
    {
        echo "<p class='error'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }
    ?>
</body>
</html>