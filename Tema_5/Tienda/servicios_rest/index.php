<?php
require "src/bd_config.php";
require "src/functions.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

//INFO DE TODOS LOS PRODUCTOS

$app->get("/productos", function(){

    echo json_encode(obtener_productos());

});


//INFO DE UN PRODUCTO

$app->get("/producto/{cod}", function($request){

    echo json_encode(obtener_producto($request->getAttribute("cod")));

});




$app->get('/saludo',function(){

    echo json_encode(array("mensaje"=> "Hola en general") ,JSON_FORCE_OBJECT);
});

$app->get('/saludo/{codigo}',function($request){
//getAttribute cuando se mandan por url
    echo json_encode(array("mensaje"=> "Hola ".$request->getAttribute('codigo')) ,JSON_FORCE_OBJECT);  
});

//POST
$app->post('/saludo',function($request){
    //getParam cuando se envían por abajo
    $nombre1=$request->getParam("datos1");
    $nombre2=$request->getParam("datos2");
    echo json_encode(array("mensaje"=> "Hola ".$nombre1." y ".$nombre2) ,JSON_FORCE_OBJECT);
});


//DELETE
$app->delete("/borrar_saludo/{id}",function($request){

    echo json_encode(array("mensaje"=>"El saludo con id: ".$request->getAttribute("id")." ha sido borrado", JSON_FORCE_OBJECT));

});


//PUT
$app->put("/modificar_saludo/{id}/{saludo_nuevo}",function($request){
        
    echo json_encode(array("mensaje"=>"El saludo con id: ".$request->getAttribute("id")." ha sido actualizado a ".$request->getAttribute("saludo_nuevo"), JSON_FORCE_OBJECT));


});

//PUT POR ABAJO
$app->put("/modificar_saludo/{id}",function($request){
        
    echo json_encode(array("mensaje"=>"El saludo con id: ".$request->getAttribute("id")." ha sido actualizado a ".$request->getParam("saludo_nuevo"), JSON_FORCE_OBJECT));


});


// Una vez creado servicios los pongo a disposición
$app->run();
