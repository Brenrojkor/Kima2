<?php
header('Content-Type: application/json');

$uploadDir = __DIR__ . '/../../public/uploads/';

// Crear carpeta si no existe
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Validar archivo y ticket_id
if (!empty($_FILES['file']) && isset($_POST['ticket_id']) && is_numeric($_POST['ticket_id'])) {
    $file = $_FILES['file'];
    $ticketId = intval($_POST['ticket_id']);

    // Obtener extensión y limpiar nombre base
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $nombreBase = pathinfo($file['name'], PATHINFO_FILENAME);
    $nombreLimpio = preg_replace('/[^a-zA-Z0-9_-]/', '', $nombreBase);

    // Generar nombre único
    $timestamp = time();
    $filename = "ticket-{$ticketId}_{$timestamp}_{$nombreLimpio}.{$extension}";
    $destination = $uploadDir . $filename;

    // Mover el archivo
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        echo json_encode([
            "status" => "success",
            "filename" => $filename,
            "ruta" => "/Kima/public/uploads/" . $filename
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "❌ Error al guardar el archivo en el servidor."
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "❌ No se recibió un archivo válido o ticket_id."
    ]);
}
