<?php

session_name("Ejercicio2_SW");
session_start();

function consumir_servicios_rest($url, $metodo, $datos = null)
{
    $llamada = curl_init(); //Prepara para hacer la llamada
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);

    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));

    $respuesta = curl_exec($llamada); //Ejecuta la llamada
    curl_close($llamada); //Cierra 

    return $respuesta;
}

function pag_error($title, $encabezado, $mensaje)
{

    return "<!DOCTYPE html>
    <html lang='es''>
    <head>
        <meta charset='UTF-8'>
        <title>" . $title . "</title>
    </head>
    <body>
        <h1>" . $encabezado . "</h1><p>" . $mensaje . "</p>
    </body>
    </html>";
}

define("DIR_SERV", "http://localhost/PHP/Tema_5/Ejercicio1/servicios_rest");


/********************************** NUEVO - CONFIRMAR ************************************/

if (isset($_POST["boton_confirmar_nuevo"])) {

    $error_codigo = $_POST["codigo"] == "";

    if (!$error_codigo) {

        $url = DIR_SERV . "/repet_insert/producto/cod/" . urlencode($_POST["codigo"]);
        $respuesta = consumir_servicios_rest($url, "GET");
        $obj = json_decode($respuesta);

        if (isset($obj->mensaje_error))
            die(pag_error("CRUD - Servicios WEB", "Listado de productos", $obj->mensaje_error));
        if (!$obj)
            die(pag_error("CRUD - Servicios WEB", "Listado de productos", "Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));

        $error_codigo = $obj->repetido;
    }
    $error_nombre_corto = $_POST["nombre_corto"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || $_POST["precio"] < 0;

    $error_form = $error_codigo;

    if (!$error_form) {

        $datos_insert["cod"] = $_POST["codigo"];
        $datos_insert["nombre"] = $_POST["nombre"];
        $datos_insert["nombre_corto"] = $_POST["nombre_corto"];
        $datos_insert["descripcion"] = $_POST["descripcion"];
        $datos_insert["PVP"] = $_POST["precio"];
        $datos_insert["familia"] = $_POST["familia"];

        $url = DIR_SERV ."/producto/insertar";
        $respuesta = consumir_servicios_rest($url, "POST", $datos_insert);
        $obj = json_decode($respuesta);

        if (isset($obj->mensaje_error))
            die(pag_error("CRUD - Servicios WEB", "Listado de productos", $obj->mensaje_error));
        if (!$obj)
            die(pag_error("CRUD - Servicios WEB", "Listado de productos", "Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));
        else {
            $_SESSION["mensaje_accion"] = "miaaaaau";

            header("Location:index.php");
            exit;
        }


    }
}

/********************************** EDITAR - CONFIRMAR ************************************/

/********************************** BORRAR - CONFIRMAR ************************************/

if (isset($_POST["boton_confirmar_borrar"])) {

    $url = DIR_SERV . "/producto/borrar" . urlencode($_POST["boton_confirmar_borrar"]);
    $respuesta = consumir_servicios_rest($url, "DELETE");
    $obj = json_decode($respuesta);

    if (isset($obj->mensaje_error))
        die(pag_error("CRUD - Servicios WEB", "CRUD - Servicios WEB", "Error consumiendo el servicio REST: " . $url . "</>" . $respuesta));

    if (!$obj)
        die(pag_error("CRUD - Servicios WEB", "CRUD - Servicios WEB",  "<p>El producto ya no se encuentra en la BD</p>"));


    $_SESSION["mensaje_accion"] = "El producto se ha borrado con éxito";
    header("Location.index.php");
    exit;
}



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Servicios WEB</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

        th {
            background-color: #FF600A;
        }

        .centro {
            width: 80%;
            margin: auto;
        }

        .texto-centrado {
            text-align: center;
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: #FF600A;
            cursor: pointer;
            font-weight: bold;
        }

        #boton_nuevo {
            border: none;
            background: none;
            font-weight: bold;
            cursor: pointer;
            color: white;
        }
    </style>
</head>

<body>
    <h1 class="texto-centrado">Listado de productos</h1>
    <div class="centro">
        <?php
        /*********************************** INFO DEL PRODUCTO ***********************************/
        if (isset($_POST["boton_producto"])) {

            echo "<div class='centro'>";



            echo "<h2>Información del producto " . $_POST["boton_producto"] . "</h2>";

            $url = DIR_SERV . "/producto/" . urlencode($_POST["boton_producto"]);
            $respuesta = consumir_servicios_rest($url, "GET");
            $obj = json_decode($respuesta);

            if (isset($obj->mensaje_error))
                die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</div></body></html>");

            if (!$obj->producto)
                echo "<p>El producto ya no se encuentra en la BD</p>";

            else {

                /************ LLAMAR A LA FAMILIA ************/

                $url = DIR_SERV . "/familia/" . urlencode($obj->producto->familia);
                $respuesta = consumir_servicios_rest($url, "GET");
                $obj2 = json_decode($respuesta);

                if (isset($obj2->mensaje_error))
                    die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</div></body></html>");

                if (!$obj2->familia)
                    $familia = $obj2->producto->familia;

                else {
                    $familia = $obj2->familia->nombre;
                }

                echo "<p><strong>Nombre: </strong>" . $obj->producto->nombre . "</p>";
                echo "<p><strong>Nombre corto: </strong>" . $obj->producto->nombre_corto . "</p>";
                echo "<p><strong>Descripción: </strong>" . $obj->producto->descripcion . "</p>";
                echo "<p><strong>P.V.P.: </strong>" . $obj->producto->PVP . "€</p>";
                echo "<p><strong>Familia: </strong>" . $familia . "</p>";
            }
            echo "</div>";
        }

        /*********************************** NUEVO PRODUCTO ***********************************/

        if (isset($_POST["boton_nuevo"]) || isset($_POST["boton_confirmar_nuevo"]) && $error_form) {

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
                    ?>

                    <p>
                        <button>Cancelar</button>
                        <button name='boton_confirmar_nuevo'>Confirmar</button>
                    </p>

                </form>




            <?php

        }


        /*********************************** EDITAR PRODUCTO ***********************************/


        /*********************************** BORRAR PRODUCTO ***********************************/

        if (isset($_POST["boton_borrar"])) {

            echo "<div class='texto-centrado'>
                <p>Se dispone usted a borrar el producto " . $_POST["boton_borrar"] . "</p>
                <form action='index.php' method='post'>
                    <button>Cancelar</button>
                    <button name='boton_confirmar_borrar' value='" . $_POST["boton_borrar"] . "'>Confirmar</button>
                </form>
            </div>";
        }



        /****************************** TABLA DE PRODUCTOS *****************************/
        $url = DIR_SERV . "/productos";
        $respuesta = consumir_servicios_rest($url, "GET");

        $obj = json_decode($respuesta);

        if (!$obj) {
            die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");
        }

        //Si falla la bd
        if (isset($obj->mensaje_error))
            die("<p>" . $obj->mensaje_error . "</p></body></html>");


        echo "<table class='texto-centrado'>";
        echo "<tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>PVP</th>
            <th><form action='index.php' method='post'><label for='boton_nuevo'>Producto</label><button name='boton_nuevo' id='boton_nuevo'>[+]</button></form></th>
        </tr>";
        foreach ($obj->productos as $tupla) {

            echo "<tr>";
            echo "<td><form action='index.php' method='post'><button name='boton_producto' value='" . $tupla->cod . "' class='enlace'>" . $tupla->cod . "</button></form></td>";
            echo "<td>" . $tupla->nombre_corto . "</td>";
            echo "<td>" . $tupla->PVP . "</td>";
            echo "<td><form action='index.php' method='post'>
                    <button type='submit' name='boton_borrar' value='" . $tupla->cod . "' class='enlace' >Borrar</button>
                     - 
                    <button type='submit' name='boton_borrar' value='" . $tupla->cod . "' class='enlace'>Editar</button>
                </form></td>";
            echo "</tr>";
        }
        echo "</table>";

        if (isset($_SESSION["mensaje_accion"])) {

            echo "<p class='centro texto-centrado'>" . $_SESSION["mensaje_accion"] . "</p>";
            unset($_SESSION["mensaje_accion"]);
        }

            ?>
    </div>
</body>

</html>