<?php
require_once __DIR__ . "/../../config/database.php"; // Incluir la conexión

class ClientesModel {
    private $conn;

    public function __construct() {
        global $conn; // Usar la variable $conn definida en database.php
        $this->conn = $conn;
    }

    public function getAllClientes() {
        $stmt = $this->conn->prepare("SELECT 
            c.id, c.nombre, c.empresa, c.telefono, c.direccion, c.fecha_creacion, c.email, e.nombre_estado AS estado
        FROM clientes c
        LEFT JOIN estados_clientes e ON c.estado_id = e.id
        ORDER BY c.id DESC");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEstados() {
        $stmt = $this->conn->prepare("SELECT id, nombre_estado FROM estados_clientes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCliente($nombre, $email, $estado_id, $empresa, $cedula, $telefono, $direccion) {
        try {
            // Validar si ya existe un cliente con el mismo correo o teléfono
            $stmtCheck = $this->conn->prepare("SELECT COUNT(*) FROM clientes WHERE email = ? OR telefono = ?");
            $stmtCheck->execute([$email, $telefono]);
            $existe = $stmtCheck->fetchColumn();
    
            if ($existe > 0) {
                return [
                    "status" => "error",
                    "message" => "Ya existe un cliente con ese correo o teléfono."
                ];
            }
    
            // Insertar nuevo cliente
            $stmtInsert = $this->conn->prepare("INSERT INTO clientes (nombre, email, estado_id, empresa, cedula, telefono, direccion, fecha_creacion) 
                                                VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE())");
    
            $stmtInsert->execute([$nombre, $email, $estado_id, $empresa, $cedula, $telefono, $direccion]);
    
            return [
                "status" => "success",
                "message" => "Cliente creado correctamente."
            ];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "Error al crear el cliente: " . $e->getMessage()
            ];
        }
    }
    
    

    public function updateCliente($id, $nombre, $email, $estado_id, $empresa, $cedula, $telefono, $direccion) {
        try {
            // Validar si ya existe otro cliente con el mismo correo o teléfono
            $stmtCheck = $this->conn->prepare("SELECT COUNT(*) FROM clientes WHERE (email = ? OR telefono = ?) AND id != ?");
            $stmtCheck->execute([$email, $telefono, $id]);
            $existe = $stmtCheck->fetchColumn();
    
            if ($existe > 0) {
                return [
                    "status" => "error",
                    "message" => "Ya existe otro cliente con ese correo o teléfono."
                ];
            }
    
            // Ejecutar actualización
            $stmt = $this->conn->prepare("UPDATE clientes 
                SET nombre = ?, email = ?, estado_id = ?, empresa = ?, cedula = ?, telefono = ?, direccion = ? 
                WHERE id = ?");
            $stmt->execute([$nombre, $email, $estado_id, $empresa, $cedula, $telefono, $direccion, $id]);
    
            return [
                "status" => "success",
                "message" => "Cliente actualizado correctamente."
            ];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "Error al actualizar el cliente: " . $e->getMessage()
            ];
        }
    }
    
    


    public function getClientesFiltrados($filtros = []) {
        $sql = "SELECT 
                    c.id, c.nombre, c.empresa, c.telefono, c.direccion, c.fecha_creacion, c.email, 
                    e.nombre_estado AS estado
                FROM clientes c
                LEFT JOIN estados_clientes e ON c.estado_id = e.id
                WHERE 1=1";
    
        if (!empty($filtros['nombre'])) {
            $sql .= " AND c.nombre LIKE :nombre";
        }
        if (!empty($filtros['email'])) {
            $sql .= " AND c.email LIKE :email";
        }
        if (!empty($filtros['empresa'])) {
            $sql .= " AND c.empresa LIKE :empresa";
        }
        if (!empty($filtros['estado'])) {
            $sql .= " AND e.nombre_estado = :estado";
        }
    
        $sql .= " ORDER BY c.id DESC";
    
        $stmt = $this->conn->prepare($sql);
    
        if (!empty($filtros['nombre'])) {
            $stmt->bindValue(':nombre', '%' . $filtros['nombre'] . '%', PDO::PARAM_STR);
        }
        if (!empty($filtros['email'])) {
            $stmt->bindValue(':email', '%' . $filtros['email'] . '%', PDO::PARAM_STR);
        }
        if (!empty($filtros['empresa'])) {
            $stmt->bindValue(':empresa', '%' . $filtros['empresa'] . '%', PDO::PARAM_STR);
        }
        if (!empty($filtros['estado'])) {
            $stmt->bindValue(':estado', $filtros['estado'], PDO::PARAM_STR);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getClienteById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteClienteById($id) {
        try {
            // 1. Verificar si el cliente tiene tickets asociados
            $stmtTickets = $this->conn->prepare("SELECT COUNT(*) FROM Tickets WHERE ClienteID = :id");
            $stmtTickets->execute([":id" => $id]);
            $cantidadTickets = $stmtTickets->fetchColumn();
    
            // 2. Verificar si el cliente tiene cotizaciones asociadas
            $stmtCots = $this->conn->prepare("SELECT COUNT(*) FROM cotizaciones WHERE cliente_id = :id");
            $stmtCots->execute([":id" => $id]);
            $cantidadCotizaciones = $stmtCots->fetchColumn();
    
            if ($cantidadTickets > 0 || $cantidadCotizaciones > 0) {
                return [
                    "status" => "error",
                    "message" => "❌ No se puede eliminar el cliente porque tiene tickets o cotizaciones asociadas."
                ];
            }
    
            // 3. Eliminar el cliente
            $query = "DELETE FROM clientes WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
    
            return [
                "status" => "success",
                "message" => "✅ Cliente eliminado correctamente."
            ];
    
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "❌ Error al eliminar el cliente: " . $e->getMessage()
            ];
        }
    }
    
    
    
    
    
}

?>