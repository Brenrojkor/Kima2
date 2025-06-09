<?php
require_once __DIR__ . "/../Models/UsuarioModel.php";

class UsuarioController {
    private $model;

    public function __construct() {
        $this->model = new UsuarioModel();
    }


    // 📌 Obtener todos los servicios en formato JSON para AJAX
    public function getAllJson() {
        header("Content-Type: application/json"); // Asegurar que devuelve JSON
        $productos = $this->model->getAllUsuarios();

        if (!empty($productos)) {
            echo json_encode(["status" => "success", "data" => $productos]);
        } else {
            echo json_encode(["status" => "error", "message" => "No hay datos disponibles."]);
        }
        exit();
    }

    public function create() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = $_POST["nombre"] ?? null;
            $email = $_POST["email"] ?? null;
            $password = $_POST["password"] ?? null;
            $estado_id = $_POST["estado"] ?? null;
            $rol = $_POST["rol"] ?? null; // 🔥 Corregido
    
            // Validación de datos
            if (!$nombre || !$email || !$estado_id || !$rol || !$password) {
                echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]);
                exit();
            }
    
            // Llamar al modelo para crear el usuario
            $result = $this->model->createUsuario($nombre, $email, $estado_id, $password, $rol);
    
            if (is_array($result)) {
                echo json_encode($result);
            } else if ($result === true) {
                echo json_encode(["status" => "success", "message" => "Usuario agregado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al agregar el usuario."]);
            }
        }
    }


    public function getUserById() {
        if (!isset($_GET["id"])) {
            echo json_encode(["status" => "error", "message" => "ID de usuario no proporcionado"]);
            exit();
        }
    
        $usuarioID = $_GET["id"];
        $users = $this->model->getUserById($usuarioID);
    
        if ($users) {
            echo json_encode(["status" => "success", "data" => $users]);
        } else {
            echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
        }
        exit();
    }


    public function updateUsuario() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"] ?? null;
            $nombre = $_POST["nombre"] ?? null;
            $email = $_POST["email"] ?? null;
            $rol = $_POST["rol"] ?? null;
            $estado_id = $_POST["estado_id"] ?? null;
            $password = $_POST["password"] ?? null;
    
            if (!$id || !$nombre || !$email || !$rol || !$estado_id) {
                echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]);
                exit();
            }
    
            $this->model->updateUsuario($id, $nombre, $email, $rol, $estado_id, $password);
            echo json_encode(["status" => "success", "message" => "Usuario actualizado correctamente."]);
        }
    }

    public function deleteUser() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"] ?? null;
    
            if (!$id) {
                echo json_encode(["status" => "error", "message" => "ID de usuario no proporcionado."]);
                exit();
            }
    
            $result = $this->model->deleteUserById($id);
    
            if ($result) {
                echo json_encode(["status" => "success", "message" => "Usuario eliminado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al eliminar el usuario."]);
            }
            exit();
        }
    }
    
    

    /*public function getAllJsonSearch() {
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
    
*/


  /*  public function updateCliente() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id_cliente"] ?? null;
            $nombre = $_POST["nombre"] ?? null;
            $cedula = $_POST["cedula"] ?? null;
            $email = $_POST["email"] ?? null;
            $estado_id = $_POST["estado"] ?? null;
            $empresa = $_POST["empresa"] ?? null;
            $telefono = $_POST["telefono"] ?? null;
            $direccion = $_POST["direccion"] ?? null;
    
            if (!$id || !$nombre || !$email || !$estado_id) {
                echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]);
                exit();
            }
    
            $result = $this->model->updateCliente($id, $nombre, $email, $estado_id, $empresa, $cedula, $telefono, $direccion);
    
            if ($result) {
                echo json_encode(["status" => "success", "message" => "Cliente actualizado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al actualizar el cliente."]);
            }
        }
    }
    

    public function getClienteById() {
        if (!isset($_GET["id"])) {
            echo json_encode(["status" => "error", "message" => "ID de cliente no proporcionado"]);
            exit();
        }
    
        $clienteID = $_GET["id"];
        $clientes = $this->model->getClienteById($clienteID);
    
        if ($clientes) {
            echo json_encode(["status" => "success", "data" => $clientes]);
        } else {
            echo json_encode(["status" => "error", "message" => "Cliente no encontrado"]);
        }
        exit();
    }
    

    public function deleteCliente() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"] ?? null;
    
            if (!$id) {
                echo json_encode(["status" => "error", "message" => "ID de cliente no proporcionado."]);
                exit();
            }
    
            $result = $this->model->deleteClienteById($id);
    
            if ($result) {
                echo json_encode(["status" => "success", "message" => "Cliente eliminado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al eliminar el cliente."]);
            }
            exit();
        }
    }*/
    
    
    public function actualizarFoto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioId = $_POST['usuario_id'] ?? null;
            
            if (!$usuarioId || !isset($_FILES['foto_perfil']) || $_FILES['foto_perfil']['error'] !== 0) {
                echo json_encode(["status" => "error", "message" => "Faltan datos o archivo inválido"]);
                exit();
            }

            $nombreArchivo = uniqid() . '_' . basename($_FILES['foto_perfil']['name']);
            $rutaDestino = __DIR__ . '/../../uploads/usuarios/' . $nombreArchivo;

            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                $this->model->actualizarFotoUsuario($usuarioId, $nombreArchivo);
                header("Location: /Kima/app/Views/usuarios_perfil.php?id=$usuarioId");
                exit();
            } else {
                echo json_encode(["status" => "error", "message" => "Error al mover la imagen"]);
                exit();
            }
        }
    }
    

    
}

// 🔥 Manejo de rutas (MVC)
$action = $_GET["action"] ?? "index";
error_log("Acción recibida: $action"); // Registrar acción en logs

$controller = new UsuarioController();

// ✅ Verificar si la acción es válida antes de ejecutarla
if (method_exists($controller, $action)) {
    $controller->$action();
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "Acción no válida."]);
    exit();
}
?>