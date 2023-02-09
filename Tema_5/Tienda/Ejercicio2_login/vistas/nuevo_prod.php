<?php
echo "<div class='centro'>";
echo "<h2>Insertar nuevo producto</h2>";

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
            <label for="codigo">Código: </label>
            <input type="text" id="codigo" name="codigo" maxlength="12" value="<?php if (isset($_POST["codigo"])) echo $_POST["codigo"]  ?>" />
            <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_codigo) {
                if ($_POST["codigo"] == "")
                    echo "<span class='error'>* Campo vacío</span>";
                else
                    echo "<span class='error'>* Código repetido</span>";
            }
            ?>
        </p>

        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]  ?>" />
        </p>

        <p>
            <label for="nombre_corto">Nombre corto: </label>
            <input type="text" id="nombre_corto" name="nombre_corto" value="<?php if (isset($_POST["nombre_corto"])) echo $_POST["nombre_corto"]  ?>" />
            <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_nombre_corto)
                echo "<span class='error'>* Campo vacío</span>" ?>
        </p>

        <p>
            <label for="descripcion">Descripción: </label>
            <textarea id="descripcion" name="descripcion"><?php if (isset($_POST["descripcion"])) echo $_POST["descripcion"]  ?></textarea>
            <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_descripcion)
                echo "<span class='error'>* Campo vacío</span>" ?>
        </p>

        <p>
            <label for="precio">Precio: </label>
            <input type="number" id="precio" name="precio" value="<?php if (isset($_POST["precio"])) echo $_POST["precio"]  ?>" />
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
            if (isset($_POST["boton_confirmar_nuevo"]) && $_POST["familia"] == $tupla->cod)
                echo "<option value='" . $tupla->cod . "' selected>" . $tupla->nombre . "</option>";
            else
                echo "<option value='" . $tupla->cod . "'>" . $tupla->nombre . "</option>";
        }
        echo "</select></p>";
    }


    echo "<p>
            <button>Cancelar</button>
            <button name='boton_confirmar_nuevo'>Confirmar</button>
        </p>

    </form>
    
    </div>";
