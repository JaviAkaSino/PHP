<?php
require "src/bd_config.php";
require "src/funciones.php";


if (isset($_POST["usuario_nuevo"]))
    $mensaje_accion = "Usuario registrado con éxito";

//*************************************** CONFIRMAR EDITAR ********************************* */

if (isset($_POST["boton_confirma_editar"])) { //Al pulsar botón, revisamos errores normales

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $error_form = $error_nombre || $error_usuario || $error_email;

    if (!$error_usuario || !$error_email) { //Si ya están rellenos, mirar si están repetidos

        try { //Try catch de la conexión

            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {

            die(pag_error("Prácitca 1º CRUD", "Nuevo Usuario", "Imposible conectar. Error Nº " .
                mysqli_connect_errno() . ": " . mysqli_connect_error()));
        }

        if (!$error_usuario) { //SI USUARIO YA ESTÁ RELLENO

            $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"], "id_uduario", $_POST["boton_confirma_editar"]); //Error si repetido

            if (is_string($error_usuario)) { //Si se obtiene un mensaje de error, se enseña

                mysqli_close($conexion);
                die(pag_error("Prácitca 1º CRUD", "Nuevo Usuario", $error_usuario));
            }
        }

        if (!$error_email) { // IGUAL PARA EMAIL

            $error_email = repetido($conexion, "usuarios", "email", $_POST["email"], "id_usuario", $_POST["boton_confirma_editar"]);

            if (is_string($error_email)) {

                mysqli_close($conexion);
                die(pag_error("Prácitca 1º CRUD", "Nuevo Usuario", $error_email));
            }
        }


        $error_form = $error_nombre || $error_usuario || $error_email;

        if (!$error_form) {

            if ($_POST["clave"] == "") //Si no se ha metido clave nueva
                $consulta = "UPDATE usuarios SET nombre='" . $_POST["nombre"] . "', usuario = '" . $_POST["usuario"] . "', email = '" . $_POST["email"] . "' WHERE id_usuario = '" . $_POST["boton_confirma_editar"] . "'";
            else
                $consulta = "UPDATE usuarios SET nombre='" . $_POST["nombre"] . "', usuario = '" . $_POST["usuario"] . "', clave ='" . md5($_POST["clave"]) . "',email = '" . $_POST["email"] . "' WHERE id_usuario = '" . $_POST["boton_confirma_editar"] . "'";

            try {

                mysqli_query($conexion, $consulta);
                $mensaje_accion = "Usuario editado con éxito";
            } catch (Exception $e) {

                $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                mysqli_close($conexion);
                die(pag_error("Prácitca 1º CRUD", "Nuevo Usuario", $mensaje));
            }
        }
    }
}



//*************************************** CONFIRMAR BORRAR ********************************* */

if (isset($_POST["boton_confirma_borrar"])) {

    try {

        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        die(pag_error("Prácitca 1º CRUD", "Nuevo Usuario", "Imposible conectar. Error Nº " .
            mysqli_connect_errno() . ": " . mysqli_connect_error()));
    }

    $consulta = "DELETE FROM usuarios WHERE id_usuario='" . $_POST["boton_confirma_borrar"] . "'";

    try {

        $resultado = mysqli_query($conexion, $consulta);
        $mensaje_accion = "Usuario borrado con éxito";
        //No cerramos conexión para seguir con la web

    } catch (Exception $e) {

        $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die(pag_error("Prácitca 1º CRUD", "Nuevo Usuario", $consulta . $mensaje));
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Foro</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;

        }

        .texto-centrado {
            text-align: center;
        }

        .centrar {
            margin: 1em auto;
            width: 80%;
        }

        table img {
            width: 50px;
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
        }

        .boton-accion {

            border: none;
            background: none;
        }
    </style>
</head>

<body>
    <h1 class="texto-centrado">Listado de usuarios</h1>
    <?php
    if (!isset($conexion)) { //Si ya se ha borrado ya está creada la conexión

        try {

            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {

            die("<p>Imposible conectar. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");
        }
    }





    try {

        require "vistas/tabla_principal.php";

        //***************** MENSAJE DE ACCIÓN *****************

        if (isset($mensaje_accion))
            echo "<p class='centrar'>" . $mensaje_accion . "</p>";



        //***************** BOTÓN LISTAR *****************

        if (isset($_POST["boton_listar"])) {

            require "vistas/listar.php";



            //***************** BORRAR USUARIO *****************

        } elseif (isset($_POST["boton_borrar"])) {

            require "vistas/borrar.php";


            //***************** EDITAR USUARIO *****************


        } elseif (
            isset($_POST["boton_editar"]) || //Muestra el formulario cuando se pulse editar
            (isset($_POST["boton_confirma_editar"]) && $error_form) //Ó si hay errores en editar
        ) {

            require "vistas/editar.php";
            
        } else {

            require "vistas/boton_nuevo.php";
        }


        mysqli_close($conexion);
    } catch (Exception $e) {

        $mensaje = "Imposible conectar; Error nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion); //Cierra conexión
        die($mensaje);
    }

    ?>



</body>

</html>