<?php
$title = "Contactos"; // Título dinámico
include '../../layout.php'; // Asegúrate de que la ruta sea correcta

require_once "../../config/database.php";

$idCliente = $_GET['id'] ?? null;

if (!$idCliente) {
    die("❌ ID del contacto no proporcionado.");
}

try {
    $stmt = $conn->prepare("SELECT * FROM lista_contactos WHERE id = ?");
    $stmt->execute([$idCliente]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        die("❌ Contacto no encontrado.");
    }

} catch (PDOException $e) {
    die("❌ Error: " . $e->getMessage());
}
?>
<html lang="en">

<body>
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main" style="margin-top: 50px !important">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Sidebar-->
                    <div class="w-100 mb-10 d-flex justify-content-center">
                        <!--begin::Card-->
                        <div class="card mb-5 mb-xl-8" style="max-width: 700px; width: 100%;">
                            <!--begin::Card body-->
                            <div class="card-body pt-15">

                                <div class="d-flex justify-content-end mb-3">
                                    <a href="/Kima/app/Views/contactos.php" class="btn btn-light-primary fw-bold">
                                        <i class="fas fa-arrow-left me-2"></i> Volver
                                    </a>
                                </div>

                                <!--begin::Summary-->
                                <div class="d-flex flex-center flex-column mb-5">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-150px symbol-circle mb-7">
                                        <img src="/Kima/public/assets/media/avatars/blank.png" alt="image">
                                    </div>
                                    <!--end::Avatar-->
                                    <a class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">
                                        <?= htmlspecialchars($cliente['nombre']) ?>
                                    </a>
                                    <a class="fs-5 fw-semibold text-muted text-hover-primary mb-6">
                                        <?= htmlspecialchars($cliente['empresa']) ?>
                                    </a>
                                </div>

                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold">Perfil del Contacto</div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>

                                <div class="pb-5 fs-6">
                                    <div class="row">
                                        <!-- Columna 1 -->
                                        <div class="col-md-6">
                                            <div class="fw-bold mt-5">Cédula</div>
                                            <div class="text-gray-600"><?= htmlspecialchars($cliente['cedula']) ?></div>

                                            <div class="fw-bold mt-5">Teléfono</div>
                                            <div class="text-gray-600"><?= htmlspecialchars($cliente['telefono']) ?>
                                            </div>

                                            <div class="fw-bold mt-5">Servicio</div>
                                            <div class="text-gray-600"><?= htmlspecialchars($cliente['servicio']) ?>
                                            </div>
                                        </div>

                                        <!-- Columna 2 -->
                                        <div class="col-md-6">
                                            <div class="fw-bold mt-5">Correo de Contacto</div>
                                            <div class="text-gray-600">
                                                <a href="#" class="text-gray-600 text-hover-primary">
                                                    <?= htmlspecialchars($cliente['email']) ?>
                                                </a>
                                            </div>

                                            <div class="fw-bold mt-5">Dirección</div>
                                            <div class="text-gray-600"><?= htmlspecialchars($cliente['direccion']) ?>
                                            </div>

                                            <div class="fw-bold mt-5">Especialidad</div>
                                            <div class="text-gray-600"><?= htmlspecialchars($cliente['especialidad']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>

                </div>

            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    </div>
    <!--begin::Javascript-->
    <script>
    var hostUrl = "/Kima/public/assets/";
    </script>

    <script>
    const icono = document.querySelector('#menu_clientes').previousElementSibling.querySelector('i');
    const span = document.getElementById('menu_clientes');

    icono.style.color = 'white';
    span.style.color = 'white';
    </script>


    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="/Kima/public/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/Kima/public/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="/Kima/public/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="/Kima/public/assets/js/custom/apps/file-manager/list.js"></script>
    <script src="/Kima/public/assets/js/widgets.bundle.js"></script>
    <script src="/Kima/public/assets/js/custom/widgets.js"></script>
    <script src="/Kima/public/assets/js/custom/apps/chat/chat.js"></script>
    <script src="/Kima/public/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="/Kima/public/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="/Kima/public/assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>