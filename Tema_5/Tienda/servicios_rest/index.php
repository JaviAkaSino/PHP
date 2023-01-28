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

//INSERTAR

$app->post("/producto/insertar",function($request){

    $datos[]=$request->getParam("cod");
    $datos[]=$request->getParam("nombre");
    $datos[]=$request->getParam("nombre_corto");
    $datos[]=$request->getParam("descripcion");
    $datos[]=$request->getParam("PVP");
    $datos[]=$request->getParam("familia");

    echo json_encode(insertar_producto($datos));
});


//EDITAR PRODUCTO

$app->put("/producto/actualizar/{cod}",function($request){

    $datos[]=$request->getParam("nombre");
    $datos[]=$request->getParam("nombre_corto");
    $datos[]=$request->getParam("descripcion");
    $datos[]=$request->getParam("PVP");
    $datos[]=$request->getParam("familia");
    $datos[]=$request->getAttribute("cod");

    echo json_encode(editar_producto($datos));

});


//BORRAR PRODUCTO

$app->delete("/producto/borrar/{cod}", function($request){

    echo json_encode(borrar_producto($request->getAttribute("cod")));
});


//GET QUE DE TODOS LAS FAMILIAS
$app->get("/familias", function(){

echo json_encode(obtener_familias());

});

//GET QUE DE UNA FAMILIAS
$app->get("/familia/{cod}", function($request){

    echo json_encode(obtener_familia($request->getAttribute("cod")));
    
    });


//REPETIDO INSERTAR

$app->get("/repet_insert/{tabla}/{columna}/{valor}", function($request){

    $tabla=$request->getAttribute("tabla");
    $columna=$request->getAttribute("columna");
    $valor=$request->getAttribute("valor");

    echo json_encode(repetido($tabla, $columna, $valor));

    });

//REPETIDO EDITAR

$app->get("/repet_edit/{tabla}/{columna}/{valor}/{columna_clave}/{valor_clave}", function($request){

    $tabla=$request->getAttribute("tabla");
    $columna=$request->getAttribute("columna");
    $valor=$request->getAttribute("valor");
    $columna_clave=$request->getAttribute("columna_clave");
    $valor_clave=$request->getAttribute("valor_clave");

    echo json_encode(repetido($tabla, $columna, $valor, $columna_clave, $valor_clave));

    });

// Una vez creado servicios los pongo a disposición
$app->run();
