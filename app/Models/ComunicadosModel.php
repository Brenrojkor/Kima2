<?php
require_once __DIR__ . "/../../config/database.php"; // Conexión a la BD

class ComunicadosModel {
    private $conn;

    public function __construct() {
        global $conn; 
        $this->conn = $conn;
    }

    // 🔹 Obtener todos los archivos y carpetas
    public function obtenerComunicados() {
        $sql = "
            SELECT id, nombre, tamaño, ruta, carpeta_id, 
                   FORMAT(fecha_modificacion, 'dd MMM yyyy, hh:mm tt') AS fecha_modificacion 
            FROM archivos
            ORDER BY fecha_modificacion DESC;
        ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Agregar archivo
    public function agregarArchivo($nombre, $ruta, $tamaño, $carpeta_id = null) {
        $sql = "INSERT INTO archivos (nombre, ruta, tamaño, carpeta_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nombre, $ruta, $tamaño, $carpeta_id]);
    }

    // 🔹 Crear una nueva carpeta
    public function crearCarpeta($nombre) {
        $sql = "INSERT INTO carpetas (nombre) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nombre]);
    }

    // 🔹 Eliminar archivo o carpeta
    public function eliminarComunicado($id, $tipo) {
        if ($tipo === "archivo") {
            // 🔍 Obtener ruta del archivo antes de eliminarlo
            $stmt = $this->conn->prepare("SELECT ruta FROM archivos WHERE id = ?");
            $stmt->execute([$id]);
            $archivo = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($archivo && isset($archivo['ruta'])) {
                // 🔥 Convertir ruta web a ruta física
                $rutaFisica = $_SERVER['DOCUMENT_ROOT'] . $archivo['ruta'];
    
                // 🧹 Eliminar archivo físico si existe
                if (file_exists($rutaFisica)) {
                    unlink($rutaFisica);
                }
            }
    
            // 🗑️ Eliminar de la base de datos
            $stmtDelete = $this->conn->prepare("DELETE FROM archivos WHERE id = ?");
            return $stmtDelete->execute([$id]);
    
        } else if ($tipo === "carpeta") {
            try {
                $this->conn->beginTransaction();
    
                // 🔍 Obtener ruta de la carpeta
                $stmtRuta = $this->conn->prepare("SELECT ruta FROM carpetas WHERE id = ?");
                $stmtRuta->execute([$id]);
                $carpeta = $stmtRuta->fetch(PDO::FETCH_ASSOC);
    
                // 🧹 Eliminar todos los archivos de la carpeta
                if ($carpeta && isset($carpeta['ruta'])) {
                    $rutaFisicaCarpeta = $_SERVER['DOCUMENT_ROOT'] . $carpeta['ruta'];
                    if (is_dir($rutaFisicaCarpeta)) {
                        // Eliminar archivos dentro de la carpeta
                        $archivos = glob($rutaFisicaCarpeta . '*');
                        foreach ($archivos as $archivo) {
                            if (is_file($archivo)) {
                                unlink($archivo);
                            }
                        }
                        // Eliminar carpeta si queda vacía
                        rmdir($rutaFisicaCarpeta);
                    }
                }
    
                // 🔻 Primero eliminar archivos de la carpeta en la DB
                $stmtArchivos = $this->conn->prepare("DELETE FROM archivos WHERE carpeta_id = ?");
                $stmtArchivos->execute([$id]);
    
                // 🔻 Luego eliminar la carpeta
                $stmtCarpeta = $this->conn->prepare("DELETE FROM carpetas WHERE id = ?");
                $stmtCarpeta->execute([$id]);
    
                $this->conn->commit();
                return true;
    
            } catch (PDOException $e) {
                $this->conn->rollBack();
                return false;
            }
        }
    
        return false;
    }
    

    public function obtenerArchivoConCarpeta($idArchivo) {
        $sql = "
            SELECT a.nombre AS archivo_nombre, c.nombre AS carpeta_nombre
            FROM archivos a
            LEFT JOIN carpetas c ON a.carpeta_id = c.id
            WHERE a.id = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArchivo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
    

    // 🔹 Renombrar archivo o carpeta
    public function renombrarComunicado($id, $nuevo_nombre, $tipo) {
        if ($tipo === "archivo") {
            $sql = "UPDATE archivos SET nombre = ? WHERE id = ?";
        } else {
            $sql = "UPDATE carpetas SET nombre = ? WHERE id = ?";
        }
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nuevo_nombre, $id]);
    }

    public function crearCarpetaYObtenerID($nombre) {
        $nombreCarpeta = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $nombre); // Asegura nombre seguro
        $rutaFisica = __DIR__ . "/../../public/uploads_comunicados/{$nombreCarpeta}";
        $rutaPublica = "/Kima/public/uploads_comunicados/{$nombreCarpeta}/";
    
        if (!is_dir($rutaFisica)) {
            mkdir($rutaFisica, 0777, true); // 🔥 Crear físicamente
        }
    
