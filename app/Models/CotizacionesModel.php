<?php
require_once __DIR__ . "/../../config/database.php"; // Incluir la conexión

class CotizacionesModel {
    private $conn;

    public function __construct() {
        global $conn; // Usar la variable $conn definida en database.php
        $this->conn = $conn;
    }
   
  
    public function buscarClientes($busqueda) {
        $sql = "SELECT * FROM clientes WHERE nombre LIKE ? OR empresa LIKE ?";
        $query = $this->conn->prepare($sql);
        $param = "%$busqueda%";
        $query->execute([$param, $param]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarProductos($busqueda) {
        $sql = "SELECT * FROM TiposProductos WHERE nombre LIKE ?";
        $query = $this->conn->prepare($sql);
        $param = "%$busqueda%";
        $query->execute([$param]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

       // Guardar cotización en la base de datos
       public function guardarCotizacion($cliente_id, $subtotal, $iva, $total) {
        try {
            $sql = "INSERT INTO cotizaciones (cliente_id, subtotal, iva, total, fecha_creacion) 
                    VALUES (?, ?, ?, ?, GETDATE())";
            $query = $this->conn->prepare($sql);
            $query->execute([$cliente_id, $subtotal, $iva, $total]);

            return $this->conn->lastInsertId(); // Retornar el ID de la cotización insertada
        } catch (PDOException $e) {
            return false;
        }
    }

    // Guardar detalle de cotización
    public function guardarDetalleCotizacion($cotizacion_id, $producto_id, $cantidad, $precio, $subtotal) {
        try {
            $sql = "INSERT INTO detalle_cotizacion (cotizacion_id, producto_id, cantidad, precio, subtotal) 
                    VALUES (?, ?, ?, ?, ?)";
            $query = $this->conn->prepare($sql);
            $query->execute([$cotizacion_id, $producto_id, $cantidad, $precio, $subtotal]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    public function obtenerCotizaciones() {
        $sql = "SELECT c.id, CONCAT(cl.nombre, ' - ', cl.empresa) AS cliente, cl.id as cliente_id, cl.email AS cliente_email, c.subtotal, c.iva, c.total,FORMAT(c.total, 'N2') AS total, FORMAT(c.fecha_creacion, 'yyyy-MM-dd') AS fecha_creacion
                FROM cotizaciones c
                INNER JOIN clientes cl ON c.cliente_id = cl.id
                ORDER BY c.fecha_creacion DESC";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenerCotizacionPorId($id) {
        $sql = "SELECT 
                    c.*, 
                    cl.nombre AS cliente_nombre, 
                    cl.empresa AS cliente_empresa,
                    cl.email AS cliente_email
                FROM cotizaciones c
                INNER JOIN clientes cl ON c.cliente_id = cl.id
                WHERE c.id = ?
                ORDER BY c.fecha_creacion DESC";
                
        $query = $this->conn->prepare($sql);
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    
    public function obtenerDetalleCotizacion($cotizacion_id) {
        $sql = "SELECT dc.*, tp.nombre AS nombre_producto 
                FROM detalle_cotizacion dc
                INNER JOIN TiposProductos tp ON dc.producto_id = tp.ID
                WHERE dc.cotizacion_id = ?";
        $query = $this->conn->prepare($sql);
        $query->execute([$cotizacion_id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    public function actualizarCotizacionConDetalles($cotizacion_id, $cliente_id, $subtotal, $iva, $total, $productos) {
        try {
            // Iniciar transacción
            $this->conn->beginTransaction();
    
            // Actualizar cabecera
            $sql = "UPDATE cotizaciones SET cliente_id = ?, subtotal = ?, iva = ?, total = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$cliente_id, $subtotal, $iva, $total, $cotizacion_id]);
    
            // Eliminar detalles anteriores
            $sqlDelete = "DELETE FROM detalle_cotizacion WHERE cotizacion_id = ?";
            $this->conn->prepare($sqlDelete)->execute([$cotizacion_id]);
    
            // Insertar nuevos detalles
            foreach ($productos as $p) {
                $this->guardarDetalleCotizacion(
                    $cotizacion_id,
                    $p["id"],
                    $p["cantidad"],
                    $p["precio"],
                    $p["subtotal"]
                );
            }
    
            // Confirmar cambios
            $this->conn->commit();
            return true;
    
        } catch (PDOException $e) {
            $this->conn->rollBack(); // Deshacer cambios si algo falla
            error_log("Error al actualizar cotización: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarCotizacionPorId($id) {
        try {
            $this->conn->beginTransaction();
    
            // Eliminar detalles primero
            $sql1 = "DELETE FROM detalle_cotizacion WHERE cotizacion_id = ?";
            $this->conn->prepare($sql1)->execute([$id]);
    
            // Eliminar cotización
            $sql2 = "DELETE FROM cotizaciones WHERE id = ?";
            $this->conn->prepare($sql2)->execute([$id]);
    
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error al eliminar cotización: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPorCliente($clienteId) {
        $stmt = $this->conn->prepare("SELECT id, fecha_creacion, total FROM cotizaciones WHERE cliente_id = ?");
        $stmt->execute([$clienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
    
    
    
    
}

?>