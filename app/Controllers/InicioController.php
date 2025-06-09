<?php
header('Content-Type: application/json');

require_once "../../config/database.php"; // Asegurar la conexión a la base de datos

class InicioController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTicketsByState() {
        try {
            // 🔥 Consulta para contar tickets agrupados por estado
            $sql = "SELECT e.Estado AS category, COUNT(t.ID) AS value 
                    FROM Tickets t
                    INNER JOIN EstadosTickets e ON t.EstadoID = e.ID
                    GROUP BY e.Estado";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(["status" => "success", "data" => $data]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error al obtener datos: " . $e->getMessage()]);
        }
    }

    public function getTicketsByCategory() {
        try {
            // 🔥 Nuevo SELECT para contar categorías de servicio utilizadas en tickets
            $sql = "SELECT cs.Nombre AS category, COUNT(t.ID) AS value 
                    FROM Tickets t
                    INNER JOIN TiposProductos tp ON t.TipoProductoID = tp.ID
                    INNER JOIN Categoria_Serv cs ON tp.id_categoria_serv = cs.ID
                    GROUP BY cs.Nombre
                    ORDER BY value DESC";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode(["status" => "success", "data" => $data]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error al obtener datos: " . $e->getMessage()]);
        }
    }
    

    public function getDelayedTickets() {
        try {
            // 🔥 Consulta SQL para calcular el tiempo de resolución en segundos
            $sql = "SELECT t.ID, t.Descripcion, 
                           DATEDIFF_BIG(SECOND, t.CreadoEn, GETDATE()) AS segundos_en_proceso
                    FROM Tickets t
                    WHERE t.EstadoID IN (2, 4, 5)
                    ORDER BY segundos_en_proceso DESC
                    OFFSET 0 ROWS FETCH NEXT 5 ROWS ONLY"; // Reemplaza `LIMIT` por `OFFSET` para SQL Server
    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Convertir segundos a días, horas y minutos
            foreach ($data as &$ticket) {
                $segundos = (int)$ticket['segundos_en_proceso'];
                $dias = floor($segundos / 86400);
                $horas = floor(($segundos % 86400) / 3600);
                $minutos = floor(($segundos % 3600) / 60);
    
                $ticket['tiempo_proceso'] = "{$dias}d {$horas}h {$minutos}m";
                $ticket['horas_totales'] = round($segundos / 3600, 2); // Horas totales en decimal
            }
    
            echo json_encode(["status" => "success", "data" => $data]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error al obtener datos: " . $e->getMessage()]);
        }
    }

    public function getAverageResponseTime() {
        try {
            // Consulta SQL para obtener la diferencia de tiempo promedio en segundos
            $sql = "SELECT AVG(DATEDIFF_BIG(SECOND, CreadoEn, FechaFin)) AS avg_seconds 
                    FROM Tickets 
                    WHERE EstadoID = 3 AND FechaFin IS NOT NULL";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result && $result['avg_seconds'] !== null) {
                $totalSeconds = (int) $result['avg_seconds'];
                $hours = $totalSeconds / 3600; // Convertir a horas decimales
    
                echo json_encode(["status" => "success", "promedio" => $hours]);
            } else {
                echo json_encode(["status" => "error", "message" => "No hay datos disponibles"]);
            }
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error al obtener datos: " . $e->getMessage()]);
        }
    }

    public function getTicketsClosedByUser() {
        try {
            $sql = "SELECT u.Nombre AS label, COUNT(t.ID) AS value
                    FROM Tickets t
                    INNER JOIN Usuarios u ON t.ResponsableID = u.ID
                    WHERE t.EstadoID = 3
                    GROUP BY u.Nombre
                    ORDER BY value DESC";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Convertir 'value' a entero para evitar problemas en el gráfico
            foreach ($data as &$row) {
                $row["value"] = (int) $row["value"];
            }
    
            echo json_encode(["status" => "success", "data" => $data]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error al obtener datos: " . $e->getMessage()]);
        }
    }

    public function getTicketsPareto() {
        try {
            $sql = "WITH TicketCounts AS (
                        SELECT e.Estado AS category, COUNT(t.ID) AS value
                        FROM Tickets t
                        INNER JOIN EstadosTickets e ON t.EstadoID = e.ID
                        GROUP BY e.Estado
                    ),
                    RankedData AS (
                        SELECT category, value,
                            SUM(value) OVER (ORDER BY value DESC) * 100.0 / SUM(value) OVER () AS cumulativePercentage
                        FROM TicketCounts
                    )
                    SELECT * FROM RankedData ORDER BY value DESC;";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Convertir valores a números
            foreach ($data as &$row) {
                $row["value"] = (int) $row["value"];
                $row["cumulativePercentage"] = (float) $row["cumulativePercentage"];
            }
    
            echo json_encode(["status" => "success", "data" => $data]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error al obtener datos: " . $e->getMessage()]);
        }
    }
    

    public function getTicketsByDateRange() {
        try {
            $filtro = $_GET['filtro'] ?? 'mes';
    
            if ($filtro === 'mes') {
                $desde = date('Y-m-d', strtotime('-30 days'));
            } elseif ($filtro === 'trimestre') {
                $desde = date('Y-m-d', strtotime('-90 days'));
            } else {
                echo json_encode(["status" => "error", "message" => "Filtro no válido"]);
                return;
            }
    
            $sql = "SELECT 
                        t.ID, 
                        t.Descripcion, 
                        t.FechaCreacion, 
                        t.EstadoID, 
                        t.ResponsableID, 
                        t.ClienteID,
                        t.FechaFin,
                        c.Nombre AS ClienteNombre,
                        c.Empresa AS ClienteEmpresa,
                        u.Nombre AS ResponsableNombre,
                        et.Estado AS NombreEstado

                    FROM Tickets t
                    INNER JOIN Clientes c ON t.ClienteID = c.ID
                    INNER JOIN Usuarios u ON t.ResponsableID = u.ID
                    INNER JOIN EstadosTickets et ON t.EstadoID = et.ID
                    WHERE t.FechaFin >= ? and t.EstadoID = '3'";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$desde]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode(["status" => "success", "data" => $data]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error al obtener tickets: " . $e->getMessage()]);
        }
    }    



    public function getTicketsByUser() {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
    
            $usuarioId = $_SESSION['usuario_id'] ?? null;
    
            if (!$usuarioId) {
                echo json_encode(["status" => "error", "message" => "Usuario no autenticado."]);
                return;
            }
    
            $sql = "SELECT 
                        t.ID, 
                        t.Descripcion, 
                        t.FechaCreacion, 
                        t.EstadoID, 
                        t.ResponsableID, 
                        t.ClienteID,
                        c.Nombre AS ClienteNombre,
                        c.Empresa AS ClienteEmpresa,
                        u.Nombre AS ResponsableNombre,
                        et.Estado AS NombreEstado,
                        cs.Nombre AS NombreCategoria
                    FROM Tickets t
                    INNER JOIN Clientes c ON t.ClienteID = c.ID
                    INNER JOIN Usuarios u ON t.ResponsableID = u.ID
                    INNER JOIN EstadosTickets et ON t.EstadoID = et.ID 
                    INNER JOIN TiposProductos cs ON t.TipoProductoID = cs.ID 
                    WHERE t.ResponsableID = ?";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$usuarioId]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode(["status" => "success", "data" => $data]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error al obtener tickets: " . $e->getMessage()]);
        }
    }


    public function getTicketDetalle() {
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            echo json_encode(["status" => "error", "message" => "ID no proporcionado."]);
            return;
        }
    
        try {
            // Consulta principal del ticket
            $sql = "SELECT 
                        t.ID, t.Descripcion, t.FechaCreacion, t.FechaFin,
                        c.Nombre AS ClienteNombre, c.Empresa AS ClienteEmpresa,
                        u.Nombre AS ResponsableNombre,
                        et.Estado AS NombreEstado,
                        cs.Nombre AS NombreCategoria,
                        ct.Nombre AS NombrePrioridad
                    FROM Tickets t
                    INNER JOIN Clientes c ON t.ClienteID = c.ID
                    INNER JOIN Usuarios u ON t.ResponsableID = u.ID
                    INNER JOIN EstadosTickets et ON t.EstadoID = et.ID
                    INNER JOIN Categorias ct ON t.CategoriaID = ct.ID
                    LEFT JOIN TiposProductos tp ON t.TipoProductoID = tp.ID
                    LEFT JOIN Categoria_Serv cs ON tp.id_categoria_serv = cs.ID
                    WHERE t.ID = ?";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$ticket) {
                echo json_encode(["status" => "error", "message" => "Ticket no encontrado."]);
                return;
            }
    
            // 🔥 Obtener comentarios relacionados
            $sqlComentarios = "SELECT 
                                    ct.Comentario, ct.Fecha, u.Nombre AS UsuarioNombre
                              FROM comentarios_tickets ct
                              INNER JOIN Usuarios u ON ct.UsuarioID = u.ID
                              WHERE ct.TicketID = ?
                              ORDER BY ct.Fecha DESC";
    
            $stmtComentarios = $this->conn->prepare($sqlComentarios);
            $stmtComentarios->execute([$id]);
            $comentarios = $stmtComentarios->fetchAll(PDO::FETCH_ASSOC);
    
            // 🔥 Obtener documentos relacionados
        $sqlDocs = "SELECT NombreArchivo, RutaArchivo, FechaSubida 
                    FROM documentos_tickets 
                    WHERE TicketID = ?
                    ORDER BY FechaSubida DESC";

        $stmtDocs = $this->conn->prepare($sqlDocs);
        $stmtDocs->execute([$id]);
        $documentos = $stmtDocs->fetchAll(PDO::FETCH_ASSOC);

        // 📦 Devolver también los documentos
        echo json_encode([
            "status" => "success",
            "data" => [
                "ticket" => $ticket,
                "comentarios" => $comentarios,
                "documentos" => $documentos
            ]
        ]);
    
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error al obtener detalles del ticket: " . $e->getMessage()]);
        }
    }
    
}
    


