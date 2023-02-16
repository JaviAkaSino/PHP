<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;



$app->get('/conexion_PDO', function ($request) {

    echo json_encode(conexion_pdo(), JSON_FORCE_OBJECT);
});

$app->get('/conexion_MYSQLI', function ($request) {

    echo json_encode(conexion_mysqli(), JSON_FORCE_OBJECT);
});

// LOGIN

$app->post("/login", function ($request) {

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login($datos));
});

//LOGEADO

$app->post("/logueado", function ($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["tipo"])){

        $datos[]=$_SESSION["usuario"];
        $datos[]=$_SESSION["clave"];
        echo json_encode(login($datos, false));
    } else {

        session_destroy();
        echo json_encode(array("no_login"=>"No está logeado"));
    }
});


//OBTENER HORARIO USUARIO

$app->get("/horario/{id_usuario}", function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["tipo"])){
        echo json_encode(horario($request->getAttribute("id_usuario")));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No está logueado"));
    }
    
});

//USUARIOS NO ADMIN

$app->get("/usuarios", function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin"){
        echo json_encode(usuarios());
    } else{

        session_destroy();
        echo json_encode(array("no_login"=>"No está logueado"));
    }
    
});

//TIENE GRUPO

$app->get("/tieneGrupo/{dia}/{hora}/{id_usuario}", function ($request) {

    $datos[] = $request->getAttribute("id_usuario");
    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getParam("grupo");

    echo json_encode(tieneGrupo($datos));
});

//QUE GRUPOS TIENE

$app->get("/grupos/{dia}/{hora}/{id_usuario}", function ($request) {

    $datos[] = $request->getAttribute("id_usuario");
    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    
    echo json_encode(grupos($datos));
});

//GRUPOS QUE NO

$app->get("/gruposLibres/{dia}/{hora}/{id_usuario}", function ($request) {

    $datos[] = $request->getAttribute("id_usuario");
    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    
    echo json_encode(gruposLibres($datos));
});


//BORRAR GRUPO

$app->delete("/borrarGrupo/{dia}/{hora}/{id_usuario}/{id_grupo}", function($request){

    $datos[] = $request->getAttribute("id_usuario");
    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_grupo");

    echo json_encode(borrarGrupo($datos));
});

//AÑADIR GRUPO

$app->post("/insertarGrupo/{dia}/{hora}/{id_usuario}/{id_grupo}", function($request){

    $datos[] = $request->getAttribute("id_usuario");
    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_grupo");

    echo json_encode(insertarGrupo($datos));
});



// Una vez creado servicios los pongo a disposición
$app->run();
