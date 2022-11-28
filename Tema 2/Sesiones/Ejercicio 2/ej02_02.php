<?php
session_name("ej02");
session_start(); //Para este navegador hay variables creadas? Voy a usarlas. Si no, preparate
if (isset($_POST["boton_siguiente"])) {

    if ($_POST["nombre"] == "") {

        $_SESSION["error"] = "* Campo vacío *";
        header("Location:ej02_01.php");
        exit;
    } else {
        $_SESSION["nombre"] = $_POST["nombre"];
        header("Location:ej02_01.php");
        exit;
    }
} else if (isset($_POST["boton_borrar"])) {
    session_destroy();
    header("Location:ej02_01.php");
    exit;
} else {
    header("Location:ej02_01.php");
    exit;
}
