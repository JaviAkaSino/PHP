    <?php

    require "cabecera.php";

    echo "<p>
            Bienvenido <strong>" . $datos_usuario_log["usuario"] . "</strong> - 
            <form action='index.php' method='post'>
                ";

    if (isset($_POST["boton_comentarios"])) {
        echo "<button type='submit' name='boton_volver'>Volver</button>";
    }

    echo "<button type='submit' name='boton_salir'>Salir</button>
        <ul><li>
            <button type='submit' name='boton_comentarios'>Administrar Comentarios</button>
        </li></ul>";

    echo "</form>  
        </p>";



    try {

        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        $mensaje_error = "<p>Imposible realizar la conexión. Error: " . $e->getMessage() . "</p></body></html>";
        die($mensaje_error);
    }


    if (isset($_POST["boton_aprobar_comentario"])) {

        try {
            $consulta = "UPDATE comentarios SET estado = 'apto'
                            WHERE idComentario = ?";

            $sentencia = $conexion->prepare($consulta);
            $datos_ac[] = $_POST["boton_aprobar_comentario"];

            $sentencia->execute($datos_ac);

            unset($datos_ac);
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            die(pag_error("Blog Personal", "Blog Personal", "Imposible realizar consulta. Error: " . $e->getMessage()));
        }
    }

    if (isset($_POST["boton_editar_comentario"])) {
        try {
            $consulta = "";

            $sentencia = $conexion->prepare($consulta);
            $datos_ec[] = $_POST["boton_editar_comentario"];

            $sentencia->execute($datos_ec);

            unset($datos_ec);
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            die(pag_error("Blog Personal", "Blog Personal", "Imposible realizar consulta. Error: " . $e->getMessage()));
        }
    }

    if (isset($_POST["boton_borrar_comentario"])) {

        try {
            $consulta = "DELETE FROM comentarios
                            WHERE idComentario = ?";

            $sentencia = $conexion->prepare($consulta);
            $datos_bc[] = $_POST["boton_borrar_comentario"];

            $sentencia->execute($datos_bc);

            unset($datos_bc);
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            die(pag_error("Blog Personal", "Blog Personal", "Imposible realizar consulta. Error: " . $e->getMessage()));
        }
    }


    //COMENTARIO

    if (isset($_POST["boton_enviar"])) {

        $error_comentario = $_POST["comentario"] == "";

        if (!$error_comentario) {

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
    }

    //NOTICIAS



    if (isset($_POST["boton_ver"]) || isset($_POST["boton_enviar"])) { //Si se ha pulsado alguna noticia
        try {
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
                    <textarea id='comentario' name='comentario'></textarea>";

            if (isset($_POST["boton_enviar"]) && $error_comentario) {

                echo "<span class='error'>*Campo vacío</span>";
            }

            echo "<p>
                        <button type='submit'>Volver</button>
                        <button type='submit' name='boton_enviar' value='" . $noticia . "'>Enviar</button>
                        <input type='hidden' name='id_user' value='" . $datos_usuario_log["idUsuario"] . "'/>
                    </p>
                </form>";
        } catch (PDOException $e) {
            $mensaje_error = "<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>";
            die($mensaje_error);
        }

        //Si no, si se pulsa el boton de admin comentarios
    } else if (isset($_POST["boton_comentarios"])) {

        echo "<h3>Listado de comentarios</h3>";

    ?>
        <form action='index.php' method='post'>
            <label for='tipo_comentario'>Tipos de comentarios</label>
            <select id='tipo_comentario' name='tipo_comentario' onChange='this.form.submit()'>

                <?php
                if (isset($_POST["tipo_comentario"]) && $_POST["tipo_comentario"] == 1) {

                    echo "<option value=0 >Todos</option>";
                    echo "<option value=1 selected>Sin aprobar</option>";
                    echo "</select>
                    <input type='hidden' name='boton_comentarios' />
                </form>";

                    $consulta = "SELECT * FROM comentarios 
                        JOIN usuarios ON comentarios.idUsuario = usuarios.idUsuario 
                        JOIN noticias ON comentarios.idNoticia = noticias.idNoticia 
                        WHERE estado = 'sin validar'
                        ORDER BY noticias.idNoticia";

                    echo "<h3>Comentarios sin aprobar</h3>";
                } else {

                    echo "<option value=0 selected>Todos</option>";
                    echo "<option value=1 >Sin aprobar</option>";
                    echo "</select>
                    <input type='hidden' name='boton_comentarios' />
                </form>";

                    $consulta = "SELECT * FROM comentarios 
                        JOIN usuarios ON comentarios.idUsuario = usuarios.idUsuario 
                        JOIN noticias ON comentarios.idNoticia = noticias.idNoticia 
                        ORDER BY noticias.idNoticia";

                    echo "<h3>Todos los comentarios</h3>";
                }
                ?>

            </select>
            <input type='hidden' name='boton_comentarios' />
        </form>

    <?php

        try {

            $sentencia =  $conexion->prepare($consulta);
            $sentencia->execute();

            if ($sentencia->rowCount() > 0) {

                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                echo "<table>";

                echo "<tr><th>Comentarios</th><th>Opción</th></tr>";

                foreach ($resultado as $tupla) {

                    echo "<tr>
                        <td>" . $tupla["comentario"] . "
                            <br/>
                            Dijo <strong>" . $tupla["usuario"] . "</strong> en
                            <form action='index.php' method='post'>
                                <button type='submit' name='boton_ver' value='" . $tupla["idNoticia"] . "'>" . $tupla["titulo"] . "</button>
                            </form>
                        </td>
                        <td>
                            <form action='index.php' method='post'>";

                    if ($tupla["estado"] == "sin validar") {
                        echo "<button type='submit' name='boton_aprobar_comentario' value='" . $tupla["idComentario"] . "'>Aprobar</button> - ";
                    }

                    echo    "<button type='submit' name='boton_editar_comentario' value='" . $tupla["idComentario"] . "'>Editar</button> - 
                        <button type='submit' name='boton_borrar_comentario' value='" . $tupla["idComentario"] . "'>Borrar</button>
                        <input type='hidden' name='boton_comentarios'/>   
                    </form>
                </td>
            </tr>";
                }

                echo "</table>";
            } else {

                echo "<p>No se han encontrado comentarios</p>";
            }
        } catch (PDOException $e) {
            $conexion = null;
            $sentencia = null;

            echo "<p>No han podido cargarse los comentarios Error: " . $e->getMessage() . "</>";
        }
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
                            <button type='submit' name='boton_ver' value='" . $tupla["idNoticia"] . "'>" . $tupla["titulo"] . "</button>
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
