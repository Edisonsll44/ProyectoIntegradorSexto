<?php

class ActividadDTO
{
    public $id;
    public $nombre;
    public $descripcion;

    public function __construct($id, $nombre, $descripcion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }
}