<?php
session_name("ej08");
session_start();
if (isset($_POST["accion"])) {
    if ($_POST["accion"] == "a") {
        $_SESSION["numero_a"] = rand(1, 6);
        $_SESSION["pos_a"] += $_SESSION["numero_a"];
        
    } else if ($_POST["accion"] == "b") {
        $_SESSION["numero_b"] = rand(1, 6);
        $_SESSION["pos_b"] += $_SESSION["numero_b"];
    } else {
        session_destroy();
    }
}
header("Location:ej08_01.php");
exit;
