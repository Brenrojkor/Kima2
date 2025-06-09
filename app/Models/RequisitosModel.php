<?php
require_once __DIR__ . "/../../config/database.php"; // Incluir la conexión

class RequisitosModel {
    private $conn;

    public function __construct() {
        global $conn; // Usar la variable $conn definida en database.php
        $this->conn = $conn;
    }

    // ✅ Obtener todos los requisitos
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT 
    r.ID,
    r.Descripcion,
	r.CategoriaID,
    c.Nombre AS Categoria,
	r.PrioridadID,
    p.Nombre AS Prioridad,
    r.Fecha
    FROM Requisitos r
    INNER JOIN CategoriasRequisitos c ON r.CategoriaID = c.ID
    INNER JOIN Categorias p ON r.PrioridadID = p.ID
    ORDER BY r.Fecha DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Insertar un nuevo requisito
    public function create($descripcion, $categoria, $prioridad) {
        $stmt = $this->conn->prepare("INSERT INTO Requisitos (Descripcion, CategoriaID, PrioridadID, Fecha) 
                                      VALUES (?, ?, ?, GETDATE())");
        return $stmt->execute([$descripcion, $categoria, $prioridad]);
    }
    

    // 📌 Actualizar un requisito
    public function update($id, $descripcion, $categoria, $prioridad) {
        $stmt = $this->conn->prepare("UPDATE Requisitos SET Descripcion = ?, CategoriaID = ?, PrioridadID = ? WHERE ID = ?");
        return $stmt->execute([$descripcion, $categoria, $prioridad, $id]);
    }
    

    // 📌 Eliminar un requisito
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM Requisitos WHERE ID = ?");
        return $stmt->execute([$id]);
    }

    // ✅ Obtener categorías de requisitos
    public function getCategorias() {
        $stmt = $this->conn->prepare("SELECT ID, Nombre FROM CategoriasRequisitos ORDER BY Nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Obtener prioridades
    public function getPrioridades() {
        $stmt = $this->conn->prepare("SELECT ID, Nombre FROM Categorias ORDER BY Nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>