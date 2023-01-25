<?php

class Fruta{
  private $color; //var es public  
  private $tamanio;

    public function setColor($color_nuevo){
        $this->color = $color_nuevo;
    }

    public function setTamanio($tamanio_nuevo){
        $this->tamanio = $tamanio_nuevo;
    }

    public function getColor(){
        return $this->color;
    }

    public function getTamanio(){
        return $this->tamanio;
    }
}
