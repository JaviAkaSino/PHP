<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO - Ejercicio 5</title>
</head>

<body>
    <?php
    require "class_empleado.php";

    echo "<h1>Lista de empleados</h1>";
    $emp1 = new Empleado("Acutuc", 2000);
    $emp2 = new Empleado("Orelein", 5000);

    $emp1->imprimir();
    $emp2->imprimir();
    ?>
</body>

</html>