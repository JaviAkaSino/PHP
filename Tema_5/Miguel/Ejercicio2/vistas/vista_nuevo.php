<?php
 $url=DIR_SERV."/familias";
 $respuesta=consumir_servicios_REST($url,"GET");
 $obj=json_decode($respuesta);
 if(!$obj)
     die("<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta."</body></html>");

 if(isset($obj->mensaje_error))
     die("<p>".$obj->mensaje_error."</p></body></html>");

 if(!$obj->familias)
 {
     echo "<form class='centrado centro' action='index.php' method='post'>";
     echo "<h2>Creando un Producto</h2>";
     echo "<p>Aún no hay familias de los productos en la BD. Inserte alguna antes de Añadir un nuevo producto</p>";
     echo "<p><button>Volver</button></p>";
     echo "</form>";
 }
 else
 {
 ?>
     <form class="centro" action="index.php" method="post">
         <h2>Creando un Producto</h2>
         <p>
             <label for="cod">Código: </label>
             <input type="text" maxlength="12" name="cod" id="cod" value="<?php if(isset($_POST["cod"])) echo $_POST["cod"];?>"/>
             <?php
                 if(isset($_POST["btnContNuevo"]) && $error_cod)
                 {
                     if($_POST["cod"]=="")
                         echo "<span class='error'> Campo Vacío</span>";
                     else
                         echo "<span class='error'> Código repetido</span>"; 
                 }
             ?>
         </p>
         <p>
             <label for="nombre">Nombre: </label>
             <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
         </p>
         <p>
             <label for="nombre_corto">Nombre corto: </label>
             <input type="text" name="nombre_corto" id="nombre_corto" value="<?php if(isset($_POST["nombre_corto"])) echo $_POST["nombre_corto"];?>"/>
             <?php
                 if(isset($_POST["btnContNuevo"]) && $error_nombre_corto)
                         echo "<span class='error'> Campo Vacío</span>";
             ?>
         </p>
         <p>
             <label for="descripcion">Descripción: </label>
             <textarea name="descripcion" id="descripcion"><?php if(isset($_POST["descripcion"])) echo $_POST["descripcion"];?></textarea>
             <?php
                 if(isset($_POST["btnContNuevo"]) && $error_descripcion)
                         echo "<span class='error'> Campo Vacío</span>";
             ?>
         </p>
         <p>
             <label for="PVP">PVP: </label>
             <input type="text"  name="PVP" id="PVP" value="<?php if(isset($_POST["PVP"])) echo $_POST["PVP"];?>"/>
             <?php
                 if(isset($_POST["btnContNuevo"]) && $error_PVP)
                 {
                     if($_POST["PVP"]=="")
                         echo "<span class='error'> Campo Vacío</span>";
                     else
                         echo "<span class='error'> Cuantía no válida</span>"; 
                 }
             ?>
         </p>
         <p>
             <label for="familia">Seleccione una familia: </label>
             <select id="familia" name="familia">
             <?php
             foreach ($obj->familias as $tupla) 
             {
                 if(isset($_POST["familia"]) && $_POST["familia"]==$tupla->cod)
                     echo "<option selected value='".$tupla->cod."'>".$tupla->nombre."</option>";
                 else
                     echo "<option value='".$tupla->cod."'>".$tupla->nombre."</option>";
             }
             ?>
             </select>
         </p>
         <p>
             <button>Volver</button> <button name="btnContNuevo">Continuar</button>
         </p>
     </form>
 
 <?php
 }
?>