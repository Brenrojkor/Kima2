<?php
// Configuración de la base de datos
$serverName = "127.0.0.1";
$database = "Kima";
$username = "kima";
$password = "Inicio01";

try {
    // Crear la conexión con SQL Server
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión a la base de datos: " . $e->getMessage());
}
?>
