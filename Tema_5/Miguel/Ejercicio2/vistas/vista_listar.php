<?php
echo "<div class='centro'>";
echo "<h2>Información del producto: ".$_POST["btnListar"]."</h2>";

$url=DIR_SERV."/producto/".urlencode($_POST["btnListar"]);
$respuesta=consumir_servicios_REST($url,"GET");
$obj=json_decode($respuesta);
if(!$obj)
    die("<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta."</div></body></html>");

if(isset($obj->mensaje_error))
    die("<p>".$obj->mensaje_error."</p></div></body></html>");

if(!$obj->producto)
    echo "<p>El producto ya no se encuentra en la BD</p>";
else
{
    $url=DIR_SERV."/familia/".urlencode($obj->producto->familia);
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj2=json_decode($respuesta);
    if(!$obj2)
        die("<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta."</div></body></html>");

    if(isset($obj2->mensaje_error))
        die("<p>".$obj2->mensaje_error."</p></div></body></html>");

    if(!$obj2->familia)
        $familia=$obj->producto->familia;
    else
        $familia=$obj2->familia->nombre;
    

    echo "<p>";
    echo "<strong>Nombre: </strong>".$obj->producto->nombre."<br/>";
    echo "<strong>Nombre corto: </strong>".$obj->producto->nombre_corto."<br/>";
    echo "<strong>Descripción: </strong>".$obj->producto->descripcion."<br/>";
    echo "<strong>PVP: </strong>".$obj->producto->PVP."€<br/>";
    echo "<strong>Familia: </strong>".$familia."<br/>";
    echo "</p>";
}
echo "<form action='index.php' method='post'><button>Volver</button></form>";
echo "</div>";
?>