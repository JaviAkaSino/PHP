<?php

class Fruta
{
    private $color; 
    private $tamanio;
    private static $n_frutas = 0;
    
    public function __construct($color_nuevo, $tamanio_nuevo)
    {
        $this->color = $color_nuevo;
        $this->tamanio = $tamanio_nuevo;

        self::$n_frutas++;
    }

    public function __destruct()
    {
        self::$n_frutas--;
    }

    public static function cuantaFruta(){

        return self::$n_frutas;
    }

    public function imprimir()
    {
        echo "<p><strong>Color: </strong>" . $this->getColor() . "</p>";
        echo "<p><strong>Tamaño: </strong>" . $this->getTamanio() . "</p>";
    }

    public function setColor($color_nuevo)
    {
        $this->color = $color_nuevo;
    }

    public function setTamanio($tamanio_nuevo)
    {
        $this->tamanio = $tamanio_nuevo;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getTamanio()
    {
        return $this->tamanio;
    }
}
