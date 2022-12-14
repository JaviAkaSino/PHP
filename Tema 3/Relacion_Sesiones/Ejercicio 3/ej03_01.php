<?php
session_name("ej03");
session_start();
if (!isset($_SESSION["contador"]))
    $_SESSION["contador"] = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sesiones - Ejercicio 3</title>
    <style>
         span, p#numero>button{
            font: xx-large bold;
        }
        
    </style>
</head>

<body>
    <h2>SUBIR Y BAJAR NUMEROS</h2>
    <form action="ej03_02.php" method="post">
        <p>Haga click en los botones para modificar el valor:</p>
        <p>
            <?php
            if (isset($_SESSION["error"])) {
                echo "<span class='error'>" . $_SESSION["error"] . "</span>";
                unset($_SESSION["error"]);
            }
            ?>
        </p>
        <p id="numero">
            <button type="submit" name="boton_menos">-</button>
            <span><?php echo $_SESSION["contador"]?></span>
            <button type="submit" name="boton_mas">+</button>
        </p>
        <p>
            <button type="submit" name="boton_reset">Poner a cero</button>
        </p>
    </form>
</body>

</html>