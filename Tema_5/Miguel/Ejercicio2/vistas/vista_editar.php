<?php
//Primero cojo los datos para rellenar el formulario
if(isset($_POST["btnEditar"]))
{
    //Cojo valores de la BD
    $cod=$_POST["btnEditar"];
    $url=DIR_SERV."/producto/".urlencode($cod);
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj)
        die("<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta."</div></body></html>");

    if(isset($obj->mensaje_error))
        die("<p>".$obj->mensaje_error."</p></div></body></html>");

    if(!$obj->producto)
        $error_concurrencia="<p>El producto ya no se encuentra en la BD</p>";
    else
    {
        $nombre=$obj->producto->nombre;
        $nombre_corto=$obj->producto->nombre_corto;
        $descripcion=$obj->producto->descripcion;
        $PVP=$obj->producto->PVP;
        $familia=$obj->producto->familia;
    }
}
else
{
    //Cojo valores de los $_POST
    $cod=$_POST["btnContEditar"];
    $nombre=$_POST["nombre"];
    $nombre_corto=$_POST["nombre_corto"];
    $descripcion=$_POST["descripcion"];
    $PVP=$_POST["PVP"];
    $familia=$_POST["familia"];
}

echo "<h2 class='centro'>Editando el produncto con cod:".$cod." </h2>";
if(isset($error_concurrencia))
{
    echo "<form action='index.php' method='post'>";
    echo "<p>El producto ya no se encuentra en la BD</p>";
    echo "<p><button>Volver</button></p></form>";
    echo "</div>";
}
else
{
    $url=DIR_SERV."/familias";
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj)
        die("<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta."</body></html>");

    if(isset($obj->mensaje_error))
        die("<p>".$obj->mensaje_error."</p></body></html>");

    if(!$obj->familias)
    {
        echo "<form class='centrado centro' action='index.php' method='post'>";
        echo "<h2>Creando un Producto</h2>";
        echo "<p>Aún no hay familias de los productos en la BD. Inserte alguna antes de Añadir un nuevo producto</p>";
        echo "<p><button>Volver</button></p>";
        echo "</form>";
    }
    else
    {

?>
    <form class="centro" action="index.php" method="post">
        
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre;?>"/>
        </p>
        <p>
            <label for="nombre_corto">Nombre corto: </label>
            <input type="text" name="nombre_corto" id="nombre_corto" value="<?php echo $nombre_corto;?>"/>
            <?php
                if(isset($_POST["btnContEditar"]) && $error_nombre_corto)
                        echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <label for="descripcion">Descripción: </label>
            <textarea name="descripcion" id="descripcion"><?php echo $descripcion;?></textarea>
            <?php
                if(isset($_POST["btnContEditar"]) && $error_descripcion)
                        echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <label for="PVP">PVP: </label>
            <input type="text"  name="PVP" id="PVP" value="<?php echo $PVP;?>"/>
            <?php
                if(isset($_POST["btnContEditar"]) && $error_PVP)
                {
                    if($_POST["PVP"]=="")
                        echo "<span class='error'> Campo Vacío</span>";
                    else
                        echo "<span class='error'> Cuantía no válida</span>"; 
                }
            ?>
        </p>
        <p>
            <label for="familia">Seleccione una familia: </label>
            <select id="familia" name="familia">
            <?php
            foreach ($obj->familias as $tupla) 
            {
                if($familia==$tupla->cod)
                    echo "<option selected value='".$tupla->cod."'>".$tupla->nombre."</option>";
                else
                    echo "<option value='".$tupla->cod."'>".$tupla->nombre."</option>";
            }
            ?>
            </select>
        </p>
        <p>
            <button>Volver</button> <button value="<?php echo $cod;?>" name="btnContEditar">Continuar</button>
        </p>
    </form>
<?php
    }
}
?>