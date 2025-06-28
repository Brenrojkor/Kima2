<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: /Kima/Kima2/app/Views/login/login.php"); // Redirige si no está logueado
    exit();
}

$idUsuario = $_SESSION['usuario_id'] ?? null;

$darkmode = $_SESSION['darkmode'] ?? 0;

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../" />
    <title>KIMA</title>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="canonical" href="http://preview.keenthemes.comlayouts/dark-sidebar.html" />
    <link rel="shortcut icon" href="/Kima/Kima2/public/assets/media/logos/ticket-de-soporte.png" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="/Kima/Kima2/public/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
        type="text/css" />
    <link href="/Kima/Kima2/public/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="/Kima/Kima2/public/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/Kima/Kima2/public/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/Kima/Kima2/public/assets/css/custom.css" rel="stylesheet" type="text/css" />

    <style>
    .app-header {
        background-color: <?php echo $darkmode ? '#0d0e12': 'white';
        ?> !important;
    }

    body {
        background-color: <?php echo $darkmode ? '#0d0e12': 'white';
        ?> !important;
    }

    .page-heading {
        color: <?php echo $darkmode ? '#fff': '#071437';
        ?> !important;
    }

    h1 {
        color: <?php echo $darkmode ? '#fff': '#071437';
        ?> !important;
    }
    </Style>
    <!--end::Global Stylesheets Bundle-->
    <script>
    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="user-box">
            <div class="notification-icon position-relative me-4" style="cursor: pointer;">
                <i class="fa-solid fa-bell fs-2"></i>
                <span id="noti-count"
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    0
                </span>

                <!-- Dropdown de notificaciones -->
                <div id="noti-dropdown" class="dropdown-menu p-3 shadow rounded-3"
                    style="min-width: 320px; display: none; z-index: 1050;">
                    <strong>🔔 Últimas notificaciones:</strong>
                    <ul id="noti-list" class="list-unstyled mt-2 mb-3"></ul>

                    <hr class="my-2">
                    <div class="text-center">
                        <a href="#" id="ver-historial" class="text-primary fw-semibold" style="cursor: pointer;">
                            🔁 Ver Historial
                        </a>
                    </div>
                </div>
            </div>


            <span>Bienvenido,
                <?php
$imagenPerfil = isset($_SESSION['ImagenPerfil']) && !empty($_SESSION['ImagenPerfil']) 
    ? '/Kima/Kima2/uploads/usuarios/' . htmlspecialchars($_SESSION['ImagenPerfil']) 
    : '/Kima/Kima2/public/assets/media/cuenta.png';
