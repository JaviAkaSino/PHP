<?php
define("MINUTOS",5);


$key["api_session"]=$_SESSION["api_session"];
$url=DIR_SERV."/logueado";
$respuesta=consumir_servicios_REST($url,"POST",$key);
$obj=json_decode($respuesta);
if(!$obj)
{
    $url=DIR_SERV."/salir";
    $respuesta=consumir_servicios_REST($url,"POST",$key);
    session_destroy();
    die(error_page("Login SW","Login SW","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));
}
if(isset($obj->error))
{
    
    $url=DIR_SERV."/salir";
    $respuesta=consumir_servicios_REST($url,"POST",$key);
    session_destroy();
    die(error_page("Login SW","Login SW","<p>".$obj->error."</p>"));
}

if(isset($obj->no_login))
{
    session_unset();
    $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado.";
    header("Location:index.php");
    exit;
}

if(isset($obj->mensaje))
{
    $url=DIR_SERV."/salir";
    $respuesta=consumir_servicios_REST($url,"POST",$key);
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}
else
{
    $datos_usuario_log=$obj->usuario;
}

if(time()-$_SESSION["ultimo_acceso"]>MINUTOS*60)
{
    $url=DIR_SERV."/salir";
    $respuesta=consumir_servicios_REST($url,"POST",$key);
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}

$_SESSION["ultimo_acceso"]=time();
?>