// ✅ Ejecutar la función si se llama desde AJAX
if (isset($_GET['action']) && $_GET['action'] == "getTicketsByState") {
    require_once "../../config/database.php"; 
    $controller = new InicioController($conn);
    $controller->getTicketsByState();
}elseif ($_GET['action'] == 'getTicketsByCategory') {
    require_once "../../config/database.php"; 
    $controller = new InicioController($conn);
    $controller->getTicketsByCategory();
}elseif ($_GET['action'] == 'getDelayedTickets') {
    require_once "../../config/database.php"; 
    $controller = new InicioController($conn);
    $controller->getDelayedTickets();
}elseif ($_GET['action'] == 'getAverageResponseTime') {
    require_once "../../config/database.php"; 
    $controller = new InicioController($conn);
    $controller->getAverageResponseTime();
}elseif ($_GET['action'] == 'getTicketsClosedByUser') {
    require_once "../../config/database.php"; 
    $controller = new InicioController($conn);
    $controller->getTicketsClosedByUser();
}elseif ($_GET['action'] == 'getTicketsPareto') {
    require_once "../../config/database.php"; 
    $controller = new InicioController($conn);
    $controller->getTicketsPareto();
}elseif ($_GET['action'] == 'getTicketsByDateRange') {
    require_once "../../config/database.php"; 
    $controller = new InicioController($conn);
    $controller->getTicketsByDateRange();
}elseif ($_GET['action'] == 'getTicketsByUser') {
    require_once "../../config/database.php"; 
    $controller = new InicioController($conn);
    $controller->getTicketsByUser();
}elseif ($_GET['action'] == 'getTicketDetalle') {
    require_once "../../config/database.php"; 
    $controller = new InicioController($conn);
    $controller->getTicketDetalle();
}