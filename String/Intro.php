<!DOCTYPE html>
<html>
	<head>
		<title>Indroducción String</title>
		<meta charset="UTF-8"/>
	</head>
	<body>
		<?php
			$texto1 = "  Esto es un String1, ";
			$texto1 .= "Esto es otro String2";
			
			echo "<pre>".$texto1."</pre>";
			
			echo "<pre>".trim($texto1)."</pre>"; //Quita espacios ltrim - rtrim
			
			
			echo strlen($texto1);
			
			
			echo "<p>".$texto1[5]."</p>";
			
			
			echo "<p>".strtoupper($texto1)."</p>";
			
			echo "<p>".strtolower($texto1)."</p>";
			
			
			$arr = explode(", ",$texto1);
						
			print_r($arr);
			
			echo "<br/><br/>";
			
			var_dump($arr);
			
			
			$texto2 = implode(" - ", $arr);
			
			echo "<p>".$texto2."</p>";
			
			
			echo md5($texto1); //Encriptador
			
		?>
	</body>
</html>
