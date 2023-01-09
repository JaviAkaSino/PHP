<?php

use Fruta as GlobalFruta;

class Fruta
{
    private $color;
    private $tamanio;

    //En php se puede tener UN sólo constructor

    public function __construct($color_nuevo, $tamanio_nuevo)
    {
        $this->color = $color_nuevo;
        $this->tamanio = $tamanio_nuevo;

        $this->imprimir();
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
