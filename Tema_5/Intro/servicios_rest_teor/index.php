<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->get('/saludo',function(){

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(array("mensaje"=> "Hola en general") ,JSON_FORCE_OBJECT);

});

$app->get('/saludo/{codigo}',function($request){

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(array("mensaje"=> "Hola ".$request->getAttribute('codigo')) ,JSON_FORCE_OBJECT);
    //getAttribute cuando se mandan por url
});

//POST
$app->get('/saludo',function($request){
    //getParam cuando se envían por abajo
    $nombre1=$request->getParam("datos1");
    $nombre2=$request->getParam("datos2");
    echo json_encode(array("mensaje"=> "Hola ".$nombre1." y ".$nombre2) ,JSON_FORCE_OBJECT);

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>