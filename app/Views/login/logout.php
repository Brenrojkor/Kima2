<?php
session_start();
session_destroy();
header("Location: /Kima/app/Views/login/login.php");
exit();
?>
