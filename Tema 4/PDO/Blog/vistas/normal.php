    <?php

    require "cabecera.php";

    echo "<p>
            Bienvenido <strong>" . $datos_usuario_log["usuario"] . "</strong> - 
            <form action='index.php' method='post'>
                <button type='submit' name='boton_salir' class='enlace admin'>Salir</button>
            </form>
           
        </p>";



    try {

        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        $mensaje_error = "<p>Imposible realizar la conexión. Error: " . $e->getMessage() . "</p></body></html>";
        die($mensaje_error);
    }


    //COMENTARIO

    if (isset($_POST["boton_enviar"])) {

        try {
            $consulta = "INSERT INTO comentarios (comentario, idUsuario, idNoticia)
                            VALUES (?,?,?)";

            $sentencia = $conexion->prepare($consulta);
            $datos[] = $_POST["comentario"];
            $datos[] = $_POST["id_user"];
            $datos[] = $_POST["boton_enviar"];

            $sentencia->execute($datos);

            unset($datos);
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            die(pag_error("Blog Personal", "Blog Personal", "Imposible cargar las noticias. Error: " . $e->getMessage()));
        }
    }

    //NOTICIAS

    try {

        if (isset($_POST["boton_ver"]) || isset($_POST["boton_enviar"])) { //Si se ha pulsado alguna noticia

            $consulta = "SELECT * FROM noticias
    JOIN usuarios ON noticias.idUsuario = usuarios.idUsuario
    JOIN categorias ON noticias.idCategoria = categorias.idCategoria
    WHERE noticias.idNoticia = ?";

            if (isset($_POST["boton_ver"]))
                $noticia = $_POST["boton_ver"];
            else
                $noticia = $_POST["boton_enviar"];




            $sentencia = $conexion->prepare($consulta); //Prepara la consulta

            $datos[] = $noticia;
            $sentencia->execute($datos); //La ejecuta

            if ($sentencia->rowCount() > 0) { //Controla que siga existiendo
                $tupla = $sentencia->fetch(PDO::FETCH_ASSOC);
                echo "<h3>" . $tupla["titulo"] . "</h3>";
                echo "<p>Publicado por <strong>" . $tupla["usuario"] . "</strong> en <em>" . strtoupper($tupla["valor"]) . "</em></p>";
                echo "<p>" . $tupla["cuerpo"] . "</p>";

                $sentencia = null; //Libera la consulta ????????
                $tupla = null;

                echo "<h3>Comentarios</h3>";

                try {
                    $consulta = "SELECT * FROM comentarios
            JOIN usuarios ON comentarios.idUsuario=usuarios.idUsuario
            WHERE idNoticia = ? AND estado = ?";

                    $sentencia = $conexion->prepare($consulta); //Prepara la consulta
                    $datos[] = "apto"; //El idNoticia ya está en datos
                    $sentencia->execute($datos); //Ejecuta

                    if ($sentencia->rowCount() > 0) { //Si hay comentarios

                        $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($respuesta as $tupla) {

                            echo "<p><strong>" . $tupla["usuario"] . "</strong> dijo:<br/>" . $tupla["comentario"] . "</p>";
                        }

                        $sentencia = null;
                        $respuesta = null;
                    } else { //Si no hay comentarios

                        echo "<p>No hay comentarios para esta noticia. ¡Sé tu el primero!</p>";
                    }
                } catch (PDOException $e) {
                    $conexion = null;
                    $sentencia = null;
                    echo "<p>No han podido cargarse los comentarios Error: " . $e->getMessage() . "</p>";
                }
            } else {
                echo "<p>La noticia ya no está en la BD</p>";
            }


            echo "<form action='index.php' method='post'>
                    <label for='comentario'>Dejar un comentario</label><br/>
                    <textarea id='comentario' name='comentario'></textarea>
                    <p>
                        <button type='submit'>Volver</button>
                        <button type='submit' name='boton_enviar' value='" . $noticia . "'>Enviar</button>
                        <input type='hidden' name='id_user' value='" . $datos_usuario_log["idUsuario"] . "'/>
                    </p>
                </form>";
        } else { //Si no se ha pulsado ninguna, lista las noticias

            try {
                $consulta = "SELECT idNoticia, titulo, copete FROM noticias";
                $sentencia = $conexion->prepare($consulta); //Prepara la consulta
                $sentencia->execute(); //La ejecuta

                if ($sentencia->rowCount() > 0) { //Si hay noticias

                    echo "<h2>Noticias</h2>";

                    $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($respuesta as $tupla) {

                        echo "<form action='index.php' method='post'>
                            <button type='submit' class='enlace' name='boton_ver' value='" . $tupla["idNoticia"] . "'>" . $tupla["titulo"] . "</button>
                        </form>";
                        echo "<p>" . $tupla["copete"] . "</p>";
                    }
                }
            } catch (PDOException $e) {
                $conexion = null;
                $sentencia = null;
                die(pag_error("Blog Personal", "Blog Personal", "Imposible cargar las noticias. Error: " . $e->getMessage()));
            }
        }
    } catch (PDOException $e) {
        $mensaje_error = "<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>";
        die($mensaje_error);
    }
