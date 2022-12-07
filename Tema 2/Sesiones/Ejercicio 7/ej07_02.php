<?php
session_name("ej07");
session_start();
if (isset($_POST["accion"])) {
    if ($_POST["accion"] == "menos") {
        $_SESSION["numero"] -= 1;
    } else if ($_POST["accion"] == "mas") {
        $_SESSION["numero"] += 1;
    } else {
        $_SESSION["accion"] = "tirar";
    }
} else {
    session_destroy();
}
header("Location:ej07_01.php");
exit;
