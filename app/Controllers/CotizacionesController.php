<?php
require_once __DIR__ . "/../Models/CotizacionesModel.php";

class CotizacionesController {
    private $model;

    public function __construct() {
        $this->model = new CotizacionesModel();
    }
    
   
    public function buscarClientes() {
        if (isset($_POST['query'])) {
            $busqueda = $_POST['query'];
            $clientes = $this->model->buscarClientes($busqueda);
            echo json_encode($clientes);
        } else {
            echo json_encode(["status" => "error", "message" => "Parámetro no proporcionado"]);
        }
    }

    public function buscarProductos() {
        if (isset($_POST['query'])) {
            $busqueda = $_POST['query'];
            $productos = $this->model->buscarProductos($busqueda);
            echo json_encode($productos);
        } else {
            echo json_encode(["status" => "error", "message" => "Parámetro no proporcionado"]);
        }
    }

    public function guardarCotizacion() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cliente_id = $_POST["cliente_id"];
            $subtotal = $_POST["subtotal"];
            $iva = $_POST["iva"];
            $total = $_POST["total"];
            $productos = json_decode($_POST["productos"], true); // Convertir JSON a array

            // Guardar la cotización y obtener el ID generado
            $cotizacion_id = $this->model->guardarCotizacion($cliente_id, $subtotal, $iva, $total);

            if ($cotizacion_id) {
                // Guardar los productos en detalle_cotizacion
                foreach ($productos as $producto) {
                    $this->model->guardarDetalleCotizacion(
                        $cotizacion_id,
                        $producto["id"],
                        $producto["cantidad"],
                        $producto["precio"],
                        $producto["subtotal"]
                    );
                }

                echo json_encode(["status" => "success", "message" => "Cotización guardada correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al guardar la cotización."]);
            }
        }
    }

    public function listarCotizaciones() {
        $cotizaciones = $this->model->obtenerCotizaciones();
        echo json_encode($cotizaciones);
    }

    public function obtenerCotizacion() {
        $id = $_GET["id"] ?? null;
    
        if (!$id) {
            echo json_encode(["status" => "error", "message" => "ID no proporcionado."]);
            return;
        }
    
        $cotizacion = $this->model->obtenerCotizacionPorId($id);
        $productos = $this->model->obtenerDetalleCotizacion($id);
    
        echo json_encode([
            "status" => "success",
            "cotizacion" => $cotizacion,
            "productos" => $productos
        ]);
    }

    public function actualizarCotizacion() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cotizacion_id = $_POST["cotizacion_id"];
            $cliente_id = $_POST["cliente_id"];
            $subtotal = $_POST["subtotal"];
            $iva = $_POST["iva"];
            $total = $_POST["total"];
            $productos = json_decode($_POST["productos"], true);
    
            $exito = $this->model->actualizarCotizacionConDetalles($cotizacion_id, $cliente_id, $subtotal, $iva, $total, $productos);
    
            if ($exito) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al actualizar cotización."]);
            }
        }
    }


    public function eliminarCotizacion() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
            $id = $_POST["id"];
            $resultado = $this->model->eliminarCotizacionPorId($id);
    
            if ($resultado) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "No se pudo eliminar."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Parámetro faltante."]);
        }
    }


    public function descargarPDF() {
        $id = $_GET["id"] ?? null;
    
        if (!$id) {
            die("ID no proporcionado");
        }
    
        $cotizacion = $this->model->obtenerCotizacionPorId($id);
        $productos = $this->model->obtenerDetalleCotizacion($id);
    
        if (!$cotizacion) {
            die("Cotización no encontrada.");
        }
    
        ob_start();
        include __DIR__ . "/../Views/pdf/cotizacion_pdf_template.php";
        $html = ob_get_clean();
    
        require_once __DIR__ . '/../../vendor/autoload.php';
        $dompdf = new Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Cotizacion_{$id}.pdf", ["Attachment" => false]); // true para descargar directamente
    }
    
    public function obtenerPorCliente() {
        header('Content-Type: application/json');
    
        $clienteId = $_GET['cliente_id'] ?? null;
    
        if (!$clienteId) {
            echo json_encode(["status" => "error", "message" => "Cliente no especificado"]);
            return;
        }
    
        $data = $this->model->obtenerPorCliente($clienteId);
        echo json_encode(["status" => "success", "data" => $data]);
    }
    
    
    
    
    
}

// 🔥 Manejo de rutas (MVC)
$action = $_GET["action"] ?? "index";
error_log("Acción recibida: $action"); // Registrar acción en logs

$controller = new CotizacionesController();

// ✅ Verificar si la acción es válida antes de ejecutarla
if (method_exists($controller, $action)) {
    $controller->$action();
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "Acción no válida."]);
    exit();
}
?>