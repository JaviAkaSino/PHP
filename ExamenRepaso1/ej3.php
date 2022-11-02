<?php

function num_palabras($str, $sep)
{
    $i = 0;
    $lista = [];
    $palabra = "";

    while (isset($str[$i])) {

        if ($str[$i] != $sep) {

            $palabra .= $str[$i];
        } else {
            if ($palabra != "") {

                $lista[] = $palabra;
                $palabra = "";
            }
        }
        $i++;
    }

    if ($palabra != "")
        $lista[] = $palabra; //Ultima palabra
    return count($lista);
}

if (isset($_POST["boton_submit"]))
    $error_form = $_POST["texto"] == "";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <h1>num_palabras</h1>

    <h2>Formulario</h2>
    <form action="ej3.php" method="post">

        <label for="texto">Texto: </label>
        <input type="text" id="texto" name="texto" value="<?php if (isset($_POST["texto"])) echo $_POST["texto"] ?>" />

        <?php

        if (isset($_POST["boton_submit"]) && $error_form)
            echo "<p>error</p>";

        ?>
        <label for="separador">Separador:</label>
        <select id="separador" name="separador">

            <option value=",">,</option>
            <option value=";">;</option>
            <option value=" ">espacio</option>
            <option value=":">:</option>

        </select>

        <button name="boton_submit">Contar</button>
    </form>


    <?php

    if (isset($_POST["boton_submit"]) && !$error_form) {

        echo "<p>" . num_palabras($_POST["texto"], $_POST["separador"]) . "</p>";
    }


    ?>


</body>

</html>