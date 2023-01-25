<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO - Ejercicio 7</title>
</head>
<body>
    <?php
        require "class_pelicula.php";

        $peli1 = new Pelicula("Enola Holmes", 2020, "Harry Bradbeer", 3.5, true, "2023/01/08");
        $peli1->imprimir();
        $peli2 = new Pelicula("Enola Holmes 2", 2022, "Harry Bradbeer", 5, false, null);
        $peli2->imprimir();
    ?>
</body>
</html>