<?php
// Configuración de la base de datos
$serverName = "127.0.0.1";
$database = "Kima";
$username = "kima";
$password = "Inicio01";

try {
    // Desactivar la validación del certificado
    $connectionOptions = "sqlsrv:server=$serverName;Database=$database;Encrypt=true;TrustServerCertificate=true";

    // Crear la conexión
    $conn = new PDO($connectionOptions, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión a la base de datos: " . $e->getMessage());
}
?>
