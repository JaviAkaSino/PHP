<?php

if (isset($_POST["boton_confirmar_nuevo"])){

    $error_user = $_POST["user"] =="";
    $error_clave = $_POST["clave"] =="";

    $error_form = $error_clave || $error_user;

    if(!$error_form){

        $datos_insert["user"] = $_POST["user"];
        $datos_insert["clave"] = $_POST["clave"];
        $datos_insert["foto"] = $_
        ["user"];

        $url = DIR_SERV . "/repetido_insert";
    }
}


?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub - NORMAL</title>
    <style>
        .enlace {
            border: none;
            background: none;
            color: #FF600A;
            cursor: pointer;
            font-weight: bold;
        }

        .linea {
            display: inline
        }


        table,
        td,
        th {
            border-collapse: collapse;
            border: 1px solid black;
            text-align: center;
        }

        th {
            background-color: #FF600A;
        }
    </style>
</head>

<body>
    <h1>Videoclub - NORMAL</h1>

    <div>Bienvenido/a, <strong><?php echo $_SESSION["usuario"] ?></strong>
        <form class="linea" action="index.php" metohd="post">
            <button class="enlace" type="submit" name="boton_salir">Salir</button>
        </form>
    </div>

    <?php

    //TABLA CLIENTES

    $url = DIR_SERV . "/clientes";
    $respuesta = consumir_servicios_rest($url, "GET", $_SESSION["api_session"]);
    $obj = json_decode($respuesta);

    if (!$obj) {
        $url_salir = DIR_SERV . "/salir";
        consumir_servicios_rest($url_salir, "POST", $_SESSION["api_session"]);
        session_destroy();
        die("<p>Error al consumir servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    if (isset($obj->error)) {
        $url_salir = DIR_SERV . "/salir";
        consumir_servicios_rest($url_salir, "POST", $_SESSION["api_session"]);
        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }

    if (isset($obj->no_login)) {

        session_destroy();
        die("<p>El tiempo de sesión de la API ha expirado. Vuelva a loguearse</p></body></html>");
    }

    echo "<h2>
            Listado de los clientes (" . count($obj->clientes) . ")
            <form class='linea' method='post'><button name='boton_nuevo' class='enlace'> [+] </button></form>
        </h2>";

    //AÑADIR CLIENTE

    if (isset($_POST["boton_nuevo"]) || (isset($_POST["boton_confirmar_nuevo"]) && $error_form)) {

    ?>

        <h3>Añadir cliente</h3>
        <form action="index.php" method="post">
            <p>
                <label for="user">Usuario:</label>
                <input type="text" name="user" id="user" value="<?php if (isset($_POST["user"])) echo $_POST["user"] ?>">
                <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_user) {
                    if ($_POST["user"] == "")
                        echo "<span class='error'>* Campo vacío</span>";
                    else
                        echo "<span class='error'>* Usuario o clave incorrectos</span>";
                }
                ?>
            </p>

            <p>
                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" id="clave">
                <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_clave) {
                        echo "<span class='error'>* Campo vacío</span>";

                }
                ?>
            </p>
            <p>
                <button>Atrás</button>
                <button type="submit" name="boton_confirmar_nuevo">Añadir</button>
            </p>
        </form>

    <?php
    }

    echo "<table>";
    echo "<tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Foto</th>
                <th>Acción</th>
            </tr>";

    foreach ($obj->clientes as $tupla) {

        echo "<tr>
                    <th>" . $tupla->id_cliente . "</th>
                    <td>" . $tupla->usuario . "</td>
                    <td><img src='img/" . $tupla->foto . "' width='100px' height='auto'/></td>
                    <td>
                        <form action='index.php' method='post'>
                            <button class='enlace' name='boton_editar' value='" . $tupla->id_cliente . "'>Editar</button>
                            <span> - </span>
                            <button class='enlace' name='boton_borrar' value='" . $tupla->id_cliente . "'>Borrar</button>
                        </form>
                    </td>
                </tr>";
    }
    echo "</table>";



    ?>
</body>

</html>