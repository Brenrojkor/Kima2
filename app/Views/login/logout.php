<?php
session_start();
session_destroy();
header("Location: /Kima/Kima2/app/Views/login/login.php");
exit();
?>
