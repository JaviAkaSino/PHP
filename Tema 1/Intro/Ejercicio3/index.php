<?php
	if(isset($_POST["botonGuardar"])){ //Si está inicializada
	
		//include y required cortan y pegan por mí
		include "vistas/vista_respuesta.php"; //Sigue con la ejecución
			
	}else{
	
		require "vistas/vista_formulario.php"; //Para la ejecución si no se encuentra la página
	
	}
?>
