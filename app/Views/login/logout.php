<?php
session_start();
session_destroy();
header("Location: /app/Views/login/login.php");
exit();
?>
