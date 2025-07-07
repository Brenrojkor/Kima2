<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : "KIMA"; ?></title>
    <!-- Cargar CSS -->
    <link href="/Kima/public/assets/css/style.bundle.css" rel="stylesheet">
    <link href="/Kima/public/assets/css/custom.css" rel="stylesheet">
    <link rel="icon" href="/Kima/public/assets/media/logos/ticket-de-soporte.png" type="image/svg+xml">
</head>

<body id="kt_app_body" class="app-default">
    <div id="kt_app_root" class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid">
            <!-- Sidebar -->
            <?php include 'layouts/sidebar.php'; ?>

            <!-- Contenido Principal -->
            <div id="kt_app_content" class="flex-column flex-row-fluid" style="margin-left: 250px; padding: 20px;">
                <?php
                if (isset($content)) {
                    include $content;
                } else {

                }
                ?>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</html>