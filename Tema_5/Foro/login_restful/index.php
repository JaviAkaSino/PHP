<?php
require "src/bd_config.php";
require "src/functions.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

//INFO DE TODOS LOS USUARIOS

$app->get("/usuarios", function () {

    echo json_encode(obtener_usuarios());
});


//NUEVO USUARIO

$app->post("/crearUsuario", function ($request) {

    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    $datos[] = $request->getParam("email");

    echo json_encode(nuevo_usuario($datos));
});


//LOGIN

$app->post("/login", function ($request) {

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login($datos));
});


//EDITAR USUARIO

$app->put("/actualizarUsuario/{idUsuario}", function ($request) {

    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    $datos[] = $request->getParam("email");
    $datos[] = $request->getAttribute("idUsuario");
    
    echo json_encode(nuevo_usuario($datos));
});

//ELIMINAR USUARIO
























// Una vez creado servicios los pongo a disposición
$app->run();
