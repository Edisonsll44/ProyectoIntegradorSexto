<?php
require_once '../vendor/autoload.php'; // Incluye el autoloader de Composer

use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: POST");
header("Allow: POST");

// Configuración de la clave secreta para JWT
$secretKey = "tu_clave_secreta";
$algorithm = 'HS256';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->username) && isset($data->password)) {
        // Aquí deberías validar el usuario contra una base de datos
        // Ejemplo de validación (para fines demostrativos, no usar en producción)
        if ($data->username === "usuario" && $data->password === "contraseña") {
            $token = [
                "iat" => time(),
                "exp" => time() + 3600, // 1 hora
                "data" => [
                    "username" => $data->username
                ]
            ];

            $jwt = JWT::encode($token, $secretKey,$algorithm);
            echo json_encode(["token" => $jwt]);
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Usuario o contraseña inválidos"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Datos incompletos"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Método no permitido"]);
}
