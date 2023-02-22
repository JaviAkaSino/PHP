<?php
session_name("Ejer2_SW_Curso22_23");
session_start();

function consumir_servicios_REST($url,$metodo,$datos=null)
{
    $llamada=curl_init();
    curl_setopt($llamada,CURLOPT_URL,$url);
    curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
    if(isset($datos))
        curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
    $respuesta=curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

function error_page($title,$cabecera,$mensaje)
{
    return '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>
    </head>
    <body>
        <h1>'.$cabecera.'</h1>'.$mensaje.'
    </body>
    </html>';
}

define("DIR_SERV","http://localhost/PHP/Tema_5/Miguel/Ejercicio1/servicios_rest_ejer1");

if(isset($_POST["btnContBorrar"]))
{
    $url=DIR_SERV."/producto/borrar/".urlencode($_POST["btnContBorrar"]);
        $respuesta=consumir_servicios_REST($url,"DELETE");
        $obj=json_decode($respuesta);
        if(!$obj)
            die(error_page("CRUD - SW","Listado de los Productos","<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta));

        if(isset($obj->mensaje_error))
            die(error_page("CRUD - SW","Listado de los Productos","<p>".$obj->mensaje_error."</p>"));
        
        $_SESSION["accion"]="El producto se ha borrado con éxito";
        header("Location:index.php");
        exit;
}

if(isset($_POST["btnContNuevo"]))
{
    $error_cod=$_POST["cod"]=="";
    if(!$error_cod)
    {
        $url=DIR_SERV."/repetido_insert/producto/cod/".urlencode($_POST["cod"]);
        $respuesta=consumir_servicios_REST($url,"GET");
        $obj=json_decode($respuesta);
        if(!$obj)
            die(error_page("CRUD - SW","Listado de los Productos","<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta));

        if(isset($obj->mensaje_error))
            die(error_page("CRUD - SW","Listado de los Productos","<p>".$obj->mensaje_error."</p>"));
        
        $error_cod=$obj->repetido;
    }

    $error_nombre_corto=$_POST["nombre_corto"]=="";
    $error_descripcion=$_POST["descripcion"]=="";
    $error_PVP=$_POST["PVP"]==""||!is_numeric($_POST["PVP"])||$_POST["PVP"]<=0;

    $error_form=$error_cod ||$error_nombre_corto || $error_descripcion || $error_PVP;

    if(!$error_form)
    {
        $datos_insert['cod']=strtoupper($_POST["cod"]);
        $datos_insert['nombre']=$_POST["nombre"];
        $datos_insert['nombre_corto']=$_POST["nombre_corto"];
        $datos_insert['descripcion']=$_POST["descripcion"];
        $datos_insert['PVP']=$_POST["PVP"];
        $datos_insert['familia']=$_POST["familia"];

        $url=DIR_SERV."/producto/insertar";
        $respuesta=consumir_servicios_REST($url,"POST",$datos_insert);
        $obj=json_decode($respuesta);
        if(!$obj)
            die(error_page("CRUD - SW","Listado de los Productos","<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta));

        if(isset($obj->mensaje_error))
            die(error_page("CRUD - SW","Listado de los Productos","<p>".$obj->mensaje_error."</p>"));
        

        $_SESSION["accion"]="El producto con cod: <strong>".$obj->mensaje."</strong> se ha insertado con éxito";
        header("Location:index.php");
        exit;
    }

    
}

if(isset($_POST["btnContEditar"]))
{
    $error_nombre_corto=$_POST["nombre_corto"]=="";
    $error_descripcion=$_POST["descripcion"]=="";
    $error_PVP=$_POST["PVP"]==""||!is_numeric($_POST["PVP"])||$_POST["PVP"]<=0;

    $error_form=$error_nombre_corto || $error_descripcion || $error_PVP;

    if(!$error_form)
    {
        $datos_edit['nombre']=$_POST["nombre"];
        $datos_edit['nombre_corto']=$_POST["nombre_corto"];
        $datos_edit['descripcion']=$_POST["descripcion"];
        $datos_edit['PVP']=$_POST["PVP"];
        $datos_edit['familia']=$_POST["familia"];

        $url=DIR_SERV."/producto/actualizar/".urlencode(strtoupper($_POST["btnContEditar"]));
        $respuesta=consumir_servicios_REST($url,"PUT",$datos_edit);
        $obj=json_decode($respuesta);
        if(!$obj)
            die(error_page("CRUD - SW","Listado de los Productos","<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta));

        if(isset($obj->mensaje_error))
            die(error_page("CRUD - SW","Listado de los Productos","<p>".$obj->mensaje_error."</p>"));
        
        $_SESSION["accion"]="El producto con cod: <strong>".$obj->mensaje."</strong> se ha actualizado con éxito";
        header("Location:index.php");
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
    <title>CRUD - SW</title>
    <style>
        table,th,td{border:1px solid black}
        table{border-collapse:collapse}
        .centrado{text-align:center}
        .centro{width:80%;margin:0 auto}
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        .mensaje{color:blue;font-size:1.25em}
    </style>
</head>
<body>
    <h1 class="centrado">Listado de los Productos</h1>
    <?php
    if(isset($_POST["btnListar"]))
    {
        require "vistas/vista_listar.php";
    }
    
    if(isset($_POST["btnBorrar"]))
    {
        require "vistas/vista_borrar.php";
    }

    if(isset($_POST["btnNuevo"])|| isset($_POST["btnContNuevo"]) )
    {
        require "vistas/vista_nuevo.php";
    }
    
    if(isset($_POST["btnEditar"])||isset($_POST["btnContEditar"]))
    {
        require "vistas/vista_editar.php";
    }
    
    require "vistas/vista_tabla_principal.php";

    if(isset($_SESSION["accion"]))
    {
        echo "<p class='mensaje centro centrado'>¡¡ ".$_SESSION["accion"]."!!</p>";
        unset($_SESSION["accion"]);
    }
    ?>
    
</body>
</html>