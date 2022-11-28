<?php
session_name("ej01");
session_start(); //Para este navegador hay variables creadas? Voy a usarlas. Si no, preparate
if (isset($_POST["boton_siguiente"])) {

    if ($_POST["nombre"] == "") {

        $_SESSION["error"] = "* Campo vacío *";
        header("Location:ej01_01.php");
        exit;
    } else {
        $_SESSION["nombre"] = $_POST["nombre"];
    }
} else if (isset($_POST["boton_borrar"])) {
    session_destroy();
    header("Location:ej01_01.php");
    exit;
} else {
    header("Location:ej01_01.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sesiones - Ejercicio 1</title>
    <style>
        label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>FORMULARIO NOMBRE 1 (RESPUESTA)</h2>
    <p>Su nombre es: <strong><?php echo $_SESSION["nombre"]; ?></strong></p>
    <p><a href="ej01_01.php">Volver</a></p>
</body>

</html>