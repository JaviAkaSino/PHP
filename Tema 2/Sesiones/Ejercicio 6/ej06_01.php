<?php
session_name("ej06");
session_start();
if (!isset($_SESSION["pos_azul"]))
    $_SESSION["pos_azul"] = 0;
if (!isset($_SESSION["pos_naranja"]))
    $_SESSION["pos_naranja"] = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sesiones - Ejercicio 6</title>
    <style>
   

        button{
            height: 20px;
            width: auto;
        }
    </style>
</head>

<body>
    <h2>VOTAR UNA OPCIÓN</h2>
    <form action="ej06_02.php" method="post">
        <p>Haga click en los botones para votar por una opción:</p>

        <div id="todo">

            <p>
                <button type="submit" name="accion" value="azul">&#x261C;</button>
                <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="<?php echo $_SESSION["pos_azul"] ?>px" height="20px">
                    <line x1="-300" y1="10" x2="300" y2="10" stroke="blue" stroke-width="20" />
                </svg>
                <br/>
                <br/>
                <button type="submit" name="accion" value="naranja">&#x261E;</button>

                <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="<?php echo $_SESSION["pos_naranja"] ?>px" height="20px">
                    <line x1="-300" y1="10" x2="300" y2="10" stroke="orange" stroke-width="20" />
                </svg>
            </p>

            <button type="submit" name="accion" value="cero">Poner a cero</button>
        </div>
    </form>
</body>

</html>