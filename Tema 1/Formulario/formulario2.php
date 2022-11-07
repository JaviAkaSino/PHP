<?php
$error_formulario = true;

if (isset($_POST["boton_submit"])) {

    $error_formulario = !isset($_POST["producto"]) || !isset($_POST["cantidad"]);
}

//Array de bebidas
$productos_precios = array("Coca Cola" => 100, "Pepsi Cola" => 80, "Fanta Naranja" => 90, "Trina Manzana" => 120);

if (!$error_formulario) {

?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Ejercicio de formularios 2 - Javier Parodi</title>
    </head>

    <body>
        <h1>Bebidas - Resultado</h1>
        <p>Has pedido <?php echo $_POST["cantidad"] ?> unidades de <?php echo $_POST["producto"] ?></p>
        <p>Precio total: <?php echo $_POST['cantidad'] * $productos_precios[$_POST['producto']] / 100 ?> €</p>
    </body>

    </html>

<?php

} else {
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Ejercicio de formularios 2 - Javier Parodi</title>
    </head>

    <body>
        <h1>Bebidas - Formulario</h1>
        <form method="post" action="formulario2.php">
            <select id="producto" name="producto">
                <option id="cocacola" value="Coca Cola">Coca Cola (1 €)</option>
                <option id="pepsi" value="Pepsi Cola">Pepsi Cola (0.80 €)</option>
                <option id="fanta_naranja" value="Fanta Naranja">Fanta Naranja (0.90 €)</option>
                <option id="trina_manzana" value="Trina Manzana">Trina Manzana (1.20 €)</option>
            </select>

            <select id="cantidad" name="cantidad">
                <option id="1" value="1">1</option>
                <option id="2" value="2">2</option>
                <option id="3" value="3">3</option>
                <option id="4" value="4">4</option>
                <option id="5" value="5">5</option>
            </select>

            <button type="submit" name="boton_submit">Comprar</button>
        </form>
    </body>

    </html>
<?php
}
?>