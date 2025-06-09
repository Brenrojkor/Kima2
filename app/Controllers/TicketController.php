<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../models/TicketModel.php';
require_once __DIR__ . '/../../config/database.php';

class TicketController {
    private $ticketModel;

    public function __construct() {
        $this->ticketModel = new Ticket($GLOBALS['conn']);
    }

    public function obtenerDocumentosPorTicket() {
        header('Content-Type: application/json');
        
        if (!isset($_GET['ticket_id'])) {
            echo json_encode(["status" => "error", "message" => "ID de ticket no proporcionado."]);
            return;
        }
    
        $ticket_id = $_GET['ticket_id'];
        $stmt = $GLOBALS['conn']->prepare("SELECT ID, NombreArchivo, RutaArchivo FROM documentos_tickets WHERE TicketID = ?");
        $stmt->execute([$ticket_id]);
        $archivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($archivos as &$doc) {
            $doc['RutaArchivo'] = "/Kima/public/uploads/" . $doc['NombreArchivo'];
        }
        
    
        echo json_encode(["status" => "success", "data" => $archivos]);
    }

    public function eliminarDocumento() {
        header('Content-Type: application/json');
    
        if (!isset($_POST['id'])) {
            echo json_encode(["status" => "error", "message" => "ID del documento no proporcionado."]);
            return;
        }
    
        $docId = intval($_POST['id']);
    
        // Llamar al modelo para que se encargue de eliminar
        $resultado = $this->ticketModel->eliminarDocumentoPorId($docId);
        echo json_encode($resultado);
    }
    
    
    
    

