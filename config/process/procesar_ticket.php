<?php
session_start();
require_once "../../config/database.php"; // Asegura que tienes la conexión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    exit();
}

if (!isset($_SESSION['usuario_id'])) {
    die("❌ Error: No hay un usuario logueado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $tipoProductoID = $_POST['product'];
        $responsableID = $_POST['user'];
        $estadoID = $_POST['status'];
        $fechaRealizacion = $_POST['due_date'];
        $descripcion = $_POST['description'];
        $clienteID = $_SESSION['usuario_id']; // ID del usuario logueado

        // Procesar documentos subidos
        $documentos = isset($_POST['documentos']) ? implode(",", $_POST['documentos']) : NULL;

        // Insertar en la tabla Tickets
        $query = "INSERT INTO Tickets (TipoProductoID, ResponsableID, ClienteID, EstadoID, FechaRealizacion, Descripcion, Documento)
                  VALUES (:tipoProductoID, :responsableID, :clienteID, :estadoID, :fechaRealizacion, :descripcion, :documentos)";

        $stmt = $conn->prepare($query);
        $stmt->execute([
            ":tipoProductoID" => $tipoProductoID,
            ":responsableID" => $responsableID,
            ":clienteID" => $clienteID,
            ":estadoID" => $estadoID,
            ":fechaRealizacion" => $fechaRealizacion,
            ":descripcion" => $descripcion,
            ":documentos" => $documentos
        ]);

        echo "✅ Ticket creado correctamente.";
    } catch (PDOException $e) {
        echo "❌ Error al crear el ticket: " . $e->getMessage();
    }
}
?>
