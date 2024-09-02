<?php

abstract class RepositorioGenerico
{
    protected $conexionBD;
    protected $tabla;
    protected $clavePrimaria;
    protected $campos;

    public function __construct(ConeccionBaseDatos $conexionBD, $tabla, $clavePrimaria, array $campos)
    {
        $this->conexionBD = $conexionBD::crearConexion();
        $this->tabla = $tabla;
        $this->clavePrimaria = $clavePrimaria;
        $this->campos = $campos;
    }

    public function getAll()
    {
        $consulta = "SELECT * FROM `{$this->tabla}`";
        return mysqli_query($this->conexionBD, $consulta);
    }

    public function getOneById($id)
    {
        $consulta = "SELECT * FROM `{$this->tabla}` WHERE `{$this->clavePrimaria}` = ?";
        $stmt = $this->conexionBD->prepare($consulta);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function insert(array $valores)
    {
        $camposString = implode('`, `', $this->campos);
        $placeholders = implode(', ', array_fill(0, count($valores), '?'));
        $consulta = "INSERT INTO `{$this->tabla}` (`{$camposString}`) VALUES ({$placeholders})";

        $stmt = $this->conexionBD->prepare($consulta);
        $tipos = str_repeat('s', count($valores));  // Asumimos que todos los valores son strings
        $stmt->bind_param($tipos, ...array_values($valores));

        if ($stmt->execute()) {
            return $this->conexionBD->insert_id;
        } else {
            return $this->conexionBD->error;
        }
    }

    public function update($id, array $values)
    {
        try {
            $con = $this->conexionBD; // Usar la conexión existente
            $cadena = "UPDATE `{$this->tabla}` SET ";
            $pos = 0;
            foreach ($values as $valor) {
                $campoTmp = $this->campos[$pos];
                if ((count($values) - 1) > $pos) {
                    $cadena .= "`$campoTmp` = ?, ";
                } else {
                    $cadena .= "`$campoTmp` = ? ";
                }
                $pos++;
            }
            $cadena .= "WHERE `{$this->clavePrimaria}` = ?";

            $stmt = $con->prepare($cadena);
            $types = str_repeat('s', count($values)) . 'i';  // Asumimos que todos los valores son strings y el ID es un entero
            $params = array_merge(array($types), array_values($values), array($id));

            // Usar call_user_func_array para pasar los parámetros
            $stmt->bind_param(...$params);

            if ($stmt->execute()) {
                return $id;
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        }
    }

    public function delete($id)
    {
        $consulta = "DELETE FROM `{$this->tabla}` WHERE `{$this->clavePrimaria}` = ?";
        $stmt = $this->conexionBD->prepare($consulta);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return $this->conexionBD->error;
        }
    }
}
