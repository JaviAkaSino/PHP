<h3 class='centrar'>Listado de los usuarios</h3>

<?php

//PAGINACIÓN
if (!isset($_SESSION["regs_x_pag"])) {
    $_SESSION["regs_x_pag"] = 1;
    $_SESSION["buscar"] = "";
}

if (isset($_POST["regs_x_pag"])) {
    $_SESSION["regs_x_pag"] = $_POST["regs_x_pag"];
    $_SESSION["buscar"] = $_POST["buscar"];
    $_SESSION["pagina"] = 1;
}

if (!isset($_SESSION["pagina"]))
    $_SESSION["pagina"] = 1;

if (isset($_POST["pagina"]))
    $_SESSION["pagina"] = $_POST["pagina"];

$inicio = ($_SESSION["pagina"] - 1) * $_SESSION["regs_x_pag"];

?>

<form class='centrar flexible' method='post' action='index.php'>
    <div>
        <label for="regs_x_pag">Registros a mostrar:</label>
        <select name="regs_x_pag" id="regs_x_pag" onchange="document.getElementById('boton_buscar').click();">
            <option value="2" <?php if ($_SESSION["regs_x_pag"] == 2) echo "selected" ?>>2</option>
            <option value="4" <?php if ($_SESSION["regs_x_pag"] == 4) echo "selected" ?>>4</option>
            <option value="-1" <?php if ($_SESSION["regs_x_pag"] == -1) echo "selected" ?>>ALL</option>
        </select>
    </div>
    <div>
        <input type="text" name="buscar" value="<?php echo $_SESSION["buscar"] ?>" />
        <button type="submit" id="boton_buscar">Buscar</button>
    </div>
</form>

<?php
if ($_SESSION["regs_x_pag"] == -1) { //Si es ALL, no limit

    $consulta = "SELECT nombre, id_usuario, foto 
                        FROM usuarios 
                        WHERE usuario LIKE '%" . $_SESSION["buscar"] . "%'";
} else {

    $consulta = "SELECT nombre, id_usuario, foto 
                        FROM usuarios 
                        WHERE usuario LIKE '%" . $_SESSION["buscar"] . "%'
                        LIMIT " . $inicio . "," . $_SESSION["regs_x_pag"];
}

try {
    $resultado = mysqli_query($conexion, $consulta);

    echo "<table class='centrar texto-centrado'>";
    echo "<tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>
                <form action='index.php' method='post'>
                    <button type='submit' name='boton_nuevo' class='enlace'>
                        Usuario +</button>
                </form>
            </th>
        </tr>";

    while ($tupla = mysqli_fetch_assoc($resultado)) {

        echo "<tr>";
        echo "<td>" . $tupla["id_usuario"] . "</td>";
        echo "<td><img src='Img/" . $tupla["foto"] . "' alt='Foto de perfil' title='Foto de perfil' /></td>";
        echo "<td>
                <form method='post' action='index.php'>
                    <button class='enlace' name='boton_listar' value='" . $tupla["id_usuario"] . "' type='submit'>" . $tupla["nombre"] . "</button>
                </form>
            </td>";
        echo "<td>
                <form method='post' action='index.php'>
                    <input type='hidden' name= 'nombre_foto' value='" . $tupla["foto"] . "'/>
                    <button name='boton_borrar' value='" . $tupla["id_usuario"] . "' class='enlace' type='submit'>Borrar</button>
                    -
                    <button name='boton_editar' value='" . $tupla["id_usuario"] . "' class='enlace' type='submit'>Editar</button>
                </form>
            </td>";
    }

    echo "</table>";
    mysqli_free_result($resultado);
} catch (Exception $e) {

    $mensaje = "<p>Imposible realizar la conexión. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p>";
    mysqli_close($conexion);
    die($mensaje);
}

//BOTONES DEL NÚMERO DE PÁGINA

if ($_SESSION["regs_x_pag"] != -1) { //Si se muestran ALL, no hay botones

    try { //Sacamos el total de registros
        $consulta = "SELECT * FROM usuarios WHERE nombre LIKE '%" . $_SESSION["buscar"] . "%'";
        $resultado = mysqli_query($conexion, $consulta);
        $numero_registros = mysqli_num_rows($resultado);

        $numero_paginas = ceil($numero_registros / $_SESSION["regs_x_pag"]); //Total de los registros entre los regs por pag

        if ($numero_paginas > 1) { //Si hay mas de una pagina ponemos botones

            echo "<form method='post' action='index.php' class='centrar'>";

            if ($_SESSION["pagina"] > 1) { //Si no estamos en la 1, aparecen flechas pabajo
                echo "<button type='submit' name='pagina' value='1'>|<</button>";
                echo "<button type='submit' name='pagina' value='" . ($_SESSION["pagina"] - 1) . "'><</button>";
            }

            for ($i = 1; $i <= $numero_paginas; $i++) {

                if ($i == $_SESSION["pagina"]) //Desactiva el boton de la página en la que está
                    echo "<button disabled type='submit' name='pagina' value = '" . $i . "'>" . $i . "</button>";
                else
                    echo "<button type='submit' name='pagina' value = '" . $i . "'>" . $i . "</button>";
            }

            if ($_SESSION["pagina"] < $numero_paginas) { //Si no estamos en la última, aparecen flechas hacia delante
                echo "<button type='submit' name='pagina' value='" . ($_SESSION["pagina"] + 1) . "'>></button>";
                echo "<button type='submit' name='pagina' value='" . $numero_paginas . "'>>|</button>";
            }
            echo "</form>";

        }

        mysqli_free_result($resultado);

    } catch (Exception $e) {

        $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        session_destroy();
        die($mensaje);
    }
}