?>

                <img src="<?= $imagenPerfil ?>" alt="Foto de perfil"
                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: contain;">




                <a
                    href="/Kima/Kima2/app/Views/usuarios_perfil.php?id=<?= $idUsuario ?>"><?php echo htmlspecialchars($_SESSION['nombre']); ?></a>
            </span>
            <a href="#" class="logout-btn" id="btnLogout">
                <i class="fa-solid fa-right-from-bracket"></i> Salir
            </a>
        </div>
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header" data-kt-sticky="true"
                data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
                data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
                <!--begin::Header container-->
                <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
                    id="kt_app_header_container">
                    <!--begin::Sidebar mobile toggle-->
                    <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px"
                            id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <!--end::Sidebar mobile toggle-->
                    <!--begin::Mobile logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="index.html" class="d-lg-none">
                            <img alt="Logo" src="/Kima/Kima2/public/assets/media/logos/logo_kima_v1.png" class="h-40px" />
                        </a>
                    </div>
                    <!--end::Mobile logo-->
                    <!--begin::Header wrapper-->
                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
                        id="kt_app_header_wrapper">
                        <!--begin::Menu wrapper-->
                        <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                            data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                            data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                            data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                            data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                            data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
                                id="kt_app_header_menu" data-kt-menu="true">
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="bottom-start"
                                    class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <div class="menu-item me-0 me-lg-2">
                                        <a href="/Kima/Kima2/public/index.php" class="menu-link">
                                            <span class="menu-title">Inicio</span>
                                        </a>
                                    </div>

                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="bottom-start"
                                    class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <div class="menu-item me-0 me-lg-2">
                                        <a href="/Kima/Kima2/app/Views/Comunicados.php" class="menu-link">
                                            <span class="menu-title">Comunicados</span>
                                        </a>
                                    </div>

                                    <!--end:Menu link-->
                                </div>

                                <!--end:Menu link-->

                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="bottom-start"
                                    class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <div class="menu-item me-0 me-lg-2">
                                        <a href="/Kima/Kima2/app/Views/Contactos.php" class="menu-link">
                                            <span class="menu-title">Contactos</span>
                                        </a>
                                    </div>

                                    <!--end:Menu link-->
                                </div>
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="bottom-start"
                                    class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <div class="menu-item me-0 me-lg-2">
                                        <a href="/Kima/Kima2/app/Views/clientes.php" class="menu-link">
                                            <span class="menu-title">Clientes</span>
                                        </a>
                                    </div>
                                    <!--end:Menu link-->
                                </div>
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="bottom-start"
                                    class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <div class="menu-item me-0 me-lg-2">
                                        <a href="/Kima/Kima2/app/Views/Tickets.php" class="menu-link" a>
                                            <span class="menu-title">Tickets</span>

                                            <a>
                                    </div>
                                    <!--end:Menu link-->
                                </div>
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="bottom-start"
                                    class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu item-->
                                    <div class="menu-item me-0 me-lg-2">
                                        <a href="/Kima/Kima2/app/Views/Cotizacion.php" class="menu-link">
                                            <span class="menu-title">Cotización</span>
                                        </a>
                                    </div>
                                    <!--end:Menu item-->

                                </div>
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="bottom-start"
                                    class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu item-->
                                    <div class="menu-item me-0 me-lg-2">
                                        <a href="/Kima/Kima2/app/Views/Tarifario.php" class="menu-link">
                                            <span class="menu-title">Tarifario</span>
                                        </a>
                                    </div>
                                    <!--end:Menu item-->

                                </div>
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="bottom-start"
                                    class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <div class="menu-item me-0 me-lg-2">
                                        <a href="/Kima/Kima2/app/Views/Requisitos.php" class="menu-link">
                                            <span class="menu-title">Requisitos</span>
                                        </a>
                                    </div>
                                    <!--end:Menu link-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--begin::Wrapper-->
                <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                    <!--begin::Sidebar-->
                    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
                        data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
                        data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start"
                        data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                        <!--begin::Logo-->
                        <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                            <a href="/Kima/public/index.php">
                                <img alt="Logo" src="/Kima/Kima2/public/assets/media/logos/logo_kima_v1.png"
                                    class="h-40px app-sidebar-logo-default" />
                                <img alt="Logo" src="/Kima/Kima2/public/assets/media/logos/logo_kima_v1.png"
                                    class="h-20px app-sidebar-logo-default" />
                            </a>
                        </div>
                        <!--end::Logo-->

                        <!--begin::Wrapper-->
                        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                            <!--begin::Sidebar-->
                            <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
                                data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
                                data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
                                data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                                <!--begin::Logo-->
                                <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                                    <!--begin::Logo image-->
                                    <a href="/Kima/Kima2/public/index.php">
                                        <img alt="Logo" src="/Kima/Kima2/public/assets/media/logos/logo_kima_v1.png"
                                            class="h-40px app-sidebar-logo-default" />
                                        <img alt="Logo" src="/Kima/Kima2/public/assets/media/logos/logo_kima_v1.png"
                                            class="h-20px app-sidebar-logo-minimize" />
                                    </a>

                                    <!--end::Logo image-->
                                    <!--begin::Sidebar toggle-->
                                    <!--begin::Minimized sidebar setup:
            if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") { 
                1. "/Kima/src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
                2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
                3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
                4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
            }
        -->
                                    <div id="kt_app_sidebar_toggle"
                                        class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                                        data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                                        data-kt-toggle-name="app-sidebar-minimize">
                                        <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <!--end::Sidebar toggle-->
                                </div>
                                <!--end::Logo-->
                                <!--begin::sidebar menu-->
                                <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
                                    <!--begin::Menu wrapper-->
                                    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                                        <!--begin::Scroll wrapper-->
                                        <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3"
                                            data-kt-scroll="true" data-kt-scroll-activate="true"
                                            data-kt-scroll-height="auto"
                                            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                                            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                                            data-kt-scroll-save-state="true">
                                            <!--begin::Menu-->
                                            <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                                                id="#kt_app_sidebar_menu" data-kt-menu="true"
                                                data-kt-menu-expand="false">
                                                <!--begin:Menu item-->
                                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">

                                                    <!-- Opción: Inicio -->
                                                    <div class="menu-item mb-5">
                                                        <a href="/Kima/Kima2/public/index.php" class="menu-link">
                                                            <span class="menu-icon">
                                                                <i class="fas fa-home fs-2"></i>
                                                            </span>
                                                            <span id="menu_inicio" class="menu-title">Inicio</span>
                                                        </a>
                                                    </div>

                                                    <!-- Opción: Comunicados -->
                                                    <div class="menu-item mb-5">
                                                        <a href="/Kima/Kima2/app/Views/comunicados.php" class="menu-link">
                                                            <span class="menu-icon">
                                                                <i class="fas fa-bell fs-2"></i>
                                                            </span>
                                                            <span id="menu_comunicados"
                                                                class="menu-title">Comunicados</span>
                                                        </a>
                                                    </div>

                                                    <!-- Opción: Contactos -->
                                                    <div class="menu-item mb-5">
                                                        <a href="/Kima/Kima2/app/Views/contactos.php" class="menu-link">
                                                            <span class="menu-icon">
                                                                <i class="fas fa-address-book fs-2"></i>
                                                            </span>
                                                            <span id="menu_contactos"
                                                                class="menu-title">Contactos</span>
                                                        </a>
                                                    </div>

                                                    <!-- Opción: Clientes -->
                                                    <div class="menu-item mb-5">
                                                        <a href="/Kima/Kima2/app/Views/ListaClientes.php" class="menu-link">
                                                            <span class="menu-icon">
                                                                <i class="fas fa-users fs-2"></i>
                                                            </span>
                                                            <span id="menu_clientes" class="menu-title">Clientes</span>
                                                        </a>
                                                    </div>

                                                    <!-- Opción: Tickets -->
                                                    <div class="menu-item mb-5">
                                                        <a href="/Kima/Kima2/app/Views/Tickets.php" class="menu-link">
                                                            <span class="menu-icon">
                                                                <i class="fas fa-ticket-alt fs-2"></i>
                                                            </span>
                                                            <span id="menu_tickets" class="menu-title">Tickets</span>
                                                        </a>
                                                    </div>

                                                    <!-- Opción: Cotización -->
                                                    <div class="menu-item mb-5">
                                                        <a href="/Kima/Kima2/app/Views/cotizacion.php" class="menu-link">
                                                            <span class="menu-icon">
                                                                <i class="fas fa-file-invoice fs-2"></i>
                                                            </span>
                                                            <span id="menu_cotizacion"
                                                                class="menu-title">Cotización</span>
                                                        </a>
                                                    </div>

                                                    <!-- Opción: Requisitos -->
                                                    <div class="menu-item mb-5">
                                                        <a href="/Kima/Kima2/app/Views/requisitos.php" class="menu-link">
                                                            <span class="menu-icon">
                                                                <i class="fas fa-list-alt fs-2"></i>
                                                            </span>
                                                            <span id="menu_requisitos"
                                                                class="menu-title">Requisitos</span>
                                                        </a>
                                                    </div>

                                                    <!-- Opción: Tarifario -->
                                                    <div class="menu-item mb-5">
                                                        <a href="/Kima/Kima2/app/Views/tarifario.php" class="menu-link">
                                                            <span class="menu-icon">
                                                                <i class="fas fa-wallet fs-2"></i>
                                                            </span>
                                                            <span id="menu_tarifario"
                                                                class="menu-title">Tarifario</span>
                                                        </a>
                                                    </div>

                                                    <div class="menu-item mb-5">
                                                        <a href="/Kima/Kima2/app/Views/Usuarios.php" class="menu-link">
                                                            <span class="menu-icon">
                                                                <i class="fa-solid fa-user"></i>
                                                            </span>
                                                            <span id="menu_usuario" class="menu-title">Usuarios</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!--end::Menu-->
                                            </div>
                                        </div>

                                        <style>
                                        /* Estilo del switch cuando el modo oscuro está activo */
                                        .form-switch .form-check-input {
                                            --bs-form-switch-bg: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='white'/%3e%3c/svg%3e");
                                            background-color: #343a40 !important;
                                            border-color: #666 !important;
                                        }

                                        /* Estilo del switch cuando está activado */
                                        .form-switch .form-check-input:checked {
                                            background-color: #0d6efd !important;
                                            background-position: right center;
                                        }
                                        </style>

                                        <!--begin::Fixed Dark Mode Switch-->
                                        <div style="position: absolute; bottom: 10px; margin-left: 15px; width: 65%; padding: 10px;"
                                            class="text-center">
                                            <form method="POST"
                                                action="/Kima/Kima2/app/Controllers/UsuariosController.php?action=cambiarTema">
                                                <label class="form-check form-switch menu-link">
                                                    <input class="form-check-input" type="checkbox" name="darkmode"
                                                        value="1" onchange="this.form.submit()"
                                                        <?php echo ($_SESSION['darkmode'] ?? 0) ? 'checked' : ''; ?>>
                                                    <span class="form-check-label">Modo oscuro</span>
                                                </label>
                                            </form>
                                        </div>
                                        <!--end::Fixed Dark Mode Switch-->

                                    </div>
                                    <!--end::Sidebar menu-->
                                </div>
                                <!--end::Sidebar-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
            </div>
        </div>
    </div>

    <!--end::Modal - Invite Friend-->
    <!--end::Modals-->
    <!--begin::Javascript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    var hostUrl = "/Kima/Kima2/public/assets/";

    $(document).ready(function() {
        function cargarNotificaciones() {
            $.get('/Kima/Kima2/app/Controllers/TarifarioController.php?action=obtenerNotificaciones', function(
                response) {
                const res = JSON.parse(response);
                $("#noti-count").text(res.total);

                let html = '';
                if (res.total > 0) {
                    res.data.forEach(noti => {
                        if (noti.Tipo === 'PRODUCTO') {
                            html += `
                        <li class="mb-3 p-3 shadow-sm rounded bg-light border">
                            <div class="fw-bold text-primary">💡 Producto ${noti.ReferenciaID} (${noti.NombreAnterior})</div>
                            <div>${noti.Mensaje}</div>
                            <div class="text-muted small mt-1">${noti.FechaAccion}</div>
                        </li>`;
                        } else if (noti.Tipo === 'CONTACTO') {
                            html += `
                        <li class="mb-3 p-3 shadow-sm rounded bg-light border">
                            <div class="fw-bold text-success">👤 Contacto (${noti.NombreAnterior})</div>
                            <div>${noti.Mensaje}</div>
                            <div class="text-muted small mt-1">${noti.FechaAccion}</div>
                        </li>`;
                        }
                    });
                } else {
                    html = "<li>No hay nuevas notificaciones.</li>";
                }

                $("#noti-list").html(html);
            });
        }


        // Cargar automáticamente al inicio
        cargarNotificaciones();

        // Mostrar dropdown y marcar como leídas
        $(".notification-icon").click(function() {
            $("#noti-dropdown").toggle();

            $.post('/Kima/Kima2/app/Controllers/TarifarioController.php?action=marcarComoLeidas', function() {
                $("#noti-count").text('0');
            });
        });

        // Ver historial (últimos 5, incluso leídas)
        $("#ver-historial").on("click", function(e) {
            e.preventDefault();
            e.stopPropagation(); // ⛔️ Esto es lo que evita que el dropdown se cierre

            $.get('/Kima/Kima2/app/Controllers/TarifarioController.php?action=obtenerHistorialNotificaciones',
                function(response) {
                    const res = JSON.parse(response);
                    let html = '';
                    if (res.status === "success") {
                        res.data.forEach(noti => {
                            html += `
                    <li class="mb-3 p-3 shadow-sm rounded bg-light border">
                        <div class="fw-bold text-primary">💡 Producto ${noti.TipoProductoID} (${noti.NombreAnterior})</div>
                        <div>${noti.Mensaje}</div>
                        <div class="text-muted small mt-1">${noti.FechaAccion}</div>
                    </li>`;
                        });
                    } else {
                        html = "<li>No hay historial disponible.</li>";
                    }
                    $("#noti-list").html(html);
                });
        });

        // Cierra el dropdown si se hace clic fuera de él
        $(document).on("click", function(e) {
            const dropdown = $("#noti-dropdown");
            const icono = $(".notification-icon");

            // Si el clic NO fue dentro del icono ni del dropdown
            if (!icono.is(e.target) && icono.has(e.target).length === 0 &&
                !dropdown.is(e.target) && dropdown.has(e.target).length === 0) {
                dropdown.hide();
            }
        });


    });
    </script>
    <script>
    document.getElementById('btnLogout').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '¿Cerrar sesión?',
            text: "Tu sesión actual se cerrará.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/Kima/Kima2/app/Views/login/logout.php";
            }
        });
    });
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="/Kima/Kima2/public/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/Kima/Kima2/public/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="/Kima/Kima2/public/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="/Kima/Kima2/public/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="/Kima/Kima2/public/assets/js/widgets.bundle.js"></script>
    <script src="/Kima/Kima2/public/assets/js/custom/widgets.js"></script>
    <script src="/Kima/Kima2/public/assets/js/custom/apps/chat/chat.js"></script>
    <script src="/Kima/Kima2/public/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="/Kima/Kima2/public/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="/Kima/Kima2/public/assets/js/custom/utilities/modals/users-search.js"></script>
    <script src="/Kima/Kima2/public/assets/js/components/menu.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>