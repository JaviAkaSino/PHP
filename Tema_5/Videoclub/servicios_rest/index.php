<?php
require "src/functions.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

$app->get('/conexion_PDO', function ($request) {

    echo json_encode(conexion_pdo(), JSON_FORCE_OBJECT);
});


//LOGIN
$app->post('/login', function ($request) {

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    echo json_encode(login($datos));
});

//LOGUEADO

$app->post('/logueado', function ($request) {

    session_id($request->getParam("api_session")); //Coge la sesion
    session_start(); //La inicia

    if (isset($_SESSION["tipo"])) { //Pregunta si existe el tipo (está logueado)

        //Guarda los datos
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];

        //Manda el servicio
        echo json_encode(login($datos, false));
    } else { //NO hay login

        session_destroy(); //Destruye para cerrar
        echo json_encode(array("no_login" => "No logueado")); //Manda no_login

    }
});

//SALIR

$app->post('/salir', function ($request) {

    session_id($request->getParam("api_session")); //Coge la sesion de la api
    session_start(); //La inicia
    session_destroy(); //Para destruirla
    echo json_encode(array("no_login" => "No logueado"));
});

//LISTAR CLIENTES

$app->get('/clientes', function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {

        echo json_encode(clientes());
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});

//DATOS DE UN CLIENTE

$app->get('/info/{id_cliente}', function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"])) {

        $id = $request->getAttribute("id_cliente");
        echo json_encode(info_cliente($id));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});


//AÑADIR CLIENTE
$app->post("/nuevo", function ($request) {
    session_id($request->getParam("api_session"));
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {

        $datos[] = $request->getParam("user");
        $datos[] = $request->getParam("clave");
        $datos[] = $request->getParam("foto");

        echo json_encode(nuevo_cliente($datos));
    } else {

        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});


//EDITAR CLIENTE


//BORRAR CLIENTE

//REPETIDO INSERT
$app->post("/repetido_insert/{tabla}/{columna}/{valor}", function ($request) {
    session_id($request->getParam("api_session"));
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {

        echo json_encode(repetido($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor")));
    } else {

        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});

//REPETIDO EDITAR

// Una vez creado servicios los pongo a disposición
$app->run();
