<?php
    $error_formulario = true;
    if(isset($_GET["boton_submit"])){

        $error_nombre = $_GET["nombre"] == "";
        $error_apellidos = $_GET["apellidos"] == "";
        $error_formulario = $error_nombre || $error_apellidos;
    }
    
    if (!$error_formulario){
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 1 Formularios - Javier Parodi</title>
    </head>
    <body>
        <h1>Nombre y apellidos - Resultado</h1>
        
        <?php
            echo "<p><strong>Nombre: </strong>".$_GET["nombre"]."</p>";
            echo "<p><strong>Apellidos: </strong>".$_GET["apellidos"]."</p>";
        ?>

</body>
</html>

<?php
    } else {
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1 Formularios - Javier Parodi</title>
</head>
<body>
    <h1>Nombre y apellidos - Formulario</h1>
    <form method="get" action="formulario1.php">
        <p><label for="nombre">Nombre: </label>
        <textarea id="nombre" name="nombre" placeholder="Nombre"><?php if(isset($_GET["nombre"])) echo $_GET["nombre"];?></textarea></p>
        

        <p><label for="apellidos">Apellidos: </label>
        <textarea id="apellidos" name="apellidos" placeholder="Apellidos"><?php if(isset($_GET["apellidos"])) echo $_GET["apellidos"];?></textarea></p>

        <?php if (isset($_GET["boton_submit"]) && $error_formulario) echo "<p>Faltan valores</p>"; ?>

        <p><button type="submit" name="boton_submit">Enviar</button></p>
    </form>

</body>
</html>

<?php
    }
?>

