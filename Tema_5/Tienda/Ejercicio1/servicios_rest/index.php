<?php
require "src/bd_config.php";
require "src/functions.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


//LOGIN

$app->post("/login", function ($request) {


    $datos[] = $request->getParam('usuario');
    $datos[] = $request->getParam('clave');
    echo json_encode(login($datos));
});


//LOGEADO

$app->post("/login", function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"])) {

        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
        echo json_encode(login($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "Usted no tiene permisos para usar este servicio"));
    }
});


//SALIR

$app->post("/salir", function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    echo json_encode(array("logout" => "Fin de la sesión API"));
});


//INFO DE TODOS LOS PRODUCTOS

$app->get("/productos", function ($request) {


    //session_id($request->getParam("api_session"));
    //session_start();
   // if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_productos());
    //} else {
    //    session_destroy();
    //    echo json_encode(array("no_login" => "Usted no tiene permisos para usar este servicio"));
    //}
});


//INFO DE UN PRODUCTO

$app->get("/producto/{cod}", function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_producto($request->getAttribute("cod")));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "Usted no tiene permisos para usar este servicio"));
    }
});

//INSERTAR

$app->post("/producto/insertar", function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam("cod");
        $datos[] = $request->getParam("nombre");
        $datos[] = $request->getParam("nombre_corto");
        $datos[] = $request->getParam("descripcion");
        $datos[] = $request->getParam("PVP");
        $datos[] = $request->getParam("familia");

        echo json_encode(insertar_producto($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "Usted no tiene permisos para usar este servicio"));
    }
});


//EDITAR PRODUCTO

$app->put("/producto/actualizar/{cod}", function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam("nombre");
        $datos[] = $request->getParam("nombre_corto");
        $datos[] = $request->getParam("descripcion");
        $datos[] = $request->getParam("PVP");
        $datos[] = $request->getParam("familia");
        $datos[] = $request->getAttribute("cod");

        echo json_encode(editar_producto($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "Usted no tiene permisos para usar este servicio"));
    }
});


//BORRAR PRODUCTO

$app->delete("/producto/borrar/{cod}", function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(borrar_producto($request->getAttribute("cod")));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "Usted no tiene permisos para usar este servicio"));
    }
});


//GET QUE DE TODOS LAS FAMILIAS
$app->get("/familias", function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_familias());
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "Usted no tiene permisos para usar este servicio"));
    }
});

//GET QUE DE UNA FAMILIAS
$app->get("/familia/{cod}", function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_familia($request->getAttribute("cod")));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "Usted no tiene permisos para usar este servicio"));
    }
});


//REPETIDO INSERTAR

$app->get("/repet_insert/{tabla}/{columna}/{valor}", function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $tabla = $request->getAttribute("tabla");
        $columna = $request->getAttribute("columna");
        $valor = $request->getAttribute("valor");

        echo json_encode(repetido($tabla, $columna, $valor));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "Usted no tiene permisos para usar este servicio"));
    }
});

//REPETIDO EDITAR

$app->get("/repet_edit/{tabla}/{columna}/{valor}/{columna_clave}/{valor_clave}", function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $tabla = $request->getAttribute("tabla");
        $columna = $request->getAttribute("columna");
        $valor = $request->getAttribute("valor");
        $columna_clave = $request->getAttribute("columna_clave");
        $valor_clave = $request->getAttribute("valor_clave");

        echo json_encode(repetido($tabla, $columna, $valor, $columna_clave, $valor_clave));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "Usted no tiene permisos para usar este servicio"));
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();
