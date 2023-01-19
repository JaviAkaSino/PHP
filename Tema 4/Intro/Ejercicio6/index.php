<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO - Ejercicio 6</title>
</head>
<body>
    <?php
    require "class_menu.php";

    $menu = new Menu();

    $menu->cargar("Google", "http://www.google.es");
    $menu->cargar("LinkedIn", "http://www.linkedin.com");
    $menu->cargar("Classroom", "http://www.classroom.google.com");

    $menu->vertical();

    $menu->horizontal();
    ?>
</body>
</html>