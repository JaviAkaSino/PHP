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
        * {
            box-sizing: border-box;
        }

        div#todo {
            display: flex;
            flex-flow: row;
            justify-content: space-around;
            align-items: center;
        }

        div#manos {
            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;
            height: 250px;
            width: 250px;
        }

        div#manos>div {
            flex: 30%;
            display: flex;
            justify-content: center;
            margin: 0;
            height: 70px;
        }

        div#manos>div>button {
            height: 70px;
            width: 70px;
        }

        div#manos>div.solo {
            flex: 100%
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

        <div id="todo">

            <div id="manos">
                <div class="solo">
                    <button type="submit" name="accion" value="arriba">&#x1F446;</button>
                </div>
                <div>
                    <button type="submit" name="accion" value="izquierda">&#x1F448;</button>
                </div>
                <div>
                    <button type="submit" name="boton_reset" id="volver">Volver al centro</button>
                </div>
                <div>
                    <button type="submit" name="accion" value="derecha">&#x1F449;</button>
                </div>
                <div class="solo">
                    <button type="submit" name="accion" value="abajo">&#x1F447;</button>
                </div>
            </div>


            <p>
                <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="400px" height="400px" viewbox="-200 -200 400 400">
                    <circle cx="<?php echo $_SESSION["pos_x"] ?>" cy="<?php echo $_SESSION["pos_y"] ?>" r="8" fill="red" />
                </svg>
            </p>

        </div>

    </form>
</body>

</html>