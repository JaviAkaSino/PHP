<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO - Ejercicio 1</title>
</head>
<body>
    <?php
    require "class_fruta.php";

    $pera = new Fruta();

    $pera->setColor("verde");
    $pera->setTamanio("mediano");

    echo "<h1>Información de mi fruta - Pera</h1>";
    echo "<p><strong>Color: </strong>".$pera->getColor()."</p>";
    echo "<p><strong>Tamaño: </strong>".$pera->getTamanio()."</p>";

    ?>
</body>
</html>