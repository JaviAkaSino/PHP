<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO - Ejercicio 4</title>
</head>

<body>
    <?php
    require "class_fruta.php";
    require "class_uva.php";

    echo "<p><strong>Nº frutas: </strong>" . Fruta::cuantaFruta() . "</p>";

    echo "<h1>Información de mi fruta - Pera</h1>";
    $pera = new Fruta("verde", "mediano");
    $pera->imprimir();
    echo "<p><strong>Nº frutas: </strong>" . Fruta::cuantaFruta() . "</p>";

    echo "<h1>Información de mi fruta - Uva negra</h1>";
    $uva_negra = new Uva("negro", "pequeño", true);
    $uva_negra->imprimir();
    echo "<p><strong>Nº frutas: </strong>" . Fruta::cuantaFruta() . "</p>";

    echo "<h1>Información de mi fruta - Uva blanca</h1>";
    $uva_blanca = new Uva("verde", "pequeño", false);
    $uva_blanca->imprimir();
    echo "<p><strong>Nº frutas: </strong>" . Fruta::cuantaFruta() . "</p>";

    echo "<h1>Destruyendo fruta - Pera</h1>";
    unset($pera);
    echo "<p><strong>Nº frutas: </strong>" . Fruta::cuantaFruta() . "</p>";

    ?>
</body>

</html>