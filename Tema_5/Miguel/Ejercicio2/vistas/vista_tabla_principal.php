<?php
$url=DIR_SERV."/productos";
$respuesta=consumir_servicios_REST($url,"GET");
$obj=json_decode($respuesta);
if(!$obj)
    die("<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta."</body></html>");

if(isset($obj->mensaje_error))
    die("<p>".$obj->mensaje_error."</p></body></html>");

echo "<table class='centrado centro'>";
echo "<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><form action='index.php' method='post'><button class='enlace' name='btnNuevo'>Producto+</button></form></th></tr>";

foreach($obj->productos as $tupla)
{
    echo "<tr>";
    echo "<td><form action='index.php' method='post'><button name='btnListar' class='enlace' value='".$tupla->cod."'>".$tupla->cod."</button></form></td>";
    echo "<td>".$tupla->nombre_corto."</td>";
    echo "<td>".$tupla->PVP."</td>";
    echo "<td><form action='index.php' method='post'><button name='btnBorrar' class='enlace' value='".$tupla->cod."'>Borrar</button> - <button name='btnEditar' class='enlace' value='".$tupla->cod."'>Editar</button></form></td>";
    echo "</tr>";
}
echo "<table>";
?>