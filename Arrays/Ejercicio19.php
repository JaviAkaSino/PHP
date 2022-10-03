<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 19 - Javier Parodi</title>
</head>
<body>
	
	<h1>Ejercicio 19</h1>
    <?php
        $pedro=array("Edad"=> 32, "Telefono"=> "91-9999999");
        $antonio=array("Edad"=> 25, "Telefono"=> "91-8152365");
        $susana=array("Edad"=> 53, "Telefono"=> "93-952952952");
    	$pepe=array("Edad"=> 42, "Telefono"=> "93-09090909");
        $rosa=array("Edad"=> 33, "Telefono"=> "925-20202020");
        $javi=array("Edad"=> 26, "Telefono"=> "925-16161616");
	
        $madrid=array("Pedro"=>$pedro);
        $barcelona=array("Antonio"=>$antonio, "Susana"=>$susana, "Pepe"=>$pepe);
        $toledo=array("Rosa"=>$rosa, "Javi"=>$javi);

        $amigos=array("Madrid"=>$madrid, "Barcelona" =>$barcelona, "Toledo"=>$toledo);        
    ?>

    <ul><?php
        foreach($amigos as $i => $ciudad){
            echo "<p>Amigos en ".$i.":";

            echo "<ol>";
            
            foreach($ciudad as $j => $persona){

                echo "<li>Nombre: ".$j.". ";

                foreach($persona as $k => $dato){

                    echo $k.": ".$dato.". ";
                }
            }

            echo "</ol>";


            echo "</p>";

        }

        ?>
        
        
        
        
       	
        
    
</body>
</html>

