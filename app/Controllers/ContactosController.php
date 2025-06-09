<?php
require_once __DIR__ . "/../Models/ContactosModel.php";

class ContactosController {
    private $model;

    public function __construct() {
        $this->model = new ContactosModel();
    }

    // ✅ Mostrar todos los productos (index)
    public function index() {
        $productos = $this->model->getAllClientes();
        require_once __DIR__ . "/../Views/ListaClientes.php";
    }

    // 📌 Obtener todos los servicios en formato JSON para AJAX
    public function getAllJson() {
        header("Content-Type: application/json"); // Asegurar que devuelve JSON
        $productos = $this->model->getAllClientes();

        if (!empty($productos)) {
            echo json_encode(["status" => "success", "data" => $productos]);
        } else {
            echo json_encode(["status" => "error", "message" => "No hay datos disponibles."]);
        }
        exit();
    }

    public function getAllJsonSearch() {
        header("Content-Type: application/json"); 
    
        $filtros = [
            'nombre' => $_GET['nombre'] ?? '',
            'email' => $_GET['email'] ?? '',
            'empresa' => $_GET['empresa'] ?? '',
            'estado' => $_GET['estado'] ?? ''
        ];
    
        $clientes = $this->model->getClientesFiltrados($filtros);
    
        echo json_encode(["status" => "success", "data" => $clientes]);
        exit();
    }
    


    public function create() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = $_POST["nombre"] ?? null;
            $email = $_POST["email"] ?? null;
            $estado_id = $_POST["estado"] ?? null;
            $empresa = $_POST["empresa"] ?? null;
            $cedula = $_POST["cedula"] ?? null;
            $servicio = $_POST["servicio"] ?? null;
            $especialidad = $_POST["especialidad"] ?? null;
            $telefono = $_POST["telefono"] ?? null;
            $direccion = $_POST["direccion"] ?? null;

            if (!$nombre || !$email || !$estado_id) {
                echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]);
                exit();
            }

            $result = $this->model->createCliente($nombre, $email, $estado_id, $empresa, $cedula, $servicio, $especialidad, $telefono, $direccion);

            echo json_encode($result);
        }
    }

    public function getHistorialJson() {
        header("Content-Type: application/json");

        $historial = $this->model->obtenerHistorialAgrupado();

        if (!empty($historial)) {
            echo json_encode(["status" => "success", "data" => $historial]);
        } else {
            echo json_encode(["status" => "error", "message" => "No hay historial disponible."]);
        }
        exit();
    }


    public function updateCliente() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id_cliente"] ?? null;
            $nombre = $_POST["nombre"] ?? null;
            $cedula = $_POST["cedula"] ?? null;
            $email = $_POST["email"] ?? null;
            $estado_id = $_POST["estado"] ?? null;
            $empresa = $_POST["empresa"] ?? null;
            $telefono = $_POST["telefono"] ?? null;
            $direccion = $_POST["direccion"] ?? null;
            $servicio = $_POST["servicio"] ?? null;
            $especialidad = $_POST["especialidad"] ?? null;
    
            if (!$id || !$nombre || !$email || !$estado_id || !$cedula) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Faltan datos obligatorios"
                ]);
                exit();
            }


            session_start();
            // Obtener usuario logueado
            $usuario = $_SESSION['nombre'] ?? 'Sistema'; 
    
            $result = $this->model->updateCliente(
                $id,
                $nombre,
                $email,
                $estado_id,
                $empresa,
                $cedula,
                $telefono,
                $direccion,
                $servicio,
                $especialidad,
                $usuario
            );
    
            // El modelo ahora puede devolver un array con status/error, no solo true/false
            if (is_array($result)) {
                echo json_encode($result);
            } else if ($result === true) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Contacto actualizado correctamente."
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error desconocido al actualizar el contacto."
                ]);
            }
        }
    }
    

    public function getClienteById() {
        if (!isset($_GET["id"])) {
            echo json_encode(["status" => "error", "message" => "ID de contacto no proporcionado"]);
            exit();
        }
    
        $clienteID = $_GET["id"];
        $clientes = $this->model->getClienteById($clienteID);
    
        if ($clientes) {
            echo json_encode(["status" => "success", "data" => $clientes]);
        } else {
            echo json_encode(["status" => "error", "message" => "Contacto no encontrado"]);
        }
        exit();
    }
    

    public function deleteCliente() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"] ?? null;
    
            if (!$id) {
                echo json_encode(["status" => "error", "message" => "ID de contacto no proporcionado."]);
                exit();
            }
    
            // ✅ Ya que `deleteClienteById` devuelve un array con status y message, simplemente retornamos eso:
            $result = $this->model->deleteClienteById($id);
            echo json_encode($result);
            exit();
        }
    }    
    
}

// 🔥 Manejo de rutas (MVC)
$action = $_GET["action"] ?? "index";
error_log("Acción recibida: $action"); // Registrar acción en logs

$controller = new ContactosController();

// ✅ Verificar si la acción es válida antes de ejecutarla
if (method_exists($controller, $action)) {
    $controller->$action();
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "Acción no válida."]);
    exit();
}
?>