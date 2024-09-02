<?php

require_once 'IConeccionBaseDatos.php';

class ConeccionBaseDatos implements IConeccionBaseDatos
{
    public static function crearConexion()
    {
        $host = '127.0.0.1';
        $usuario = 'root';
        $pass = 'root';
        $base = 'touristtrekbd';
        $port = '3307';

        // Depuración: Mostrar valores de configuración
        error_log("Conectando a la base de datos con los siguientes parámetros:");
        error_log("Host: $host");
        error_log("Usuario: $usuario");
        error_log("Base de datos: $base");
        error_log("Puerto: $port");

        $conexion = mysqli_connect($host, $usuario, $pass, $base, $port);

        if ($conexion === false) {
            error_log("Error al conectar con el servidor: " . mysqli_connect_error());
            throw new Exception("Error al conectar con el servidor: " . mysqli_connect_error());
        }

        if (!mysqli_set_charset($conexion, "utf8mb4")) {
            error_log("Error al establecer el conjunto de caracteres: " . mysqli_error($conexion));
            throw new Exception("Error al establecer el conjunto de caracteres: " . mysqli_error($conexion));
        }

        error_log("Conexión exitosa a la base de datos.");

        return $conexion;
    }
}
