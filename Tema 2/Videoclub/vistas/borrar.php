<?php
echo "<div class='centrar'>
                <h3>Borrar película</h3>
                <p>¿Seguro que desea borrar la película Nº " . $_POST["boton_borrar"] . "?</p>
                <form action='index.php' method='post'>
                    <button type='submit' name='boton_volver'>Volver</button>
                    <button type='submit' name='boton_confirmar_borrar' value='".$_POST["boton_borrar"]."'>Borrar</button>
                    <input type='hidden' name='nombre_caratula' value='".$_POST["nombre_caratula"]."'/>
                </form>
            </div>";
