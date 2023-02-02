<?php

if (isset($_POST["boton_editar"])) { //Si vengo por aqui, cojo valores BD

    $cod = $_POST["boton_editar"];

    $url = DIR_SERV . "/producto/" . $cod;
    $respuesta = consumir_servicios_rest($url, "GET");
    $obj = json_decode($respuesta);

    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</div></body></html>");
    }

    if (!$obj)
        die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</div></body></html>");


    if (!$obj->producto) {
        $error_concurrencia = "<p>El prodcuto ya no se encuentra en la BD</p>";
    } else {

        $nombre = $obj->producto->nombre;
        $nombre_corto = $obj->producto->nombre_corto;
        $descripcion = $obj->producto->descripcion;
        $PVP = $obj->producto->PVP;
        $familia = $obj->producto->familia;
    }
} else { //Cojo valores de los $_POST[""]

    $cod = $_POST["boton_confirmar_editar"];
    $nombre = $_POST["nombre"];
    $nombre_corto = $_POST["nombre_corto"];
    $descripcion = $_POST["descripcion"];
    $PVP = $_POST["precio"];
    $familia = $_POST["familia"];
}
echo "<div class='centro'>";
echo "<h2>Editando el producto " . $cod . "</h2>";

if (isset($error_concurrencia)) {
    echo "<p>El producto ya no se encuentra en la BD</p>";
}


$url = DIR_SERV . "/familias";
$respuesta = consumir_servicios_rest($url, "GET");
$obj = json_decode($respuesta);

if (isset($obj->mensaje_error)) {
    die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</div></body></html>");
}

if (!$obj) {
    echo "<p>Aún no existen familias</p>";
    echo "<form action='index.php' method='post'>
        <button>Volver</button>
    </form>";
} else {


?>
    <form action='index.php' method='post'>

        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre;?>" />
        </p>

        <p>
            <label for="nombre_corto">Nombre corto: </label>
            <input type="text" id="nombre_corto" name="nombre_corto" value="<?php echo $nombre_corto ?>" />
            <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_nombre_corto)
                echo "<span class='error'>* Campo vacío</span>" ?>
        </p>

        <p>
            <label for="descripcion">Descripción: </label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea>
            <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_descripcion)
                echo "<span class='error'>* Campo vacío</span>" ?>
        </p>

        <p>
            <label for="precio">Precio: </label>
            <input type="number" id="precio" name="precio" value="<?php echo $PVP  ?>" />
            <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_precio) {
                if ($_POST["precio"] == "")
                    echo "<span class='error'>* Campo vacío</span>";
                else
                    echo "<span class='error'>* Precio inválido</span>";
            }
            ?>
        </p>
        <p>
            <label for="familia">Familia: </label>
            <?php
            echo "<select name='familia' id='familia'>";
            foreach ($obj->familias as $tupla) {
                if ($familia == $tupla->cod)
                    echo "<option value='" . $tupla->cod . "' selected>" . $tupla->nombre . "</option>";
                else
                    echo "<option value='" . $tupla->cod . "'>" . $tupla->nombre . "</option>";
            }
            echo "</select></p>";

            ?>

        <p>
            <button>Cancelar</button>
            <button name='boton_confirmar_editar' value='<?php echo $cod ?>'>Confirmar</button>
        </p>

    </form>

    </div>


<?php
}
