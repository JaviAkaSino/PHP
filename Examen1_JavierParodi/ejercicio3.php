<?php

function lista_palabras($str, $sep)
{

    $palabra = "";
    $lista = [];

    for ($i = 0; $i < strlen($str); $i++) {

        if ($str[$i] != $sep) {

            $palabra .= $str[$i];
        } else {

            if ($palabra != "") {

                $lista[] = $palabra;
                $palabra = "";
            }
        }
    }

    if ($palabra != "")
        $lista[] = $palabra;

    return $lista;
}

function solo_letras($str)
{
    $res = "";
    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] >= "A" && $str[$i] <= "Z")
            $res .= $str[$i];
    }
    return $res;
}


function codificar($texto, $matriz)
{

    $codificado = "";
    for ($i = 0; $i < strlen($texto); $i++) {

        //Si el caracter es un numero entre 1 y 5
        if (is_numeric($texto[$i]) && $texto[$i] > 0 && $texto[$i] <= 5) {
            //Miramos el siguiente
            if ($i < strlen($texto) - 1 && is_numeric($texto[$i + 1]) && $texto[$i + 1] > 0 && $texto[$i + 1] <= 5) {
                //Coge de la matriz el caracter correspondiente
                $codificado .= solo_letras($matriz[$texto[$i]][$texto[$i + 1]]);
                $i++; //Suma uno al índice para saltar a la siguiente posible pareja
            } else { //Si no es codificable, se deja tal cual
                $codificado .= $texto[$i];
            }
        } elseif ($texto[$i] == "0") { //Si es 0

            if ($texto[$i + 1] == "0") { //Buscamos el otro 0
                $codificado .= "J"; //Si lo hay, es la J
                $i++;
            }
        } else { //Si no hay numérico, se deja tal cual

            $codificado .= $texto[$i];
        }
    }

    return $codificado;
}

if (isset($_POST["boton_submit"])) {

    $error_texto = $_POST["texto"] == "";
    $error_archivo = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"] ||
        $_FILES["archivo"]["type"] != "text/plain" || $_FILES["archivo"]["size"] > 1250000;
    $error_form = $error_texto || $error_archivo;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 3 - Javier Parodi</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 3. Decodifica una frase</h1>

    <form action="ejercicio3.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="texto">Introduzca un texto: </label>
            <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["texto"])) echo $_POST["texto"]; ?>" />
            <?php if (isset($_POST["boton_submit"]) && $error_texto)
                echo "<span class='error'>Campo vacío</span>"; ?>
        </p>
        <p>
            <label for="archivo">Seleccione el archivo de claves (.txt y menor 1.25MB)</label>
            <input type="file" name="archivo" id="archivo" accept=".txt" />

            <?php
            if (isset($_POST["boton_submit"]) && $error_archivo) {

                if ($_FILES["archivo"]["name"] != "") {

                    if ($_FILES["archivo"]["error"])
                        echo "<span class='error'>Error subiendo el archivo al servidor</span>";
                    elseif ($_FILES["archivo"]["type"] != "text/plain")
                        echo "<span class='error'>El archivo debe ser .txt</span>";
                    else
                        echo "<span class='error'>El tamaño del archivo debe ser inferior a 1.25MB</span>";
                }
            }
            ?>
        </p>
        <button type="submit" name="boton_submit">Decodificar</button>
    </form>


    <?php
    if (isset($_POST["boton_submit"]) && !$error_form) {


        $matriz = [];
        echo "<h1>Respuesta</h1>";
        echo "<p>El texto introducido sería: </p>";

        @$file = fopen($_FILES["archivo"]["tmp_name"], "r");

        if (!$file) {

            echo "<span class='error'>No se ha podido abrir el archivo</span>";
        } else {

            $linea = fgets($file); //Quema la primera línea, ya que son índices
            $matriz[] = array(0 => "J");

            while (!feof($file)) {

                $linea = fgets($file);
                $fila = lista_palabras($linea, ";");
                if (count($fila) > 0)
                    $matriz[] = $fila;
            }
            
            echo codificar($_POST["texto"], $matriz);
        }


        fclose($file);
    }
    ?>

</body>

</html>