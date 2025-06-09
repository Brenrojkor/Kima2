<?php
require_once __DIR__ . "/../../config/database.php"; // Incluir la conexión

class ContactosModel {
    private $conn;

    public function __construct() {
        global $conn; // Usar la variable $conn definida en database.php
        $this->conn = $conn;
    }

    public function getAllClientes() {
        $stmt = $this->conn->prepare("SELECT 
            c.id, c.nombre, c.empresa, c.telefono, c.direccion, c.fecha_creacion, c.email, c.servicio, c.especialidad, e.nombre_estado AS estado
        FROM lista_contactos c
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

    public function createCliente($nombre, $email, $estado_id, $empresa, $cedula, $servicio, $especialidad, $telefono, $direccion) {
        try {
            // Validar si ya existe un cliente con el mismo correo o teléfono
            $stmtCheck = $this->conn->prepare("SELECT COUNT(*) FROM lista_contactos WHERE email = ? OR telefono = ?");
            $stmtCheck->execute([$email, $telefono]);
            $existe = $stmtCheck->fetchColumn();
    
            if ($existe > 0) {
                return [
                    "status" => "error",
                    "message" => "Ya existe un contacto con ese correo o teléfono."
                ];
            }
    
            // Insertar nuevo cliente
            $stmtInsert = $this->conn->prepare("INSERT INTO lista_contactos 
                (nombre, email, estado_id, empresa, cedula, telefono, direccion, fecha_creacion, servicio, especialidad) 
                VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE(), ?, ?)");
    
            $stmtInsert->execute([$nombre, $email, $estado_id, $empresa, $cedula, $telefono, $direccion, $servicio, $especialidad]);
    
            // Obtener el ID insertado
            $contactoID = $this->conn->lastInsertId();
    
            session_start();
            // Obtener usuario logueado
            $usuario = $_SESSION['nombre'] ?? 'Sistema'; // Ajustá el nombre de la sesión si usás otro
    
            // Crear mensaje para historial
            $accion = 'INSERTAR';
            $mensaje = "Se agregó un contacto con el nombre de $nombre, creado por $usuario";
    
            // Insertar en el historial
            $stmtHistorial = $this->conn->prepare("INSERT INTO Historial_Contactos 
                (ContactoID, Accion, NombreAnterior, FechaAccion, Usuario, Mensaje, notificaciones_check) 
                VALUES (?, ?, ?, GETDATE(), ?, ?, 0)");
    
            $stmtHistorial->execute([$contactoID, $accion, $nombre, $usuario, $mensaje]);
    
            return [
                "status" => "success",
                "message" => "Contacto creado correctamente."
            ];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "Error al crear el contacto: " . $e->getMessage()
            ];
        }
    }

    public function obtenerHistorialAgrupado() {
        $stmt = $this->conn->prepare("
            SELECT 
                h.ContactoID,
                h.Accion,
                h.NombreAnterior,
                h.Usuario,
                h.FechaAccion
            FROM Historial_Contactos h
            ORDER BY h.ContactoID, h.FechaAccion DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    

    public function updateCliente($id, $nombre, $email, $estado_id, $empresa, $cedula, $telefono, $direccion, $servicio, $especialidad, $usuario) {
        try {
            // Validar si ya existe otro cliente con el mismo correo o teléfono
            $stmtCheck = $this->conn->prepare("SELECT COUNT(*) FROM lista_contactos WHERE (email = ? OR telefono = ?) AND id != ?");
            $stmtCheck->execute([$email, $telefono, $id]);
            $existe = $stmtCheck->fetchColumn();
    
            if ($existe > 0) {
                return [
                    "status" => "error",
                    "message" => "Ya existe otro contacto con ese correo o teléfono."
                ];
            }
    
            // Ejecutar actualización
            $stmt = $this->conn->prepare("UPDATE lista_contactos 
                SET nombre = ?, email = ?, estado_id = ?, empresa = ?, cedula = ?, telefono = ?, direccion = ? , servicio = ?, especialidad = ?
                WHERE id = ?");
            $stmt->execute([$nombre, $email, $estado_id, $empresa, $cedula, $telefono, $direccion, $servicio, $especialidad, $id]);


            // Insertar en Historial_Contactos
            $stmtHistorial = $this->conn->prepare("INSERT INTO Historial_Contactos (ContactoID, Accion, NombreAnterior, FechaAccion, Usuario, Mensaje, notificaciones_check) 
                            VALUES (?, 'ACTUALIZACIÓN', ?, GETDATE(), ?, ?, 0)");

            $mensaje = "Se actualizó el contacto '$nombre', modificado por $usuario";

            $stmtHistorial->execute([$id, $nombre, $usuario, $mensaje]);

    
            return [
                "status" => "success",
                "message" => "Contacto actualizado correctamente."
            ];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "Error al actualizar el contacto: " . $e->getMessage()
            ];
        }
    }
    
    


    public function getClientesFiltrados($filtros = []) {
        $sql = "SELECT 
                    c.id, c.nombre, c.empresa, c.telefono, c.direccion, c.fecha_creacion, c.email, 
                    e.nombre_estado AS estado
                FROM lista_contactos c
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
        $stmt = $this->conn->prepare("SELECT * FROM lista_contactos WHERE id = ?");
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
                    "message" => "❌ No se puede eliminar el contacto porque tiene tickets o cotizaciones asociadas."
                ];
            }
    
            // 3. Eliminar el cliente
            $query = "DELETE FROM lista_contactos WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
    
            return [
                "status" => "success",
                "message" => "✅ Contacto eliminado correctamente."
            ];
    
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "❌ Error al eliminar el Contacto: " . $e->getMessage()
            ];
        }
    }
    
    
    
    
    
}

?>