    public function procesarTicket() {
        session_start();
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tipoProductoID = $_POST['product'] ?? null;
            $responsableID = $_POST['user'] ?? null;
            $descripcion = $_POST['description'] ?? null;
            $clienteID = $_POST['cliente'] ?? null;
            $prioridadId = $_POST['prioridad'] ?? null;
            $documentos = $_POST['documentos'] ?? [];

    
            // Validación
            if (!$tipoProductoID || !$responsableID || !$descripcion || !$clienteID || !$prioridadId) {
                echo json_encode(["status" => "error", "message" => "⚠️ Todos los campos requeridos deben completarse."]);
                exit;
            }
    
            if (!$clienteID) {
                echo json_encode(["status" => "error", "message" => "❌ Usuario no autenticado."]);
                exit;
            }
    
            $resultado = $this->ticketModel->crearTicket($tipoProductoID, $responsableID, $clienteID, $prioridadId, $descripcion, $documentos);
    
            // ✅ Nuevo manejo limpio y claro
            if ($resultado["status"] === "success") {
                echo json_encode(["status" => "success", "message" => $resultado["message"]]);
            } else {
                echo json_encode(["status" => "error", "message" => $resultado["message"]]);
            }
            exit; // 🔥 Esto es CRÍTICO para evitar doble respuesta
        }
    }
    
    
    public function obtenerTickets() {
        header('Content-Type: application/json');

        $tickets = $this->ticketModel->obtenerTickets();

        if (!empty($tickets)) {
            echo json_encode(["status" => "success", "data" => $tickets]);
        } else {
            echo json_encode(["status" => "error", "message" => "No hay tickets disponibles."]);
        }
        exit;
    }


    public function buscarTickets() {
        header('Content-Type: application/json');
    
        if (!isset($_GET['query']) || empty(trim($_GET['query']))) {
            echo json_encode(["status" => "error", "message" => "No se ha proporcionado un criterio de búsqueda."]);
            exit;
        }
    
        $query = trim($_GET['query']);
    
        // 🔥 Verificar que el parámetro llega al backend
        error_log("Consulta de búsqueda recibida en PHP: " . $query);
    
        $tickets = $this->ticketModel->buscarTickets($query);
    
        if (!empty($tickets)) {
            echo json_encode(["status" => "success", "data" => $tickets]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se encontraron tickets con ese criterio."]);
        }
        exit;
    }


    public function buscarClientes() {
        header('Content-Type: application/json');

        $searchTerm = $_GET['search'] ?? '';

        if (empty($searchTerm)) {
            echo json_encode(["status" => "error", "message" => "No se proporcionó un criterio de búsqueda."]);
            exit;
        }

        $clientes = $this->ticketModel->buscarClientes($searchTerm);

        if (!empty($clientes)) {
            echo json_encode(["status" => "success", "data" => $clientes]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se encontraron clientes."]);
        }
        exit;
    }

    public function obtenerTicket() {
        header('Content-Type: application/json');
    
        if (!isset($_GET['id'])) {
            echo json_encode(["status" => "error", "message" => "ID de ticket no proporcionado."]);
            exit;
        }
    
        $ticket = $this->ticketModel->obtenerTicketPorId($_GET['id']);
    
        if ($ticket) {
            echo json_encode(["status" => "success", "data" => $ticket]);
        } else {
            echo json_encode(["status" => "error", "message" => "Ticket no encontrado."]);
        }
        exit;
    }

    public function obtenerTicketShow() {
        header('Content-Type: application/json');
    
        if (!isset($_GET['id'])) {
            echo json_encode(["status" => "error", "message" => "ID de ticket no proporcionado."]);
            exit;
        }
    
        $ticket = $this->ticketModel->obtenerTicketPorIdShow($_GET['id']);
    
        if ($ticket) {
            echo json_encode(["status" => "success", "data" => $ticket]);
        } else {
            echo json_encode(["status" => "error", "message" => "Ticket no encontrado."]);
        }
        exit;
    }

    public function actualizarTicket() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultado = $this->ticketModel->actualizarTicket($_POST, $_FILES);
            echo json_encode(["status" => $resultado ? "success" : "error"]);
        }
    }


    public function obtenerClientes() {
        header('Content-Type: application/json');
    
        $clientes = $this->ticketModel->obtenerClientes();
        echo json_encode(["status" => "success", "data" => $clientes]);
    }
    
    public function obtenerProductos() {
        header('Content-Type: application/json');
    
        $productos = $this->ticketModel->obtenerProductos();
        echo json_encode(["status" => "success", "data" => $productos]);
    }
    
    public function obtenerUsuarios() {
        header('Content-Type: application/json');
    
        $usuarios = $this->ticketModel->obtenerUsuarios();
        echo json_encode(["status" => "success", "data" => $usuarios]);
    }
    
    public function obtenerEstados() {
        header('Content-Type: application/json');
    
        $estados = $this->ticketModel->obtenerEstados();
        echo json_encode(["status" => "success", "data" => $estados]);
    }
    
    public function obtenerCategorias() {
        header('Content-Type: application/json');
    
        $categorias = $this->ticketModel->obtenerCategorias();
        echo json_encode(["status" => "success", "data" => $categorias]);
    }
    

    public function eliminarTicket() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
            $ticketId = $_GET['id'];
            $resultado = $this->ticketModel->eliminarTicket($ticketId);
            echo json_encode($resultado);
        }
    }


    public function obtenerComentarios() {
        header('Content-Type: application/json');

        if (!isset($_GET['ticket_id'])) {
            echo json_encode(["status" => "error", "message" => "ID de ticket no proporcionado."]);
            exit;
        }

        $ticket_id = $_GET['ticket_id'];

        try {
            $stmt = $GLOBALS['conn']->prepare("SELECT ct.Comentario, u.Nombre AS Usuario, CONVERT(VARCHAR, ct.Fecha, 120) AS FechaCreacion FROM comentarios_tickets ct JOIN Usuarios u ON ct.UsuarioID = u.ID WHERE ct.TicketID = ? ORDER BY ct.Fecha DESC");
            $stmt->execute([$ticket_id]);
            $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(["status" => "success", "data" => $comentarios]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
        exit;
    }

    public function guardarComentario() {
        session_start();
        header('Content-Type: application/json');

        if (!isset($_POST['ticket_id'], $_POST['comentario']) || empty($_SESSION['usuario_id'])) {
            echo json_encode(["status" => "error", "message" => "Datos incompletos o usuario no autenticado."]);
            exit;
        }

        $ticket_id = $_POST['ticket_id'];
        $comentario = $_POST['comentario'];
        $usuario_id = $_SESSION['usuario_id'];

        try {
            $stmt = $GLOBALS['conn']->prepare("INSERT INTO comentarios_tickets (TicketID, UsuarioID, Comentario) VALUES (?, ?, ?)");
            $stmt->execute([$ticket_id, $usuario_id, $comentario]);
            echo json_encode(["status" => "success"]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
        exit;
    }

    public function eliminarMultiplesTickets() {
        header('Content-Type: application/json');
    
        // Validar que la petición sea POST y que venga JSON con los IDs
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                "status" => "error",
                "message" => "Método no permitido"
            ]);
            return;
        }
    
        // Obtener datos JSON
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['ids']) || !is_array($data['ids'])) {
            echo json_encode([
                "status" => "error",
                "message" => "IDs inválidos o no enviados"
            ]);
            return;
        }
    
        $ids = $data['ids'];
    
        // Ejecutar desde el modelo
        $resultado = $this->ticketModel->eliminarMultiplesTickets($ids);
        echo json_encode($resultado);
    }
    

    
    public function obtenerTicketsPorCliente() {
        header('Content-Type: application/json');
    
        if (!isset($_GET['cliente_id'])) {
            echo json_encode(["status" => "error", "message" => "ID del cliente no proporcionado."]);
            exit;
        }
    
        $clienteID = intval($_GET['cliente_id']);
        $tickets = $this->ticketModel->obtenerTicketsPorCliente($clienteID);
    
        echo json_encode(["status" => "success", "data" => $tickets]);
        exit;
    }
    
    
    
    
    
}
    

