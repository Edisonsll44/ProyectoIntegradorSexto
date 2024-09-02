<?php

require_once '../models/Interfaces/IActividades.Model.php';
require_once '../models/Actividades.Model.php';

class ActividadesFactory
{
    public static function create(IConeccionBaseDatos $dbConnection): IActividades
    {
        return new Actividades($dbConnection);
    }
}
