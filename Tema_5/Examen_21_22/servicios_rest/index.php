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


//OBTENER HORARIO USUARIO

$app->get("/horario/{id_usuario}", function ($request) {

    echo json_encode(horario($request->getAttribute("id_usuario")));
});

//USUARIOS NO ADMIN

$app->get("/usuarios", function () {

    echo json_encode(usuarios());
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


// Una vez creado servicios los pongo a disposición
$app->run();
