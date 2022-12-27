<?php
require "src/bd_config.php";
require "src/funciones.php";

if(isset($_POST["btnContinuarRegistro"]))
{
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        try
        {
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");
        
        }
        catch(Exception $e)
        {
            $mensaje="Imposible conectar con la BD. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error();
            die(error_page("Examen2 Curso 18-19","Video Club",$mensaje));
        }

        $error_usuario=repetido($conexion,"clientes","usuario",$_POST["usuario"]);
        if(is_string($error_usuario))
        {
            mysqli_close($conexion);
            die(error_page("Examen2 Curso 18-19","Video Club",$error_usuario));
        }
    }
    $error_clave=$_POST["clave"]=="";
    $error_clave2=$_POST["clave"]!=$_POST["clave2"];
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"]||!getimagesize($_FILES["foto"]["tmp_name"])|| $_FILES["foto"]["size"]>500*1000);

    $error_form_registro=$error_usuario||$error_clave || $error_clave2 || $error_foto;
    if(!$error_form_registro)
    {
        try
        {
            $consulta="insert into clientes(usuario,clave) values('".$_POST["usuario"]."','".md5($_POST["clave"])."')";
            mysqli_query($conexion, $consulta);
        }
        catch(Exception $e)
        {
            $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion); 
            mysqli_close($conexion);
            die(error_page("Examen2 Curso 18-19","Video Club",$mensaje));
        }

        $mensaje_registro="Usuario registrado correctamente";
        if($_FILES["foto"]["name"]!="")
        {
            $ultm_id=mysqli_insert_id($conexion);

            $var_nombre=explode(".",$_FILES["foto"]["name"]);
            $ext="";
            if(count($var_nombre)>1)
                $ext=".".end($var_nombre);
            
            $nombre_foto="img".$ultm_id.$ext;    
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Images/".$nombre_foto);
            if($var)
            {
                try
                {
                    $consulta="update clientes set foto='".$nombre_foto."' where id_cliente='".$ultm_id."'";
                    mysqli_query($conexion, $consulta);

                }
                catch(Exception $e)
                {
                    if(is_file("Images/".$nombre_foto))
                        unlink("Images/".$nombre_foto);
                    $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion); 
                    mysqli_close($conexion);
                    die(error_page("Examen2 Curso 18-19","Video Club",$mensaje));
                }   
            }
            else
                $mensaje_registro="Usuario registrado correctamente con la imagen por defecto por un problema en el servidor";   
        }

        session_name("Examen2_curso18_19");
        session_start();
        $_SESSION["usuario"]=$_POST["usuario"];
        $_SESSION["clave"]=md5($_POST["clave"]);
        $_SESSION["ultimo_acceso"]=time();
        $_SESSION["mensaje_registro"]=$mensaje_registro;
        header("Location:clientes.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 Curso 18-19</title>
</head>
<body>
<h1>Video Club</h1>
    <form action="registro_usuario.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Nombre de usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php
            if(isset($_POST["btnContinuarRegistro"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* Usuario repetido *</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" />
            <?php
            if(isset($_POST["btnContinuarRegistro"])&& $error_clave)
            {
                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave2">Repita contraseña: </label>
            <input type="password" name="clave2" id="clave2"/>
            <?php
            if(isset($_POST["btnContinuarRegistro"])&& $error_clave2)
            {
                echo "<span class='error'>* No has repetido bien la clave *</span>";
            }
            ?>
        </p>
        <p>
            <label for="foto">Foto: (Archivo imagen Máx 500KB)</label>
            <input type="file" name="foto" id="foto" accept="image/*"/>
            <?php
            if(isset($_POST["btnContinuarRegistro"])&& $error_foto)
            {
                if($_FILES["foto"]["error"])
                    echo "<span class='error'>* Error subiendo foto al servidor *</span>";
                elseif(!getimagesize($_FILES["foto"]["tmp_name"]))
                    echo "<span class='error'>* No has elegido un fichero de tipo imagen *</span>";
                else
                    echo "<span class='error'>* El tamaño del fichero elegido es superios a 500KB *</span>";
            }
            ?>
        </p>
        </p>
        <p>
            <button type="submit" formaction="index.php">Volver</button> 
            <button type="submit" name="btnContinuarRegistro">Continuar</button> 
        </p>
    </form>
</body>
</html>