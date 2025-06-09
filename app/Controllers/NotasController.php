<?php
require_once __DIR__ . "/../Models/NotasModel.php";

class NotasController {
    private $model;

    public function __construct() {
        $this->model = new NotasModel();
    }

    // ✅ Mostrar todos los productos (index)
    
    public function guardar() {
        session_start();
        $usuarioId = $_SESSION['usuario_id'] ?? null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $usuarioId) {
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
    
            if (isset($_POST['id']) && $_POST['id']) {
                $this->model->update($_POST['id'], $titulo, $descripcion);
                echo json_encode(['status' => 'success', 'message' => 'Nota actualizada correctamente.']);
            } else {
                $this->model->save($titulo, $descripcion, $usuarioId);
                echo json_encode(['status' => 'success', 'message' => 'Nota guardada correctamente.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado.']);
        }
    }
    
    public function listarNotas() {
        session_start();
        $usuarioId = $_SESSION['usuario_id'] ?? null;
    
        if ($usuarioId) {
            $notas = $this->model->obtenerUltimasNotas($usuarioId, 4);
            if ($notas) {
                echo json_encode(["status" => "success", "data" => $notas]);
            } else {
                echo json_encode(["status" => "empty", "message" => "No hay notas disponibles"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Usuario no autenticado."]);
        }
    }
    
    

    public function obtenerNota() {
        if (isset($_GET['id'])) {
            $nota = $this->model->getById($_GET['id']);
    
            if ($nota) {
                echo json_encode(['status' => 'success', 'data' => $nota]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Nota no encontrada.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado.']);
        }
    }

    public function eliminar() {
        if (isset($_POST['id'])) {
            $resultado = $this->model->delete($_POST['id']);
            if ($resultado) {
                echo json_encode(["status" => "success", "message" => "Nota eliminada correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al eliminar la nota."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "ID no proporcionado."]);
        }
    }
    
    
    
}

// 🔥 Manejo de rutas (MVC)
$action = $_GET["action"] ?? "index";
error_log("Acción recibida: $action"); // Registrar acción en logs

$controller = new NotasController();

// ✅ Verificar si la acción es válida antes de ejecutarla
if (method_exists($controller, $action)) {
    $controller->$action();
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "Acción no válida."]);
    exit();
}
?>