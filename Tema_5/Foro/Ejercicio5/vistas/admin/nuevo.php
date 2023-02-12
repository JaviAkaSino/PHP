<h3>Nuevo usuario</h3>
<form action="index.php" method="post">
    <p>
        <label for="nombre">Nombre: </label>
        <input type="text" id="nombre" name="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
        <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_nombre)
            echo "<span class='error'>* Campo vacío * </span>"; ?>
    </p>

    <p>
        <label for="usuario">Usuario: </label>
        <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
        <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_usuario) {

            if ($_POST["usuario"] == "")
                echo "<span class='error'>* Campo vacío * </span>";
            else
                echo "<span class='error'>* Usuario ya existente * </span>";
        }
        ?>
    </p>

    <p>
        <label for="clave">Contraseña: </label>
        <input type="password" id="clave" name="clave" value="<?php if (isset($_POST["clave"])) echo $_POST["clave"]; ?>">
        <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_clave)
            echo "<span class='error'>* Campo vacío * </span>"; ?>
    </p>

    <p>
        <label for="email">E-mail: </label>
        <input type="text" id="email" name="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>">
        <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_email) {

            if ($_POST["email"] == "")
                echo "<span class='error'>* Campo vacío * </span>";
            else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                echo "<span class='error'>* Formato de e-mail no válido * </span>";
            else
                echo "<span class='error'>* E-mail ya existente * </span>";
        }
        ?>
    </p>

    <p>
        <button type="submit">Atrás</button>
        <button type="submit" name="boton_confirmar_nuevo">Continuar</button>
    </p>
</form>