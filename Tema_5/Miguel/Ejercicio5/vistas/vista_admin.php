<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SW</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
    </style>
</head>
<body>
    <h1>Login SW</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log->usuario;?></strong> - 
        <form class="enlinea" method="post" action="index.php">
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    <h2>Listado de los usuarios (no admin)</h2>
    <?php

        $url=DIR_SERV."/usuarios";
        $respuesta=consumir_servicios_REST($url,"GET",$key);
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            $url=DIR_SERV."/salir";
            consumir_servicios_REST($url,"POST",$key);
            session_destroy();
            die("<p>Error consumiendo el servicio: ".$url."</p>".$respuesta."</body></html>");
        }
        if(isset($obj->error))
        {
            $url=DIR_SERV."/salir";
            consumir_servicios_REST($url,"POST",$key);
            session_destroy();
            die("<p>".$obj->error."</p></body></html>");
        }
        
        if(isset($obj->no_login))
        {
            session_unset();
            $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado.";
            header("Location:index.php");
            exit;
        }

        echo "<table>";
        echo "<tr><th>#ID</th><th>Nombre</th><th>Acción</th></tr>";
        foreach($obj->usuarios as $tupla)
        {
            if($tupla->tipo=="normal")
            {
                echo "<tr>";
                echo "<td>".$tupla->id_usuario."</td>";
                echo "<td>".$tupla->nombre."</td>";
                echo "<td>Borrar - Editar</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    ?>
</body>
</html>