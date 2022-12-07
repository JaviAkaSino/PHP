<?php
session_name("ej06");
session_start();
if (isset($_POST["accion"])) {
    if ($_POST["accion"] == "azul") {
        $_SESSION["pos_azul"] += 10;

    } else if ($_POST["accion"] == "naranja") {
        $_SESSION["pos_naranja"] += 10;
        
    } else {
        session_destroy();
    }
}
header("Location:ej06_01.php");
exit;
