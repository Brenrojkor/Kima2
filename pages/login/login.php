<?php
session_start();
require_once "/config/database.php"; // Conexión con SQL Server

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Preparar y ejecutar la consulta
    $query = "SELECT ID, Nombre, Email, Contraseña, Rol FROM Usuarios WHERE Email = :email";
    $stmt = $conn->prepare($query);
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verificar la contraseña
        if (password_verify($password, $user['Contraseña'])) {
            // Establecer variables de sesión
            $_SESSION['usuario_id'] = $user['ID'];
            $_SESSION['nombre'] = $user['Nombre'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['rol'] = $user['Rol'];
            $_SESSION['darkmode'] = $user['darkmode'];

            // Redirigir al usuario a index.php
            header('Location: /Kima/index.php');
            exit();
        } else {
            $error = "❌ Contraseña incorrecta.";
        }
    } else {
        $error = "❌ Correo electrónico no encontrado.";
    }
}

$title = "Iniciar Sesión"; // Título dinámico
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="/assets/css/style.bundle.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex flex-column flex-root vh-100">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid align-items-center justify-content-center">
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10 text-center">
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                    <form class="form w-100" method="POST" action="/pages/login/login.php">
                        <div class="text-center mb-11">
                            <h1 class="text-gray-900 fw-bolder mb-3">Iniciar Sesión</h1>
                            <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                        </div>
                        <div class="fv-row mb-8">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="fv-row mb-3">
                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="d-grid mb-10">
                            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <a href="" class="link-primary">Regístrate aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
