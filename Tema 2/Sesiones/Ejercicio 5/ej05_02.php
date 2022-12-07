<?php
session_name("ej05");
session_start();
if (isset($_POST["accion"])) {
    if ($_POST["accion"] == "izquierda") {

        if ($_SESSION["pos_x"] == -200) {
            $_SESSION["pos_x"] = 200;
        } else {
            $_SESSION["pos_x"] -= 20;
        }
    } else if ($_POST["accion"] == "derecha") {

        if ($_SESSION["pos_x"] == 200) {
            $_SESSION["pos_x"] = -200;
        } else {
            $_SESSION["pos_x"] += 20;
        }
    } else if ($_POST["accion"] == "arriba") {

        if ($_SESSION["pos_y"] == -200) {
            $_SESSION["pos_y"] = 200;
        } else {
            $_SESSION["pos_y"] -= 20;
        }
    } else {

        if ($_SESSION["pos_y"] == 200) {
            $_SESSION["pos_y"] = -200;
        } else {
            $_SESSION["pos_y"] += 20;
        }
    }
} else if (isset($_POST["boton_reset"])) {
    session_destroy();
}
header("Location:ej05_01.php");
exit;
