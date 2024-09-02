<?php
// IActividades.php

interface IActividades
{
    public function todos();
    public function uno($id_actividad);
    public function insertar($nombre, $id_tipo_actividad);
    public function actualizar($id_actividad, $nombre, $id_tipo_actividad);
    public function eliminar($id_actividad);
}