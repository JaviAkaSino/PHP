<?php
session_name("ej05");
session_start();
if (!isset($_SESSION["pos_x"]))
    $_SESSION["pos_x"] = 0;

if (!isset($_SESSION["pos_y"]))
    $_SESSION["pos_y"] = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sesiones - Ejercicio 4</title>
    <style>
        div#todo {
            display: flex;
            flex-flow: column;
            align-items: center;
        }

        p#manos>button {
            font-size: 60px;
            line-height: 40px;
        }

        svg {
            border: 2px solid black;
        }
    </style>
</head>

<body>
    <h2>MOVER UN PUNTO A DERECHA E IZQUIERDA</h2>
    <form action="ej05_02.php" method="post">
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
                <button type="submit" name="accion" value="arriba">&#x261D;</button>
                <button type="submit" name="accion" value="izquierda">&#x261C;</button>
                <button type="submit" name="accion" value="derecha">&#x261E;</button>
                <button type="submit" name="accion" value="abajo">&#x261F;</button>
            </p>
            <p>
                <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="400px" height="400px" viewbox="-200 -200 400 400">
                    <circle cx="<?php echo $_SESSION["pos_x"] ?>" cy="<?php echo $_SESSION["pos_y"] ?>" r="8" fill="red" />
                </svg>
            </p>

        </div>

        <p>
            <button type="submit" name="boton_reset">Volver al centro</button>
        </p>
    </form>
</body>

</html>