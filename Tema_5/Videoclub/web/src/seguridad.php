<?php

        //Los datos usuario y clave ya estan en la sesión de la API

        //Hay que enviarle la $key, que es $_SESSION["api_session"] (ya es un array)

        $url = DIR_SERV . "/logueado";
        $respuesta = consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
        $obj = json_decode($respuesta);
        if (!$obj) {
            
            $url_salir = DIR_SERV . "/salir"; //Cerramos api sesion, si no, da igual
            consumir_servicios_rest($url_salir, "POST", $_SESSION["api_session"]);
            session_destroy(); //Destruimos la normal también
            die(pag_error("Error al consumir servicios REST: " . $url . "<br/>" . $respuesta));
        }

        if (isset($obj->error)) {
            $url_salir = DIR_SERV . "/salir"; //Cerramos api sesion, si no, da igual
            consumir_servicios_rest($url_salir, "POST", $_SESSION["api_session"]);
            session_destroy(); //Destruimos la normal también
            die(pag_error($obj->error));
        }

        if (isset($obj->no_login)){
            //Aquí no hay que salir, hacemos el unset
            session_unset();
            //Seguridad y salto, NO DIE, tiene que salir el login
            $_SESSION["seguridad"] = "Tiempo de sesión de la API excedido";
            header("Location:index.php");
            exit;
            
        }

        if (isset($obj->mensaje)) { //User/passw incorrectas es que ya no está

            $url_salir = DIR_SERV . "/salir"; //Cerramos api sesion
            consumir_servicios_rest($url_salir, "POST", $_SESSION["api_session"]);

            session_unset();
            //Seguridad y salto, NO DIE, tiene que salir el login
            $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;

        } else { //Si está todo OK

            $datos_usuario_log = $obj->usuario;

        }
    
        //CONTROLAMOS EL TIEMPO

        if (time() - $_SESSION["ultimo_acceso"] > 60 * MINUTOS){ //Se ha excedido el tiempo

            $_SESSION["seguridad"] = "Tiempo de sesión excedido";
            //Cerramos sesion API
            $url = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
            //Unset de la sesión normal
            session_unset();
            //Mandamos al login
            header("Location:index.php");
            exit;

        }

        //TODO OK, renovamos tiempo
        $_SESSION["ultimo_acceso"] = time(); //Actualiza tiempo de sesión

?>