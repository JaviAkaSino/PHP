<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 17 - Javier Parodi</title>
</head>
<body>
	
	<h1>Ejercicio 17</h1>
    <?php
        
        $familias=array("Los Simpson" => array("Padre"=>"Homer", "Madre"=>"Marge", "Hijos"=> array("Bart", "Lisa", "Maggie")), "Los Griffin" => array("Padre"=>"Peter", "Madre"=>"Lois", "Hijos"=> array("Chris", "Meg", "Stewie")));
        
        foreach ($familias as $i => $value){
    
        ?>
        
        <ul>
        	<li><?php echo $i; ?>
		    	<ul>
		    		<?php foreach($value as $j => $rol){
		
						echo "<li>";
						
						if ($j == "Hijos"){
						
							echo $j.": <ol>";
							
							foreach ($rol as $k => $name){
								
							echo"<li>".$name."</li>";	 
							}
								      				
							echo "</ol>";
							
						} else { 
						
							echo $j.": ".$rol;
							echo"</li>";
						}
		    		} ?>	
		    			
		    	</ul>
        	</li>
        
        </ul>
        
        <?php } ?>       
       
</body>
</html>
