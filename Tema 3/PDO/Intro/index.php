<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría PDO</title>
</head>

<body>
    <h1>Teoría PDO</h1>
    <?php

    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_foro2");

    //CONEXION

 /*   
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>Imposible conectar. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p></body></html>");
    }
*/

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die("<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>");
    }

    echo "<p>Conectado con éxito</p>";


    //CONSULTA LOGIN


    $usuario = "javiakasino";
    $clave = md5("miau1");

/*    
    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario='" . $usuario . "' AND clave ='" . $clave . "'";
        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado)>0){
            $tupla = mysqli_fetch_assoc($resultado);
            echo "<p>Bienvenid@, ".$tupla["nombre"]."</p>";
        }
        
        mysqli_free_result($resultado);

    } catch (Exception $e) {
        $mensaje_error = "<p>Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p></body></html>";
        mysqli_close($conexion);
        die($mensaje_error);
    }


*/
/*
    try {

        $consulta = "SELECT * FROM usuarios WHERE usuario=? and clave =?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);

        if ($sentencia->rowCount() > 0) {
            //Otras: PDO::FETCH_NUM y PDO::FETCH_OBJ
            $tupla = $sentencia->fetch(PDO::FETCH_ASSOC);
            echo "<p>Bienvenid@, " . $tupla["nombre"] . "</p>";
        }

        $sentencia = null; //Libera sentencia
        $conexion = null; //Cierra conexión


    } catch (PDOException $e) {

        $sentencia = null; //Libera sentencia
        $conexion = null; //Cierra conexión
        die("<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>");
    }
*/


//CONSULTA VARIOS

/*
try {
    $consulta = "SELECT * FROM usuarios";
    $resultado = mysqli_query($conexion, $consulta);

    echo "<h3>Usuarios: </h3><ul>";

    while ($tupla = mysqli_fetch_assoc($resultado)){
         echo "<li>".$tupla["usuario"]."</li>";
    }
    echo "</ul>";

    mysqli_free_result($resultado);

} catch (Exception $e) {
    $mensaje_error = "<p>Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p></body></html>";
    mysqli_close($conexion);
    die($mensaje_error);
}
*/

/*
try {

    $consulta = "SELECT * FROM usuarios";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();

    echo "<h3>Usuarios: </h3><ul>";

    $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($respuesta as $tupla){

        echo "<li>".$tupla["usuario"]."</li>";
    }

    echo "</ul>";

    $sentencia = null; //Libera sentencia
    $conexion = null; //Cierra conexión


} catch (PDOException $e) {

    $sentencia = null; //Libera sentencia
    $conexion = null; //Cierra conexión
    die("<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>");
}

*/

//INSERT 


$nombre = "PepitoPDO";
$usuario = "pepPDO";
$clave = "miau";
$email = "pepito@miau.es";

/*
try {
    $consulta = "INSERT  INTO usuarios (nombre, usuario, clave, email) VALUES ('".$nombre."','".$usuario."','".$clave."','".$email."')";
    mysqli_query($conexion, $consulta);

    echo "<p>Usuario ".mysqli_insert_id($conexion)." insertado con éxito</p>";


} catch (Exception $e) {
    $mensaje_error = "<p>Imposible realizar la inserción. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p></body></html>";
    mysqli_close($conexion);
    die($mensaje_error);
}
*/


/*
try {

    $consulta = "INSERT  INTO usuarios (nombre, usuario, clave, email) VALUES (?,?,?,?)";
    $sentencia = $conexion->prepare($consulta);

    $sentencia->execute([$nombre, $usuario, $clave, $email]);
    
    echo "<p>Usuario ".$conexion->lastInsertId()." insertado con éxito</p>";

    $sentencia = null; //Libera sentencia
    $conexion = null; //Cierra conexión


} catch (PDOException $e) {

    $sentencia = null; //Libera sentencia
    $conexion = null; //Cierra conexión
    die("<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>");
}

*/


    ?>

</body>

</html>