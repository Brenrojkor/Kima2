<?php
require_once "../../../config/database.php"; // Asegúrate de que este archivo tiene la conexión

$nombre = "Yurán Reyes";
$email = "yuran.reyes@gmail.com";
$password = "Yuran1234"; // Contraseña en texto plano
$rol = "Admin";

// Encriptar la contraseña antes de guardarla
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO Usuarios (Nombre, Email, Contraseña, Rol) VALUES (:nombre, :email, :password, :rol)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":nombre" => $nombre,
        ":email" => $email,
        ":password" => $hashed_password,
        ":rol" => $rol
    ]);
    echo "✅ Usuario registrado correctamente.";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
