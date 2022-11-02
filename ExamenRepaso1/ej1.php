<?php

    function num_caracteres ($str){

        $i = 0;
        while(isset($str[$i])){

            $i++;
        }

        return $i;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>num_caracteres</h1>
<?php

    if(!isset($_POST["boton_submit"])){

?>

<h2>Formulario</h2>
    <form action="ej1.php" method="post">

        <label for="texto">Texto: </label>
        <input type="text" id="texto" name="texto" />

        <button name="boton_submit">Contar</button>
    </form>


<?php

    } else {

        echo "<p>".num_caracteres($_POST["texto"])."</p>";
    }

?>
    

</body>

</html>