// ✅ Determinar qué función ejecutar según el parámetro `action`
if (isset($_GET['action'])) {
    $controller = new TicketController();
    
    if ($_GET['action'] == 'obtenerTickets') {
        $controller->obtenerTickets();
    } elseif ($_GET['action'] == 'procesarTicket') {
        $controller->procesarTicket();
    }elseif ($_GET['action'] == 'buscarTickets') {
        $controller->buscarTickets();
    }elseif ($_GET['action'] == 'buscarClientes') {
        $controller->buscarClientes();
    }elseif ($_GET['action'] == 'obtenerTicket') {
        $controller->obtenerTicket();
    }elseif ($_GET['action'] == 'actualizarTicket') {
        $controller->actualizarTicket();
    }elseif ($_GET['action'] == 'obtenerCategorias') {
        $controller->obtenerCategorias();
    }elseif ($_GET['action'] == 'obtenerEstados') {
        $controller->obtenerEstados();
    }elseif ($_GET['action'] == 'obtenerUsuarios') {
        $controller->obtenerUsuarios();
    }elseif ($_GET['action'] == 'obtenerClientes') {
        $controller->obtenerClientes();
    }elseif ($_GET['action'] == 'obtenerProductos') {
        $controller->obtenerProductos();
    }elseif ($_GET['action'] == 'eliminarTicket') {
        $controller->eliminarTicket();
    }elseif ($_GET['action'] == 'obtenerTicketShow') {
        $controller->obtenerTicketShow();
    }elseif ($_GET['action'] == 'obtenerComentarios') {
        $controller->obtenerComentarios();
    }elseif ($_GET['action'] == 'guardarComentario') {
        $controller->guardarComentario();
    }elseif ($_GET['action'] == 'eliminarMultiplesTickets') {
        $controller->eliminarMultiplesTickets();
    } elseif ($_GET['action'] == 'obtenerDocumentosPorTicket') {
        $controller->obtenerDocumentosPorTicket();
    } elseif ($_GET['action'] == 'eliminarDocumento') {
        $controller->eliminarDocumento();
    } elseif ($_GET['action'] == 'obtenerTicketsPorCliente') {
        $controller->obtenerTicketsPorCliente();
    }    
}
?>