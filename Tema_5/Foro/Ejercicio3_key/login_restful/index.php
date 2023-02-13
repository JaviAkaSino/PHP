<?php
require "src/bd_config.php";
require "src/functions.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

//LOGIN - NO HAY QUE PROTEGERLO

$app->post("/login", function ($request) {

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login($datos));
});

//LOGEADO 

$app->post("/logueado", function ($request) {

    //Proteger servicio
    session_id($request->getParam("api_session")); //Recoge la id de la sesión
    session_start();
    if (isset($_SESSION["tipo"])) {

        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];

        echo json_encode(login($datos, false));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});


//SALIR 

$app->post("/salir", function ($request) {

    //Proteger servicio
    session_id($request->getParam("api_session")); //Recoge la id de la sesión
    session_start(); //La abre
    session_destroy(); //Para destruirla
    echo json_encode(array("no_login" => "No logueado"));
});


//INFO DE TODOS LOS USUARIOS

$app->get("/usuarios", function ($request) {

    //Proteger servicio
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_usuarios()); //Servicio
    } else { //Si no, es que ha entrado por url

        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});


//INFO DE UN USUARIO

$app->get("/usuario/{idUsuario}", function ($request){

    //Proteger el servicio
    session_id($request->getParam("api_session")); //Recoge la id de la sesion
    session_start();
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] = "admin"){

        echo json_encode(datos_usuario($request->getAttribute("idUsuario")));

    } else {
        session_destroy();
        echo json_encode(array("no_login" => "usted no tiene permisos para usar este servicio"));
    }
});

//NUEVO USUARIO

$app->post("/crearUsuario", function ($request) {

    //Proteger servicio
    session_id($request->getParam("api_session")); //Recoge la id de la sesión
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") { //Si es admin

        $datos[] = $request->getParam("nombre");
        $datos[] = $request->getParam("usuario");
        $datos[] = $request->getParam("clave");
        $datos[] = $request->getParam("email");

        echo json_encode(nuevo_usuario($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});


//EDITAR USUARIO

$app->put("/actualizarUsuario/{idUsuario}", function ($request) {

    //Proteger servicio
    session_id($request->getParam("api_session")); //Recoge la id de la sesión
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") { //Si es admin


        $datos[] = $request->getParam("nombre");
        $datos[] = $request->getParam("usuario");
        $datos[] = $request->getParam("clave");
        $datos[] = $request->getParam("email");
        $datos[] = $request->getAttribute("idUsuario");

        echo json_encode(editar_usuario($datos));
    } else {

        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});

//ELIMINAR USUARIO

$app->delete("/borrarUsuario/{idUsuario}", function ($request) {

    //Proteger servicio
    session_id($request->getParam("api_session")); //Recoge la id de la sesión
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") { //Si es admin

        echo json_encode(borrar_usuario($request->getAttribute("idUsuario")));
    } else {

        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});


//REPETIDO INSERT

$app->get("/repetido_insert/{tabla}/{columna}/{valor}" , function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin")  
    {
        echo json_encode(repetido($request->getAttribute('tabla'),$request->getAttribute('columna'),$request->getAttribute('valor')));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_login"=>"No logueado"));
    }

});


//REPETIDO UPDATE

$app->get('/repetido_edit/{tabla}/{columna}/{valor}/{columna_clave}/{valor_clave}',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin")  
    {
        echo json_encode(repetido($request->getAttribute('tabla'),$request->getAttribute('columna'),$request->getAttribute('valor'),$request->getAttribute('columna_clave'),$request->getAttribute('valor_clave')));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_login"=>"No logueado"));
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();
