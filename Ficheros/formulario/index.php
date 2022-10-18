<?php

	if(isset($_POST["botonReset"])){
	
		//header(Location: ) debe ir SIEMPRE ANTES de escribir código HTML	
		header("Location: index.php");
		exit; //Para que no se ejecute lo demas, usar casi siempre
	}

	

	function longitud_dni ($dni){

			return strlen($dni)==9;
	}
	
	function numeros_letras ($dni){

		return(is_numeric(substr($dni, 0, 8)) && is_string(substr($dni, 8, 1)));
	}

	function letraNIF($dni){
		return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
	}

	function letra_correcta ($dni){

		return letraNIF(substr($dni, 0, 8)) == strtoupper(substr($dni, 8, 1));
	}

	function formato_dni ($dni){

		return longitud_dni($dni) && numeros_letras($dni);
	}

	function nif_correcto($dni){

		return formato_dni ($dni) && letra_correcta($dni);
	}
	$error_formulario = true;
	if(isset($_POST["boton_submit"])){
		
		//Compruebo errores tras hacer submit
		$error_nombre=$_POST["nombre"]=="";
		$error_usuario=$_POST["usuario"]=="";
		$error_contra=$_POST["contra"]=="";
		$error_dni=$_POST["dni"]=="" || !nif_correcto($_POST["dni"]);
		$error_sexo=!isset($_POST["sexo"]);
		$error_archivo=$_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || 
			$_FILES["foto"]["size"]>500*1000 || $_FILES["foto"]["name"]=="";
		
		//Si hay algún error, error_formulario se pone a true
		$error_formulario = $error_nombre || $error_usuario || $error_contra || $error_dni 
			|| $error_sexo;
		
		
		
	}
	
		if(!$error_formulario){
	
			require "vistas/vista_respuesta.php";
		
	}else{
	
		require "vistas/vista_formulario.php";
	}
?>


