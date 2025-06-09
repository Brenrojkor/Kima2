<?php
require_once __DIR__ . '/../../config/database.php';

class Ticket {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        if (!$this->conn) {
            die("❌ Error: No hay conexión con la base de datos.");
        }
    }

    
    public function crearTicket($tipoProductoID, $responsableID, $clienteID, $prioridadId, $descripcion, $documentos) {
        try {
            // Validar duplicado
            $verificarQuery = "SELECT COUNT(*) FROM Tickets 
                               WHERE TipoProductoID = :tipoProductoID 
                                 AND ResponsableID = :responsableID 
                                 AND ClienteID = :clienteID 
                                 AND LOWER(CAST(Descripcion AS VARCHAR(MAX))) = :descripcion";
    
            $verificarStmt = $this->conn->prepare($verificarQuery);
            $verificarStmt->execute([
                ":tipoProductoID" => $tipoProductoID,
                ":responsableID" => $responsableID,
                ":clienteID" => $clienteID,
                ":descripcion" => strtolower($descripcion)
            ]);
    
            $existe = $verificarStmt->fetchColumn();
            if ($existe > 0) {
                return ["status" => "error", "message" => "⚠️ Ya existe un ticket con los mismos datos."];
            }
    
            date_default_timezone_set('America/Costa_Rica');
            $FechaCreacion = date("Y-m-d H:i:s");
            $estadoID = 5;
    
            // Crear el ticket
            $query = "INSERT INTO Tickets (TipoProductoID, ResponsableID, ClienteID, EstadoID, FechaCreacion, Descripcion, CategoriaID)
                      VALUES (:tipoProductoID, :responsableID, :clienteID, :estadoID, :FechaCreacion, :descripcion, :prioridadId)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ":tipoProductoID" => $tipoProductoID,
                ":responsableID" => $responsableID,
                ":clienteID" => $clienteID,
                ":estadoID" => $estadoID,
                ":FechaCreacion" => $FechaCreacion,
                ":descripcion" => $descripcion,
                ":prioridadId" => $prioridadId
            ]);
    
            // Obtener el ID del ticket recién creado
            $ticketId = $this->conn->lastInsertId();
    
            // Guardar los documentos en la tabla nueva
            if ($documentos && is_array($documentos)) {
                foreach ($documentos as $archivo) {
                    $ruta = "/uploads/" . $archivo; // Ajustá esto si tu ruta cambia
    
                    $insertDoc = $this->conn->prepare("INSERT INTO documentos_tickets (TicketID, NombreArchivo, RutaArchivo) VALUES (?, ?, ?)");
                    $insertDoc->execute([$ticketId, $archivo, $ruta]);
                }
            }
    
            return ["status" => "success", "message" => "✅ Ticket creado correctamente."];
        } catch (PDOException $e) {
            return ["status" => "error", "message" => "❌ Error SQL: " . $e->getMessage()];
        }
    }


    public function eliminarDocumentoPorId($id) {
        try {
            // Obtener nombre de archivo y ruta para eliminar del sistema de archivos
            $stmt = $this->conn->prepare("SELECT RutaArchivo FROM documentos_tickets WHERE ID = ?");
            $stmt->execute([$id]);
            $archivo = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$archivo) {
                return ["status" => "error", "message" => "❌ Documento no encontrado."];
            }
    
            $rutaArchivo = __DIR__ . '/../../public' . $archivo['RutaArchivo'];
    
            // Eliminar de la base de datos
            $stmtDelete = $this->conn->prepare("DELETE FROM documentos_tickets WHERE ID = ?");
            $stmtDelete->execute([$id]);
    
            // Eliminar del sistema de archivos si existe
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
    
            return ["status" => "success", "message" => "✅ Documento eliminado correctamente."];
        } catch (PDOException $e) {
            return ["status" => "error", "message" => "❌ Error al eliminar documento: " . $e->getMessage()];
        }
    }
    
    
    
    
    
    public function obtenerTickets() {
        try {
            $query = "SELECT 
                        t.ID, 
                        tp.Nombre AS TipoProducto, 
                        u.Nombre AS Responsable, 
                        c.Nombre AS Cliente, 
                        c.empresa As Empresa,
                        e.ID AS EstadoID,
                        ct.Nombre AS Prioridad,
                        e.Estado, 
                        t.FechaCreacion, 
                        t.Descripcion, 
                        t.Documento
                      FROM Tickets t
                      JOIN TiposProductos tp ON t.TipoProductoID = tp.ID
                      JOIN Usuarios u ON t.ResponsableID = u.ID
                      JOIN clientes c ON t.ClienteID = c.ID
                      JOIN EstadosTickets e ON t.EstadoID = e.ID
                      JOIN Categorias ct on t.CategoriaID = ct.ID
                      ORDER BY t.ID DESC";
    
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            return [];
        }
    }


    public function buscarTickets($query) {
        try {
            $sql = "SELECT t.ID, tp.Nombre AS TipoProducto, u.Nombre AS Responsable, c.Nombre AS Cliente, c.empresa As Empresa, ct.Nombre AS Prioridad,
                           e.Estado, t.EstadoID, t.FechaCreacion, t.Descripcion
                    FROM Tickets t
                    INNER JOIN TiposProductos tp ON t.TipoProductoID = tp.ID
                    INNER JOIN Usuarios u ON t.ResponsableID = u.ID
                    INNER JOIN clientes c ON t.ClienteID = c.ID
                    INNER JOIN EstadosTickets e ON t.EstadoID = e.ID
                    INNER JOIN Categorias ct on t.CategoriaID = ct.ID
                    WHERE t.ID LIKE :query1
                       OR tp.Nombre LIKE :query2 
                       OR u.Nombre LIKE :query3 
                       OR c.Nombre LIKE :query4 
                       OR c.empresa LIKE :query5
                       OR e.Estado LIKE :query6 
                       OR t.Descripcion LIKE :query7
                       OR ct.Nombre LIKE :query8
                       ORDER BY t.ID DESC";
    
            $stmt = $this->conn->prepare($sql);
    
            $searchQuery = "%$query%";
            $stmt->bindValue(':query1', $searchQuery, PDO::PARAM_STR);
            $stmt->bindValue(':query2', $searchQuery, PDO::PARAM_STR);
            $stmt->bindValue(':query3', $searchQuery, PDO::PARAM_STR);
            $stmt->bindValue(':query4', $searchQuery, PDO::PARAM_STR);
            $stmt->bindValue(':query5', $searchQuery, PDO::PARAM_STR);
            $stmt->bindValue(':query6', $searchQuery, PDO::PARAM_STR);
            $stmt->bindValue(':query7', $searchQuery, PDO::PARAM_STR);
            $stmt->bindValue(':query8', $searchQuery, PDO::PARAM_STR);
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en SQL: " . $e->getMessage());
            return [];
        }
    }


    public function buscarClientes($search) {
        try {
            $query = "SELECT id, nombre, empresa FROM clientes WHERE nombre LIKE :search OR empresa LIKE :search LIMIT 10";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['search' => "%$search%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }


    public function obtenerTicketPorId($id) {
        try {
            $query = "SELECT * FROM Tickets WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function obtenerTicketPorIdShow($id) {
        try {
            $query = "SELECT 
                        t.ID, 
                        t.FechaCreacion, 
                        t.FechaFin, 
                        t.Descripcion, 
                        tp.Nombre AS TipoProducto,
                        u.Nombre AS Responsable,
                        c.nombre AS Cliente,
                        et.ID AS EstadoID,
                        et.Estado AS Estado,
                        cat.Nombre AS Categoria
                      FROM Tickets t
                      LEFT JOIN TiposProductos tp ON t.TipoProductoID = tp.ID
                      LEFT JOIN Usuarios u ON t.ResponsableID = u.ID
                      LEFT JOIN clientes c ON t.ClienteID = c.id
                      LEFT JOIN EstadosTickets et ON t.EstadoID = et.ID
                      LEFT JOIN Categorias cat ON t.CategoriaID = cat.id
                      WHERE t.ID = :id";
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function obtenerTicketsPorCliente($clienteID) {
        try {
            $query = "SELECT 
                        t.ID, 
                        e.Estado, 
                        t.FechaCreacion,
                        t.EstadoID
                      FROM Tickets t
                      JOIN EstadosTickets e ON t.EstadoID = e.ID
                      WHERE t.ClienteID = :clienteID
                      ORDER BY t.ID DESC";
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':clienteID', $clienteID, PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    


    public function actualizarTicket($data, $files) {
        try {
            // Obtener la fecha actual en Costa Rica (UTC-6)
            date_default_timezone_set('America/Costa_Rica');
            $fechaFin = ($data['estado'] == '3') ? date("Y-m-d H:i:s") : null;
    
            $query = "UPDATE Tickets 
                      SET ClienteID = :cliente, 
                          TipoProductoID = :producto, 
                          ResponsableID = :responsable, 
                          EstadoID = :estado, 
                          Descripcion = :descripcion, 
                          FechaFin = :fecha_fin, 
                          CategoriaID = :categoria 
                      WHERE ID = :id";
    
            $stmt = $this->conn->prepare($query);
            $success = $stmt->execute([
                ":id" => $data['id'],
                ":cliente" => $data['cliente'],
                ":producto" => $data['product'],
                ":responsable" => $data['user'],
                ":estado" => $data['estado'],
                ":descripcion" => $data['description'],
                ":fecha_fin" => $fechaFin, // Si el estado es 3, guarda la fecha actual, si no, guarda NULL
                ":categoria" => $data['categoria']
            ]);
    
            if (!$success) {
                print_r($stmt->errorInfo()); // 🔥 Mostrar errores si hay problemas
            }
    
            return $success;
        } catch (PDOException $e) {
            error_log("❌ Error SQL: " . $e->getMessage());
            return false;
        }
    }
    

    public function obtenerClientes() {
        $query = "SELECT id, nombre, empresa FROM clientes";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerProductos() {
        $query = "SELECT ID, Nombre FROM TiposProductos";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerUsuarios() {
        $query = "SELECT ID, Nombre FROM Usuarios";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerEstados() {
        $query = "SELECT ID, Estado FROM EstadosTickets";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerCategorias() {
        $query = "SELECT id, Nombre FROM Categorias";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function eliminarTicket($id) {
        try {
            // Verificar cantidad de comentarios
            $stmtComentarios = $this->conn->prepare("SELECT COUNT(*) FROM comentarios_tickets WHERE TicketID = :id");
            $stmtComentarios->execute([":id" => $id]);
            $cantidadComentarios = $stmtComentarios->fetchColumn();
    
            // Verificar estado del ticket
            $stmtEstado = $this->conn->prepare("SELECT EstadoID FROM Tickets WHERE ID = :id");
            $stmtEstado->execute([":id" => $id]);
            $estado = $stmtEstado->fetchColumn();
    
            // Validación: solo si está cerrado (3) y tiene comentarios
            if (!($estado == 3 && $cantidadComentarios > 0)) {
                return [
                    "status" => "error",
                    "message" => "Solo se pueden eliminar tickets cerrados que tengan al menos un comentario."
                ];
            }
    
            // Eliminar comentarios primero
            $stmtDeleteComentarios = $this->conn->prepare("DELETE FROM comentarios_tickets WHERE TicketID = :id");
            $stmtDeleteComentarios->execute([":id" => $id]);
    
            // Luego eliminar el ticket
            $stmtDeleteTicket = $this->conn->prepare("DELETE FROM Tickets WHERE ID = :id");
            $stmtDeleteTicket->execute([":id" => $id]);
    
            return ["status" => "success"];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "Error al eliminar el ticket: " . $e->getMessage()
            ];
        }
    }
    
    
    


    public function eliminarMultiplesTickets($ids) {
        try {
            $errores = [];
    
            foreach ($ids as $id) {
                // Verificar estado
                $stmt = $this->conn->prepare("SELECT EstadoID FROM Tickets WHERE ID = ?");
                $stmt->execute([$id]);
                $estado = $stmt->fetchColumn();
    
                // Verificar comentarios
                $stmtComentarios = $this->conn->prepare("SELECT COUNT(*) FROM comentarios_tickets WHERE TicketID = ?");
                $stmtComentarios->execute([$id]);
                $cantidadComentarios = $stmtComentarios->fetchColumn();
    
                // Validación: solo cerrados con comentarios
                if (!($estado == 3 && $cantidadComentarios > 0)) {
                    $errores[] = "Ticket #$id no se puede eliminar (debe estar cerrado y tener comentarios)";
                    continue;
                }
    
               // Antes de eliminar el ticket:
                $stmtDeleteComentarios = $this->conn->prepare("DELETE FROM comentarios_tickets WHERE TicketID = ?");
                $stmtDeleteComentarios->execute([$id]);

                // Luego:
                $stmtDelete = $this->conn->prepare("DELETE FROM Tickets WHERE ID = ?");
                $stmtDelete->execute([$id]);

            }
    
            if (!empty($errores)) {
                return [
                    "status" => "partial",
                    "message" => "Algunos tickets no se eliminaron.",
                    "errores" => $errores
                ];
            }
    
            return ["status" => "success", "message" => "Tickets eliminados correctamente."];
    
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "Error al eliminar múltiples tickets: " . $e->getMessage()
            ];
        }
    }
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
}
?>