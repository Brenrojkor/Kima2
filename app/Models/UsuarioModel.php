<?php
require_once __DIR__ . "/../../config/database.php"; // Incluir la conexión

class UsuarioModel {
    private $conn;

    public function __construct() {
        global $conn; // Usar la variable $conn definida en database.php
        $this->conn = $conn;
    }

    public function getAllUsuarios() {
        $stmt = $this->conn->prepare("SELECT 
            c.ID, c.Nombre, c.Email, c.Rol, e.nombre_estado AS estado
        FROM Usuarios c
        LEFT JOIN estados_clientes e ON c.estado_id = e.id
        ORDER BY c.ID DESC");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEstados() {
        $stmt = $this->conn->prepare("SELECT id, nombre_estado FROM estados_clientes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUsuario($nombre, $email, $estado_id, $password, $rol) {
        // Validación: no permitir guardar si el estado es "inactivo"
        if ($estado_id == 2) {
            return [
                "status" => "error",
                "message" => "❌ No se pueden guardar usuarios con estado inactivo."
            ];
        }
    
        // Encriptar la contraseña con BCRYPT
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    
        // Preparar consulta
        $stmt = $this->conn->prepare("INSERT INTO Usuarios (Nombre, Email, estado_id, Contraseña, Rol) 
                                      VALUES (?, ?, ?, ?, ?)");
    
        if ($stmt->execute([$nombre, $email, $estado_id, $passwordHash, $rol])) {
            return [
                "status" => "success",
                "message" => "✅ Usuario guardado correctamente."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "❌ Error al guardar el usuario."
            ];
        }
    }
    

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    

    public function updateUsuario($id, $nombre, $email, $rol, $estado_id, $password = null) {
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE Usuarios SET Nombre = ?, Email = ?, Contraseña = ?, Rol = ?, estado_id = ? WHERE id = ?";
            $params = [$nombre, $email, $password_hash, $rol, $estado_id, $id];
        } else {
            $sql = "UPDATE Usuarios SET Nombre = ?, Email = ?, Rol = ?, estado_id = ? WHERE id = ?";
            $params = [$nombre, $email, $rol, $estado_id, $id];
        }
    
        $query = $this->conn->prepare($sql);
        return $query->execute($params);
    }

    public function deleteUserById($id) {
        $query = "DELETE FROM Usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    public function actualizarFotoUsuario($id, $nombreArchivo) {
        $sql = "UPDATE Usuarios SET ImagenPerfil = ? WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nombreArchivo, $id]);
    }
    



    public function actualizarTemaUsuario($usuarioId, $darkmode) {

        $sql = "UPDATE Usuarios SET darkmode = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$darkmode, $usuarioId]);
    }

    
    
    
}

?>