        $sql = "INSERT INTO carpetas (nombre, ruta) OUTPUT INSERTED.ID VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute([$nombre, $rutaPublica])) {
            return $stmt->fetchColumn();
        }
    
        return false;
    }
    

    
public function asociarArchivosACarpeta($archivoIds, $carpetaId)
{
    // Obtener ruta de la carpeta
    $stmtRuta = $this->conn->prepare("SELECT ruta FROM carpetas WHERE id = ?");
    $stmtRuta->execute([$carpetaId]);
    $carpeta = $stmtRuta->fetch(PDO::FETCH_ASSOC);
    $nuevaRuta = $carpeta["ruta"];

    $stmtArchivos = $this->conn->prepare("SELECT id, nombre, ruta FROM archivos WHERE id = ?");
    $stmtUpdate = $this->conn->prepare("UPDATE archivos SET ruta = ?, carpeta_id = ? WHERE id = ?");

    foreach ($archivoIds as $id) {
        // Obtener datos del archivo
        $stmtArchivos->execute([$id]);
        $archivo = $stmtArchivos->fetch(PDO::FETCH_ASSOC);

        // Ruta actual y nueva ruta
        $rutaActual = $_SERVER['DOCUMENT_ROOT'] . $archivo["ruta"];
        $nuevaRutaFisica = $_SERVER['DOCUMENT_ROOT'] . $nuevaRuta . "/" . $archivo["nombre"];
        $nuevaRutaWeb = $nuevaRuta . "/" . $archivo["nombre"];

        // Mover archivo físicamente
        if (file_exists($rutaActual)) {
            rename($rutaActual, $nuevaRutaFisica);
        }

        // Actualizar ruta y carpeta_id en DB
        $stmtUpdate->execute([$nuevaRutaWeb, $carpetaId, $id]);
    }
}


public function moverYAsociarArchivosACarpeta($archivoIds, $carpetaId) {
    $stmtRuta = $this->conn->prepare("SELECT ruta FROM carpetas WHERE id = ?");
    $stmtRuta->execute([$carpetaId]);
    $carpeta = $stmtRuta->fetch(PDO::FETCH_ASSOC);

    if (!$carpeta) return;

    $rutaPublicaNueva = $carpeta["ruta"]; // /Kima/public/uploads_comunicados/NuevaCarpeta/
    $rutaFisicaBase = realpath(__DIR__ . "/../../public"); // 🔥 base física real

    foreach ($archivoIds as $id) {
        $stmtArchivo = $this->conn->prepare("SELECT nombre, ruta FROM archivos WHERE id = ?");
        $stmtArchivo->execute([$id]);
        $archivo = $stmtArchivo->fetch(PDO::FETCH_ASSOC);

        if ($archivo) {
            $nombreArchivo = $archivo["nombre"];

            // 🔹 Ruta física actual (ej: /var/www/html/Kima/public/uploads_comunicados/archivo.pdf)
            $rutaActualFisica = $rutaFisicaBase . str_replace("/Kima/public", "", $archivo["ruta"]);

            // 🔹 Ruta física nueva (ej: /var/www/html/Kima/public/uploads_comunicados/NuevaCarpeta/archivo.pdf)
            $rutaNuevaFisica = $rutaFisicaBase . str_replace("/Kima/public", "", $rutaPublicaNueva) . $nombreArchivo;

            // Crear carpeta si no existe
            $directorioDestino = dirname($rutaNuevaFisica);
            if (!is_dir($directorioDestino)) {
                mkdir($directorioDestino, 0777, true);
            }

            // 🔥 Mover el archivo si existe
            if (file_exists($rutaActualFisica)) {
                rename($rutaActualFisica, $rutaNuevaFisica);
            }

            // Actualizar DB con nueva ruta
            $nuevaRutaDB = $rutaPublicaNueva . $nombreArchivo;
            $stmtUpdate = $this->conn->prepare("UPDATE archivos SET carpeta_id = ?, ruta = ? WHERE id = ?");
            $stmtUpdate->execute([$carpetaId, $nuevaRutaDB, $id]);
        }
    }
}




public function obtenerRutaCarpetaPorID($carpetaId) {
    $stmt = $this->conn->prepare("SELECT ruta FROM carpetas WHERE id = ?");
    $stmt->execute([$carpetaId]);
    $carpeta = $stmt->fetch(PDO::FETCH_ASSOC);
    return $carpeta ? $carpeta["ruta"] : false;
}



    public function obtenerTodosLosArchivos() {
        $sql = "SELECT id, nombre FROM archivos WHERE carpeta_id IS NULL ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); // 🔥 ESTA LÍNEA ES CLAVE
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCarpetasConArchivos() {
        $carpetas = $this->conn->query("SELECT id, nombre, fecha_creacion, ruta FROM carpetas ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($carpetas as &$carpeta) {
            $stmt = $this->conn->prepare("SELECT nombre, ruta FROM archivos WHERE carpeta_id = ?");
            $stmt->execute([$carpeta['id']]);
            $carpeta['archivos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        return $carpetas;
    }
    
    
    
    
}
?>