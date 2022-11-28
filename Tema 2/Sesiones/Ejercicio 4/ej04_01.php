<?php
session_name("ej04");
session_start();
if (!isset($_SESSION["pos_x"]))
    $_SESSION["pos_x"] = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sesiones - Ejercicio 4</title>
    <style>
       div#todo{
            display: flex;
            flex-flow: column;
            align-items: center;
        }

        p#manos>button {
            font-size: 60px;
            line-height: 40px;
        }
    </style>
</head>

<body>
    <h2>MOVER UN PUNTO A DERECHA E IZQUIERDA</h2>
    <form action="ej04_02.php" method="post">
        <p>Haga click en los botones para mover el punto:</p>
        <p>
            <?php
            if (isset($_SESSION["error"])) {
                echo "<span class='error'>" . $_SESSION["error"] . "</span>";
                unset($_SESSION["error"]);
            }
            ?>
        </p>
        <div id="todo">

            <p id="manos">
                <button type="submit" name="accion" value="izquierda">&#x261C;</button>
                <button type="submit" name="accion" value="derecha">&#x261E;</button>
            </p>
            <p>
                <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="600px" height="20px" viewbox="-300 0 600 20">
                    <line x1="-300" y1="10" x2="300" y2="10" stroke="black" stroke-width="5" />
                    <circle cx="<?php echo $_SESSION["pos_x"] ?>" cy="10" r="8" fill="red" />
                </svg>
            </p>

        </div>

        <p>
            <button type="submit" name="boton_reset">Volver al centro</button>
        </p>
    </form>
</body>

</html>