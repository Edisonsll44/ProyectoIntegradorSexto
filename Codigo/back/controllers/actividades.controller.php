<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];

if ($method == "OPTIONS") {
    die();
}

require_once '../factory/ActividadesFactory.php';
require_once '../config/ConeccionBaseDatos.php';

// Crear instancia de la conexión a la base de datos
$dbConnection = new ConeccionBaseDatos();

// Crear instancia de IActividades utilizando la fábrica
$actividades = ActividadesFactory::create($dbConnection);

switch ($method) {
    case 'GET':

        if (isset($_GET['id'])) {
            // Obtener un registro específico
            $id_actividad = $_GET['id'];
            $datos = $actividades->uno($id_actividad);
            echo json_encode($datos);
        } else {
            $datos = $actividades->todos();
            echo json_encode($datos);
        }
        break;

    case 'POST':
        $nombre = $_POST['nombre'];
        $id_tipo_actividad = $_POST['id_tipo_actividad'];
        $idInsertado = $actividades->insertar($nombre, $id_tipo_actividad);
        echo json_encode(["id_insertado" => $idInsertado]);
        break;
        
    case 'PUT':
        parse_str(file_get_contents("php://input"), $put_vars);
        $id_actividad = $put_vars['id_actividad'];
        $nombre = $put_vars['nombre'];
        $id_tipo_actividad = $put_vars['id_tipo_actividad'];
        $resultado = $actividades->actualizar($id_actividad, $nombre, $id_tipo_actividad);
        echo json_encode(["resultado" => $resultado]);
        break;
        
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $delete_vars);
        $id_actividad = $delete_vars['id_actividad'];
        $resultado = $actividades->eliminar($id_actividad);
        echo json_encode(["resultado" => $resultado]);
        break;
        
        default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
