<?php
session_name("ej03");
session_start();
if (isset($_POST["boton_menos"])) {
    $_SESSION["contador"]--;
    header("Location:ej03_01.php");
    exit;
} else if (isset($_POST["boton_mas"])) {
    $_SESSION["contador"]++;
    header("Location:ej03_01.php");
    exit;
} else if (isset($_POST["boton_reset"])) {
    session_destroy();
    header("Location:ej03_01.php");
    exit;
} else {
    header("Location:ej03_01.php");
    exit;
}
