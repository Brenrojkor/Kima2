<?php
require_once __DIR__ . "/../Models/TarifarioModel.php";

class TarifarioController {
    private $model;

    public function __construct() {
        $this->model = new TarifarioModel();
    }

    // ✅ Mostrar todos los productos (index)
    public function index() {
        $productos = $this->model->getAll();
        require_once __DIR__ . "/../Views/Tarifario.php";
    }

    // 📌 Obtener todos los servicios en formato JSON para AJAX
    public function getAllJson() {
        header("Content-Type: application/json"); // Asegurar que devuelve JSON
        $productos = $this->model->getAll();

        if (!empty($productos)) {
            echo json_encode(["status" => "success", "data" => $productos]);
        } else {
            echo json_encode(["status" => "error", "message" => "No hay datos disponibles."]);
        }
        exit();
    }

    // ✅ Agregar un nuevo servicio
    public function create() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            header("Content-Type: application/json");

            $nombre = $_POST["nombre"] ?? null;
            $costo = $_POST["costo"] ?? null;
            $descripcion = $_POST["descripcion"] ?? null;
            $categoria_serv =  $_POST["categoria_serv"] ?? null;

            if (!$nombre || !$costo || !$categoria_serv) {
                echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios."]);
                exit();
            }

            if ($this->model->create($nombre, $costo, $descripcion, $categoria_serv)) {
                echo json_encode(["status" => "success", "message" => "Servicio creado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al crear el servicio."]);
            }
            exit();
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

    // 📌 Actualizar un servicio existente
    public function update() {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            header("Content-Type: application/json");

            $id = $_POST["id"] ?? null;
            $nombre = $_POST["nombre"] ?? null;
            $costo = $_POST["costo"] ?? null;
            $descripcion = $_POST["descripcion"] ?? null;
            $categoria_serv =  $_POST["categoria_serv"] ?? null;

            $usuario = $_SESSION['nombre'];

            if (!$id || !$nombre || !$costo || !$categoria_serv) {
                echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios para actualizar."]);
                exit();
            }

            if ($this->model->update($id, $nombre, $costo, $descripcion, $categoria_serv, $usuario)) {
                echo json_encode(["status" => "success", "message" => "Servicio actualizado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al actualizar el servicio."]);
            }
            exit();
        }
    }

    // 📌 Eliminar un servicio
    public function delete() {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $usuario = $_SESSION['nombre'];
    
            $resultado = $this->model->delete($id, $usuario);
            echo json_encode($resultado);
        }
    }

    public function createCategoria() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nombre_categoria"])) {
            $nombre = trim($_POST["nombre_categoria"]);
            $model = new TarifarioModel();
    
            $resultado = $model->insertCategoria($nombre);
    
            if ($resultado === "exists") {
                echo json_encode(["status" => "error", "message" => "⚠️ Ya existe una categoría con ese nombre."]);
            } elseif ($resultado === "success") {
                echo json_encode(["status" => "success", "message" => "Categoría agregada correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "❌ Error al insertar la categoría."]);
            }
        }
    }


    public function obtenerNotificaciones()
{
    $result = $this->model->obtenerNotificaciones();

    echo json_encode([
        'status' => 'success',
        'total' => $result['total'],
        'data' => $result['data']
    ]);
}

public function obtenerHistorialNotificaciones()
{
    $result = $this->model->obtenerHistorialNotificaciones();

    echo json_encode([
        'status' => 'success',
        'data' => $result['data']
    ]);
}

public function marcarComoLeidas()
{
    $this->model->marcarNotificacionesComoLeidas();
    echo json_encode(['status' => 'success']);
}

public function obtenerEstadisticasCategorias()
{
    $datos = $this->model->estadisticasCategorias(); // Esta función va en el modelo
    echo json_encode(["status" => "success", "data" => $datos]);
}


public function estadisticasPorFecha()
{
    $inicio = $_GET['inicio'] ?? null;
    $fin = $_GET['fin'] ?? null;

    if (!$inicio || !$fin) {
        echo json_encode(['status' => 'error', 'message' => 'Fechas no válidas']);
        return;
    }

    $datos = $this->model->estadisticasPorFecha($inicio, $fin);
    echo json_encode(['status' => 'success', 'data' => $datos]);
}




    
    
    
}

// 🔥 Manejo de rutas (MVC)
$action = $_GET["action"] ?? "index";
error_log("Acción recibida: $action"); // Registrar acción en logs

$controller = new TarifarioController();

// ✅ Verificar si la acción es válida antes de ejecutarla
if (method_exists($controller, $action)) {
    $controller->$action();
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "Acción no válida."]);
    exit();
}
?>