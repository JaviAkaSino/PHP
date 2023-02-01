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

if (isset($_POST["boton_confirmar_nuevo"])){

    $error_codigo = $_POST["codigo"] == "";

    $error_form = $error_codigo;

}

/********************************** EDITAR - CONFIRMAR ************************************/

/********************************** BORRAR - CONFIRMAR ************************************/

if (isset($_POST["boton_confirmar_borrar"])) {

    $url = DIR_SERV . "/producto/borrar" . urlencode($_POST["boton_confirmar_borrar"]);
    $respuesta = consumir_servicios_rest($url, "DELETE");
    $obj = json_decode($respuesta);

    if (isset($obj->mensaje_error))
        die(pag_error("CRUD - Servicios WEB", "CRUD - Servicios WEB", "Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));

    if (!$obj->producto)
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
                        <label for="codigo">Código</label>
                        <input type="text" id="codigo" name="codigo" maxlength="12" value="<?php if(isset($_POST["codigo"])) echo $_POST["codigo"]  ?>"/>
                        <?php if(isset($_POST["boton_confirmar_nuevo"]) && $error_codigo)
                            echo "<span class='error'>* Campo vacío</span>"?>
                    </p>
                    <p>

                    </p>

                <?php
                echo "<select name='familia' id='familia'>";
                foreach ($obj->familias as $tupla) {
                    echo "<option value='" . $tupla->codigo . "'>" . $tupla->nombre . "</option>";
                }
                echo "</select>";
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