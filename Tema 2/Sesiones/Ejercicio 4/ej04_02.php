<?php
session_name("ej04");
session_start();
if (isset($_POST["accion"])) {
    if ($_POST["accion"] == "izquierda") {

        if ($_SESSION["pos_x"] == -300) {
            $_SESSION["pos_x"] = 300;
        } else {
            $_SESSION["pos_x"] -= 20;
        }
    } else {

        if ($_SESSION["pos_x"] == 300) {
            $_SESSION["pos_x"] = -300;
        } else {
            $_SESSION["pos_x"] += 20;
        }
    }
} else if (isset($_POST["boton_reset"])) {
    session_destroy();
} 
    header("Location:ej04_01.php");
    exit;

