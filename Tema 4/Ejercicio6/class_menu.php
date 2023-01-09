<?php

class Menu{

    private $lista;

    public function __construct()
    {
        $this->lista= [];
    }

    public function cargar($nombre_nuevo, $enlace_nuevo){

        $this->lista[$nombre_nuevo] = $enlace_nuevo;
    }

    public function vertical(){

        foreach($this->lista as $nombre=>$enlace){
            echo "<p><a href='".$enlace."'>".$nombre."</a></p>";
        }
    }

    public function horizontal(){
        $contador = 0;
        echo "<p>";
        foreach($this->lista as $nombre=>$enlace){
            echo "<a href='".$enlace."'>".$nombre."</a>";
            if ($contador < count($this->lista)-1){
                echo " - ";
            }
            $contador++;
        }

        echo "</p>";
    }
}