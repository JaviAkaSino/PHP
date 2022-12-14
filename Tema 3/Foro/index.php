<?php
require "src/bd_config.php";
require "src/funciones.php";
define("MINUTOS", 10);

session_name("primer_login_22_33");
session_start();
//Estas 3 variables existen cuando me he logeado, si no, no cumples ninguna
if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && (isset($_SESSION["ultimo_acceso"]))) {

    require "src/seguridad.php";

    $_SESSION["ultimo_acceso"] = time();

    if ($datos_usuario_log["tipo"] == "normal")
        require "vistas/vista_normal.php";
    else
        require "vistas/vista_admin.php";

    mysqli_close($conexion);
} elseif (isset($_POST["btnRegistro"]) || isset($_POST["boton_continuar_registrar"])) {

    require "vistas/vista_registro.php";
} else {

    require "vistas/vista_login.php";
}
