<?php
require_once '../config/IConeccionBaseDatos.php';
require_once '../config/RepositorioGenerico.php';
require_once '../models/Interfaces/IActividades.Model.php';
require_once '../dto/ActividadDTO.php';

class Actividades extends RepositorioGenerico implements IActividades
{
    public function __construct(IConeccionBaseDatos $dbConnection)
    {
        parent::__construct($dbConnection, 'actividades', 'idactividad', ['nombre', 'descripcion']);
    }

    public function todos() 
    {
        $datos = $this->getAll();
        $listaDTOs = [];

        while ($fila = mysqli_fetch_assoc($datos)) {
            $dto = new ActividadDTO(
                $fila['idactividad'], 
                $fila['nombre'], 
                $fila['descripcion']
            );
            $listaDTOs[] = $dto;
        }

        return $listaDTOs;
    }

    public function uno($id_actividad) 
    {
        $datos = $this->getOneById($id_actividad);
        $listaDTOs = [];

        while ($fila = mysqli_fetch_assoc($datos)) {
            $dto = new ActividadDTO(
                $fila['id_actividad'], 
                $fila['nombre'], 
                $fila['id_tipo_actividad']
            );
            $listaDTOs[] = $dto;
        }

        return $listaDTOs;
    }

    public function insertar($nombre, $id_tipo_actividad) 
    {
        $valores = ['nombre' => $nombre, 'id_tipo_actividad' => $id_tipo_actividad];
        return $this->insert($valores);
    }

    public function actualizar($id_actividad, $nombre, $id_tipo_actividad) 
    {
        $valores = ['nombre' => $nombre, 'id_tipo_actividad' => $id_tipo_actividad];
        return $this->update($id_actividad, $valores);
    }

    public function eliminar($id_actividad) 
    {
        return $this->delete($id_actividad);
    }
}