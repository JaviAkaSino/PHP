<?php
require "src/functions.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

$app->get('/conexion_PDO', function ($request) {

    echo json_encode(conexion_pdo(), JSON_FORCE_OBJECT);
});


//LOGIN
$app->post('/login', function ($request) {

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    echo json_encode(login($datos));
});

//LOGUEADO

$app->post('/logueado', function ($request) {

    session_id($request->getParam("api_session")); //Coge la sesion
    session_start(); //La inicia

    if (isset($_SESSION["tipo"])) { //Pregunta si existe el tipo (está logueado)

        //Guarda los datos
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];

        //Manda el servicio
        echo json_encode(login($datos, false));

    } else{ //NO hay login

        session_destroy(); //Destruye para cerrar
        echo json_encode(array("no_login"=>"No logueado")); //Manda no_login

    }
});

//SALIR

$app->post('/salir', function($request){

    session_id($request->getParam("api_session")); //Coge la sesion de la api
    session_start(); //La inicia
    session_destroy(); //Para destruirla
    echo json_encode(array("no_login"=>"Mo logueado"));

});

//LISTAR CLIENTES


//DATOS DE UN CLIENTE

//AÑADIR CLIENTE

//EDITAR CLIENTE

//ELIMINAR FOTO

//BORRAR CLIENTE

// Una vez creado servicios los pongo a disposición
$app->run();
