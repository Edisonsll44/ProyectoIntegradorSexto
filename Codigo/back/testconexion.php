<?php
include_once '../back/config/ConeccionBaseDatos.php';

// Intentar crear una conexión
try {
    $conexion = ConeccionBaseDatos::crearConexion();
    echo "Conexión exitosa a la base de datos.";
} catch (Exception $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}

// Cerrar la conexión si es necesario
if (isset($conexion) && $conexion) {
    mysqli_close($conexion);
}