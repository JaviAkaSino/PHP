<?php
require "src/bd_config.php";
require "src/functions.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

//INFO DE TODOS LOS USUARIOS

$app->get("/usuarios", function(){

    echo json_encode(obtener_usuarios());

});


//NUEVO USUARIO

$app->post("/crearUsuario", function($request){

    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    $datos[] = $request->getParam("email");

    echo json_encode(nuevo_usuario($datos));
});

























// Una vez creado servicios los pongo a disposición
$app->run();
