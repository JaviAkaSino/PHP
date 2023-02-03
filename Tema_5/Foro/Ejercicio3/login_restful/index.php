<?php
require "src/bd_config.php";
require "src/functions.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

//INFO DE TODOS LOS PRODUCTOS

$app->get("/usuarios", function(){

    echo json_encode(obtener_usuarios());

});




























// Una vez creado servicios los pongo a disposición
$app->run();
