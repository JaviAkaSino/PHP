<?php

	if(isset($_POST["botonReset"])){
	
		//header(Location: ) debe ir SIEMPRE ANTES de escribir código HTML	
		header("Location: index.php");
		exit; //Para que no se ejecute lo demas, usar casi siempre
	}

	$error_formulario = true;
	if(isset($_POST["botonGuardar"])){
		
		//Compruebo errores tras hacer submit
		$error_nombre=$_POST["nombre"]=="";
		$error_apellidos=$_POST["apellidos"]=="";
		$error_contra=$_POST["contra"]=="";
		$error_dni=$_POST["dni"]=="";
		$error_sexo=!isset($_POST["sexo"]);
		$error_coment=$_POST["coment"]=="";
		
		//Si hay algún error, error_formulario se pone a true
		$error_formulario = $error_nombre || $error_apellidos || $error_contra || $error_dni 
			|| $error_sexo || $error_coment;
		
		
		
	}
	
		if(!$error_formulario){
	
			require "vistas/vista_respuesta.php";
		
	}else{
	
		require "vistas/vista_formulario.php";
	}
?>


