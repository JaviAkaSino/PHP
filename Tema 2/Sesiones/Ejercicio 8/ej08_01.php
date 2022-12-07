<?php
session_name("ej08");
session_start();
if (!isset($_SESSION["pos_a"]))
    $_SESSION["pos_a"] = -300;
if (!isset($_SESSION["pos_b"]))
    $_SESSION["pos_b"] = -300;
if (!isset($_SESSION["numero_a"]))
    $_SESSION["numero_a"] = 1;

if (!isset($_SESSION["numero_b"]))
    $_SESSION["numero_b"] = 1;


function dado($numero)
{
    $dado = "&#9856; ";

    switch ($numero) {
        case 1:
            $dado = "&#9856; ";
            break;

        case 2:
            $dado = "&#9858; ";
            break;

        case 3:
            $dado = "&#9858; ";
            break;

        case 4:
            $dado = "&#9859; ";
            break;

        case 5:
            $dado = "&#9860; ";
            break;

        default:
            $dado = "&#9861; ";
            break;
    }
    return $dado;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sesiones - Ejercicio 8</title>
    <style>
        button {
            height: 3rem;
            width: auto;
            font-weight: bold;
            font-size: 2rem;
        }

        div>button {
            height: 2rem;
            width: auto;
            font-weight: bold;
            font-size: 1rem;
        }

        .dado {
            font-size: 4rem;
        }

        div>p {
            display: flex;
            flex-flow: row;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <h2>TIRADA DE DADOS</h2>




    <form action="ej08_02.php" method="post">
        <p>Haga click en los botones para aumentar o disminuir el número de dados o para volver a tirarlos:</p>

        <div id="todo">

            <p>
                <button type="submit" name="accion" value="a"> A </button>

                <span class="dado"><?php echo dado($_SESSION["numero_a"]); ?></span>

                <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="600px" height="20px" viewbox="-300 0 600 20">
                    <line x1="-300" y1="10" x2="300" y2="10" stroke="black" stroke-width="5" />
                    <circle cx="<?php echo $_SESSION["pos_a"] ?>" cy="10" r="8" fill="red" />
                </svg>
</p>
        <p>
                <button type="submit" name="accion" value="b"> B </button>

                <span class="dado"><?php echo dado($_SESSION["numero_b"]); ?></span>

                <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="600px" height="20px" viewbox="-300 0 600 20">
                    <line x1="-300" y1="10" x2="300" y2="10" stroke="black" stroke-width="5" />
                    <circle cx="<?php echo $_SESSION["pos_b"] ?>" cy="10" r="8" fill="red" />
                </svg>
            </p>

            <button type="submit" name="accion" value="cero">Volver a empezar</button>
        </div>
    </form>

</body>

</html>