<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicio</title>
    <style>
        #contenido {
            display: flex;
            flex-flow: row wrap;
        }
        .info-libro {
            width: 33%;
            display: flex;
            flex-flow: row wrap;
            justify-content: center;
        }
        .foto-libro{
            width: 80%;
        }
        .linea{display:inline}

        .enlace{background:none;border:none;color:blue;text-decoration:underline;cursor: pointer;}
    </style>
</head>

<body>
    <h1>Librería</h1>

    <?php

        echo " <div>
                    Bienvenido/a <strong>".$_SESSION["usuario"]."</strong>
                    <form action='index.php' method='post' class='linea'>
                        <button class='enlace' name='boton_salir'>Salir</button>
                    </form>
            </div>";

    //LISTA LIBROS

    echo "<h2>Listado de los Libros</h2>";



    $url = DIR_SERV . "/obtenerLibros";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);

    if (!$obj) {

        die(error_page("Página de Inicio", "Librería", "Error consumiendo servicios REST: " . $url . "<br/>" . $respuesta));
    }

    if (isset($obj->error)) {

        die(error_page("Página de Inicio", "Librería", $obj->error));
    }

    echo "<div id='contenido'>";

    foreach ($obj->libros as $tupla) {

        echo "<p class= 'info-libro'>
                <img class='foto-libro' src='images/" . $tupla->portada . "' alt='" . $tupla->portada . "'/>
                <span>
                    " . $tupla->titulo . " - " . $tupla->precio . " €
                </span>
            </p>";
    }
    echo "</div>";
    ?>


</body>

</html>