<?php
$title = "Cartera de contactos"; // Título dinámico
include '../../layout.php'; // Asegúrate de que la ruta sea correcta


require_once "../../config/database.php";

try {
    $query = "SELECT servicio, especialidad FROM lista_contactos";
    $stmt = $conn->query($query);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Extraer solo los valores únicos
    $servicios = array_unique(array_column($resultados, 'servicio'));
    $especialidades = array_unique(array_column($resultados, 'especialidad'));

} catch (PDOException $e) {
    die("Error al obtener servicios y especialidades: " . $e->getMessage());
}

?>
<html lang="en">

<style>
.card-title {
    flex-wrap: wrap;
    gap: 1rem;
}
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Cargar CSS -->
    <link href="/Kima/public/assets/css/style.bundle.css" rel="stylesheet">


</head>

<body>
    <!--begin::Content-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

        <div class="d-flex flex-column flex-column-fluid">

            <!-- Modal para Editar Cliente -->
            <div class="modal fade" id="kt_modal_edit_customer" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-1000px">
                    <div class="modal-content">
                        <form id="kt_modal_edit_customer_form">
                            <div class="modal-header">
                                <h2 class="fw-bold">Editar Contacto</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body py-10 px-lg-17">
                                <div class="scroll-y me-n7 pe-7">
                                    <input type="hidden" name="id_cliente" id="edit_id_cliente">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Nombre</label>
                                                <input type="text" class="form-control form-control-solid" name="nombre"
                                                    id="edit_nombre" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Correo</label>
                                                <input type="email" class="form-control form-control-solid" name="email"
                                                    id="edit_email" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fv-row mb-7">
                                                <label class="fs-6 fw-semibold mb-2">Empresa</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    name="empresa" id="edit_empresa">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Cédula</label>
                                                <input type="text" class="form-control form-control-solid" name="cedula"
                                                    id="edit_cedula">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Servicio</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    name="servicio" id="edit_servicio">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Especialidad</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    name="especialidad" id="edit_especialidad">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">Dirección</label>
                                        <textarea class="form-control form-control-solid" name="direccion"
                                            id="edit_direccion" rows="4"></textarea>
                                    </div>

                                    <div class="fv-row mb-7">
                                        <label class="required fs-6 fw-semibold mb-2">Teléfono</label>
                                        <input type="number" class="form-control form-control-solid" name="telefono"
                                            id="edit_telefono">
                                    </div>

                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">Estado</label>
                                        <select class="form-control form-control-solid" name="estado" id="edit_estado">
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer flex-center">
                                <button type="reset" class="btn btn-light me-3"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Guardar Cambios</span>
                                    <span class="indicator-progress">Por favor espere...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <!--begin::Toolbar container-->
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container"
                    class="app-container container-xxl d-flex justify-content-between align-items-center">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fs-2 me-2"></i>
                            <h1 class="page-heading  fw-bold fs-3 my-0">Contactos</h1>
                        </div>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="index.html" class="text-muted text-hover-primary">Inicio</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Contactos</li>
                        </ul>
                    </div>
                    <!--end::Page title-->

                    <!-- 👉 Acciones a la derecha -->
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success" id="kt_export_contactos">
                            <i class="fa fa-file-excel me-1"></i> Exportar
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_add_customer">
                            <i class="fa fa-plus me-1"></i> Añadir
                        </button>
                        <button type="button" class="btn btn-sm fw-bold btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#modalHistorial">
                            <i class="fa-solid fa-clock-rotate-left me-2"></i>Historial
                        </button>
                    </div>
                </div>
                <!--end::Toolbar container-->

                <!--end::Toolbar container-->
            </div>



            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->

                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Card-->
                    <div class="card card-flush">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <div class="row w-100 align-items-center">
                                <!-- Filtros (3 columnas de 3) -->
                                <div class="col-md-9 d-flex flex-wrap gap-2">
                                    <div class="col-md-3">
                                        <div class="position-relative">
                                            <i class="fa-solid fa-magnifying-glass position-absolute ms-3 mt-2"></i>
                                            <input type="text" id="searchContact"
                                                class="form-control form-control-solid ps-10"
                                                placeholder="Buscar Contacto" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="filtro-servicio" class="form-select form-select-solid w-100">
                                            <option value="">Todos los servicios</option>
                                            <?php foreach ($servicios as $servicio): ?>
                                            <option value="<?= htmlspecialchars($servicio); ?>">
                                                <?= htmlspecialchars($servicio); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="filtro-especialidad" class="form-select form-select-solid w-100">
                                            <option value="">Todas las especialidades</option>
                                            <?php foreach ($especialidades as $especialidad): ?>
                                            <option value="<?= htmlspecialchars($especialidad); ?>">
                                                <?= htmlspecialchars($especialidad); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Botón alineado completamente a la derecha -->
                                <!-- Botón a la derecha -->
                                <div class="col-md-3 mb-2 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-danger" id="delete_varios">
                                        <i class="fas fa-trash"></i> Eliminar seleccionados
                                    </button>

                                </div>



                            </div>
                        </div>

                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <div id="kt_customers_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                                <div id="" class="table-responsive">
                                    <div id="kt_customers_table_wrapper"
                                        class="dt-container dt-bootstrap5 dt-empty-footer">
                                        <div id="" class="table-responsive">
                                            <div id="kt_customers_table_wrapper"
                                                class="dt-container dt-bootstrap5 dt-empty-footer">
                                                <div id="" class="table-responsive">
                                                    <div id="kt_customers_table_wrapper"
                                                        class="dt-container dt-bootstrap5 dt-empty-footer">
                                                        <div id="" class="table-responsive">
                                                            <div id="kt_customers_table_wrapper"
                                                                class="dt-container dt-bootstrap5 dt-empty-footer">
                                                                <div id="" class="table-responsive">
                                                                    <div id="kt_customers_table_wrapper"
                                                                        class="dt-container dt-bootstrap5 dt-empty-footer">
                                                                        <div id="" class="table-responsive">
                                                                            <table
                                                                                class="table align-middle table-row-dashed fs-6 gy-5 dataTable"
                                                                                id="kt_customers_table"
                                                                                style="width: 100%;">


                                                                                <thead>
                                                                                    <tr
                                                                                        class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                                                        <th class="w-10px pe-2 dt-orderable-none"
                                                                                            data-dt-column="0"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="
																
																	
																
															"><span class="dt-column-title">
                                                                                                <div
                                                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="checkbox"
                                                                                                        data-kt-check="true"
                                                                                                        data-kt-check-target="#kt_customers_table .form-check-input"
                                                                                                        value="1">
                                                                                                </div>
                                                                                            </span><span
                                                                                                class="dt-column-order"></span>
                                                                                        </th>
                                                                                        <th class="min-w-20px dt-orderable-asc dt-orderable-desc"
                                                                                            data-dt-column="1"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Customer Name: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort"
                                                                                            tabindex="0"><span
                                                                                                class="dt-column-title"
                                                                                                role="button">ID</span><span
                                                                                                class="dt-column-order"></span>
                                                                                        </th>
                                                                                        <th class="min-w-125px dt-orderable-asc dt-orderable-desc"
                                                                                            data-dt-column="1"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Customer Name: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort"
                                                                                            tabindex="0"><span
                                                                                                class="dt-column-title"
                                                                                                role="button">Nombre
                                                                                            </span><span
                                                                                                class="dt-column-order"></span>
                                                                                        </th>
                                                                                        <th class="min-w-125px dt-orderable-asc dt-orderable-desc"
                                                                                            data-dt-column="2"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Email: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort"
                                                                                            tabindex="0"><span
                                                                                                class="dt-column-title"
                                                                                                role="button">Correo</span><span
                                                                                                class="dt-column-order"></span>
                                                                                        </th>
                                                                                        <th class="min-w-125px dt-orderable-asc dt-orderable-desc"
                                                                                            data-dt-column="2"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Email: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort"
                                                                                            tabindex="0"><span
                                                                                                class="dt-column-title"
                                                                                                role="button">Empresa</span><span
                                                                                                class="dt-column-order"></span>
                                                                                        </th>
                                                                                        <th class="min-w-125px dt-orderable-asc dt-orderable-desc"
                                                                                            data-dt-column="2"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Email: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort"
                                                                                            tabindex="0"><span
                                                                                                class="dt-column-title"
                                                                                                role="button">Servicio</span><span
                                                                                                class="dt-column-order"></span>
                                                                                        </th>
                                                                                        <th class="min-w-125px dt-orderable-asc dt-orderable-desc"
                                                                                            data-dt-column="2"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Email: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort"
                                                                                            tabindex="0"><span
                                                                                                class="dt-column-title"
                                                                                                role="button">Especialidad</span><span
                                                                                                class="dt-column-order"></span>
                                                                                        </th>

                                                                                        <th class="min-w-125px dt-orderable-asc dt-orderable-desc"
                                                                                            data-dt-column="5"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Created Date: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort"
                                                                                            tabindex="0"><span
                                                                                                class="dt-column-title"
                                                                                                role="button">Telefono</span><span
                                                                                                class="dt-column-order"></span>
                                                                                        </th>
                                                                                        <th class="min-w-125px dt-orderable-asc dt-orderable-desc"
                                                                                            data-dt-column="5"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Created Date: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort"
                                                                                            tabindex="0"><span
                                                                                                class="dt-column-title"
                                                                                                role="button">Acciones</span><span
                                                                                                class="dt-column-order"></span>
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="fw-semibold text-gray-600"
                                                                                    id="clientesTableBody">



                                                                                </tbody>
                                                                                <!--end::Table body-->
                                                                                <tfoot></tfoot>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Modals-->
                    <!--begin::Modal - Customers - Add-->
                    <!-- Modal para Agregar Cliente -->
                    <div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-1000px">
                            <div class="modal-content">
                                <form id="kt_modal_add_customer_form">
                                    <div class="modal-header">
                                        <h2 class="fw-bold">Añadir Contacto</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body py-10 px-lg-17">
                                        <div class="scroll-y me-n7 pe-7">
                                            <!-- Primera fila: Nombre y Correo -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="required fs-6 fw-semibold mb-2">Nombre</label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            name="nombre" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="required fs-6 fw-semibold mb-2">Correo</label>
                                                        <input type="email" class="form-control form-control-solid"
                                                            name="email" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Segunda fila: Empresa y Cédula -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="fs-6 fw-semibold mb-2">Empresa</label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            name="empresa">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="required fs-6 fw-semibold mb-2">Cédula</label>
                                                        <input type="number" class="form-control form-control-solid"
                                                            name="cedula">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="required fs-6 fw-semibold mb-2">Servicio</label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            name="servicio">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="fv-row mb-7">
                                                        <label
                                                            class="required fs-6 fw-semibold mb-2">Especialidad</label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            name="especialidad">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Dirección -->
                                            <div class="fv-row mb-7">
                                                <label class="fs-6 fw-semibold mb-2">Dirección</label>
                                                <textarea class="form-control form-control-solid" name="direccion"
                                                    rows="4" style="width: 100%;"></textarea>
                                            </div>

                                            <!-- Teléfono -->
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Teléfono</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    name="telefono">
                                            </div>

                                            <!-- Estado -->
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Estado</label>
                                                <select class="form-control form-control-solid" name="estado" required>
                                                    <option value="1">Activo</option>
                                                    <option value="2">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer flex-center">
                                        <button type="reset" class="btn btn-light me-3"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Guardar Contacto</span>
                                            <span class="indicator-progress">Por favor espere...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalHistorial" tabindex="-1" aria-labelledby="modalHistorialLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalHistorialLabel">Historial de contactos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-body">
                                        <div class="accordion" id="tablaHistorial">
                                            <!-- Aquí se insertarán los acordeones dinámicamente -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal - Customers - Add-->
                    <!--begin::Modal - Adjust Balance-->
                    <div class="modal fade" id="kt_customers_export_modal" tabindex="-1" style="display: none;"
                        aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bold">Exportar Clientes</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div id="kt_customers_export_close"
                                        class="btn btn-icon btn-sm btn-active-icon-primary">
                                        <i class="ki-duotone ki-cross fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                    <!--begin::Form-->
                                    <form id="kt_customers_export_form"
                                        class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->

                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="fv-row mb-5">
                                                <label class="fs-5 fw-semibold form-label mb-5">Seleccionar el tipo de
                                                    formato:</label>
                                                <select id="format" name="format" class="form-select form-select-solid"
                                                    aria-label="Select export format">
                                                    <option value="excel">Excel</option>
                                                    <option value="pdf">PDF</option>
                                                    <option value="csv">CSV</option>
                                                    <option value="zip">ZIP</option>
                                                </select>
                                            </div><span class="select2 select2-container select2-container--bootstrap5"
                                                dir="ltr" data-select2-id="select2-data-16-qpgi"
                                                style="width: 100%;"><span class="selection"></span><span
                                                    class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div
                                            class="fv-row mb-10 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-semibold form-label mb-5">Seleccionar Fecha:</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid flatpickr-input"
                                                placeholder="Pick a date" name="date" type="hidden" value=""><input
                                                class="form-control form-control-solid flatpickr-input form-control input"
                                                placeholder="Pick a date" tabindex="0" type="text" readonly="readonly">

                                            <!--end::Input-->
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Row-->

                                        <!--end::Row-->
                                        <!--begin::Actions-->
                                        <div class="text-center">
                                            <button type="reset" id="kt_customers_export_cancel"
                                                class="btn btn-light me-3">Descartar</button>
                                            <button type="submit" id="kt_customers_export_submit"
                                                class="btn btn-primary">
                                                <span class="indicator-label">Confirmar</span>
                                                <span class="indicator-progress">Por favor espere...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Modal body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>
                    <!--end::Modal - New Card-->
                    <!--end::Modals-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
    </div>
    <!--begin::Javascript-->
    <!-- SCRIPT PARA MANEJAR EL FORMULARIO -->
    <script>
    $(document).ready(function() {

        $('#modalHistorial').on('shown.bs.modal', function() {
            $.ajax({
                url: "/Kima/app/Controllers/ContactosController.php?action=getHistorialJson",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        const historial = response.data;

                        const agrupado = historial.reduce((acc, item) => {
                            if (!acc[item.ContactoID]) acc[item
                                .ContactoID] = [];
                            acc[item.ContactoID].push(item);
                            return acc;
                        }, {});

                        let html = '';

                        Object.entries(agrupado).forEach(([tipoID, items]) => {
                            const sectionId = `section-${tipoID}`;
                            const nombre = items[0]?.NombreAnterior ?? 'Sin nombre';

                            html += `
                        <div class="custom-accordion mb-3 border rounded">
                            <div class="custom-accordion-header p-3 bg-light fw-bold cursor-pointer" data-target="#${sectionId}">
                                Historial contacto: ${tipoID} - ${nombre} <span class="float-end">+</span>
                            </div>
                            <div id="${sectionId}" class="custom-accordion-body p-0" style="display: none;">
                                <table class="table table-bordered table-striped m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Acción</th>
                                            <th>Nombre</th>
                                            <th>Usuario</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${items.map(item => `
                                            <tr>
                                                <td>${item.Accion}</td>
                                                <td>${item.NombreAnterior ?? '-'}</td>
                                                <td>${item.Usuario}</td>
                                                <td>${item.FechaAccion}</td>
                                            </tr>
                                        `).join("")}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                        });

                        $('#tablaHistorial').html(html);
                    } else {
                        $('#tablaHistorial').html(
                            `<div class="alert alert-warning text-center">${response.message}</div>`
                        );
                    }
                },
                error: function() {
                    $('#tablaHistorial').html(
                        `<div class="alert alert-danger text-center">Error al cargar el historial.</div>`
                    );
                }
            });
        });

        $(document).on('click', '.custom-accordion-header', function() {
            const target = $(this).data('target');
            const body = $(target);

            body.slideToggle(200); // Mostrar/ocultar

            const icon = $(this).find('span');
            icon.text(icon.text() === '+' ? '−' : '+');
        });
        // Capturar el evento click del botón Editar
        $(document).on("click", ".btn-edit", function() {
            let clienteID = $(this).data("id"); // Obtener ID del cliente

            // Petición AJAX para obtener la información del cliente
            $.ajax({
                url: "/Kima/app/Controllers/ContactosController.php?action=getClienteById",
                type: "GET",
                data: {
                    id: clienteID
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        let cliente = response.data;

                        // Cargar los datos en el modal de edición
                        $("#edit_id_cliente").val(cliente.id);
                        $("#edit_nombre").val(cliente.nombre);
                        $("#edit_email").val(cliente.email);
                        $("#edit_cedula").val(cliente.cedula || '');
                        $("#edit_empresa").val(cliente.empresa || '');
                        $("#edit_telefono").val(cliente.telefono || '');
                        $("#edit_direccion").val(cliente.direccion || '');
                        $("#edit_servicio").val(cliente.servicio || '');
                        $("#edit_especialidad").val(cliente.especialidad || '');
                        $("#edit_estado").val(cliente.estado_id);

                        // Abrir el modal de edición
                        $("#kt_modal_edit_customer").modal("show");
                    } else {
                        alert("❌ Error: " + response.message);
                    }
                },
                error: function() {
                    alert("❌ Error en la solicitud AJAX.");
                }
            });
        });

        $("#kt_modal_edit_customer_form").off("submit").on("submit", function(event) {
            event.preventDefault();
            console.log("Enviando solicitud AJAX para actualizar...");

            let formData = $(this).serialize(); // Serializa los datos del formulario

            console.log('formdata', formData);
            $.ajax({
                type: "POST",
                url: "/Kima/app/Controllers/ContactosController.php?action=updateCliente",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert("✅ Contacto actualizado correctamente.");
                        $("#kt_modal_edit_customer").modal("hide");
                        $("#kt_modal_edit_customer").on("hidden.bs.modal", function() {
                            $(".modal-backdrop").remove(); // Elimina el fondo gris
                        });

                        // Recargar los datos de la tabla SIN recargar la página
                        setTimeout(function() {
                            cargarClientes();
                        }, 500);

                    } else {
                        alert("❌ Error: " + response.message);
                    }
                },
                error: function() {
                    alert("❌ Error en la solicitud AJAX.");
                }
            });
        });

        $("#kt_modal_add_customer_form").submit(function(event) {
            event.preventDefault(); // Evita que la página se recargue

            let formData = {
                nombre: $("input[name='nombre']").val(),
                email: $("input[name='email']").val(),
                empresa: $("input[name='empresa']").val(),
                cedula: $("input[name='cedula']").val(),
                servicio: $("input[name='servicio']").val(),
                especialidad: $("input[name='especialidad']").val(),
                direccion: $("input[name='direccion']").val(),
                telefono: $("input[name='telefono']").val(),
                estado: $("select[name='estado']").val()
            };

            $.ajax({
                type: "POST",
                url: "/Kima/app/Controllers/ContactosController.php?action=create",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert("✅ Contacto agregado correctamente.");
                        $("#kt_modal_add_customer").modal("hide");
                        location.reload(); // Recargar la tabla
                    } else {
                        alert("❌ " + response.message);
                    }
                },
                error: function() {
                    alert("❌ Error en la solicitud AJAX.");
                }
            });
        });

        $(document).on("click", ".btn-delete", function() {
            let clienteID = $(this).data("id"); // Obtener el ID del cliente

            if (!confirm(
                    "¿Estás seguro de que deseas eliminar este contacto? Esta acción no se puede deshacer."
                )) {
                return;
            }

            // Enviar la petición AJAX para eliminar el cliente
            $.ajax({
                url: "/Kima/app/Controllers/ContactosController.php?action=deleteCliente",
                type: "POST",
                data: {
                    id: clienteID
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert("✅ Contacto eliminado correctamente.");
                        cargarClientes(); // Recargar la tabla sin recargar la página
                    } else {
                        alert("❌ Error: " + response.message);
                    }
                },
                error: function() {
                    alert("❌ Error en la solicitud AJAX.");
                }
            });
        });

        let table; // Variable global

        function cargarClientes() {
            $.ajax({
                url: "/Kima/app/Controllers/ContactosController.php?action=getAllJson",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        let rows = "";

                        response.data.forEach(c => {
                            rows += `
                    <tr>
                        <td><input class="form-check-input" type="checkbox" value="${c.id}"></td>
                        <td>${c.id}</td>
                        <td>${c.nombre}</td>
                        <td>${c.email}</td>
                        <td>${c.empresa || '-'}</td>
                        <td>${c.servicio}</td>
                        <td>${c.especialidad}</td>
                        <td>${c.telefono || '-'}</td>
                        <td>
                            <button class="btn btn-icon btn-light-primary btn-edit" data-id="${c.id}"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-icon btn-light-danger btn-delete" data-id="${c.id}"><i class="fa fa-trash"></i></button>
                            <a href="/Kima/app/Views/contactos_detalle.php?id=${c.id}" class="btn btn-icon btn-light-info"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>`;
                        });

                        if ($.fn.DataTable.isDataTable("#kt_customers_table")) {
                            $("#kt_customers_table").DataTable().destroy();
                        }

                        $("#clientesTableBody").html(rows);

                        table = $("#kt_customers_table").DataTable({
                            paging: true,
                            ordering: true,
                            searching: true,
                            responsive: true,
                            pageLength: 10,
                            dom: 'Brtip', // 👈 Botones, tabla, info, paginación
                            buttons: [{
                                extend: 'excelHtml5',
                                title: 'Contactos',
                                className: 'd-none',
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5,
                                        6
                                    ] // columnas a exportar
                                }
                            }],
                            order: [
                                [1, "desc"]
                            ],
                            language: {
                                lengthMenu: "Mostrar _MENU_ registros por página",
                                zeroRecords: "No se encontraron resultados",
                                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                                infoEmpty: "No hay registros disponibles",
                                infoFiltered: "(filtrado de _MAX_ registros en total)",
                                search: "Buscar:",
                                paginate: {
                                    first: "Primero",
                                    last: "Último",
                                    next: "Siguiente",
                                    previous: "Anterior"
                                }
                            },
                            initComplete: function() {
                                $(".dataTables_filter")
                                    .hide(); // ocultamos buscador por defecto
                            }
                        });

                        // Búsqueda personalizada con input
                        $("#searchContact").off("keyup").on("keyup", function() {
                            table.search(this.value).draw();
                        });

                        // Filtro por servicio
                        $("#filtro-servicio").off("change").on("change", function() {
                            table.column(5).search(this.value)
                                .draw(); // Empresa o ajusta a tu columna
                        });

                        // Filtro por especialidad
                        $("#filtro-especialidad").off("change").on("change", function() {
                            table.column(6).search(this.value)
                                .draw(); // Estado o ajusta a tu columna
                        });

                        // Botón de exportar
                        $("#kt_export_contactos").off("click").on("click", function() {
                            table.button('.buttons-excel').trigger();
                        });

                    } else {
                        console.error("❌ Error al obtener los datos:", response.message);
                    }
                },
                error: function(error) {
                    console.error("❌ Error en AJAX:", error);
                }
            });
        }



        cargarClientes();

        $("#searchContact").on("keyup", function() {
            if (table) {
                table.search(this.value).draw();
            }
        });



        $("#kt_modal_add_customer_form").off("submit").on("submit", function(event) {
            event.preventDefault();
            console.log("Enviando solicitud AJAX...");

            let submitButton = $("#kt_modal_add_customer_submit");
            submitButton.prop("disabled", true);

            let formData = $(this).serialize(); // Serializa los datos del formulario

            $.ajax({
                type: "POST",
                url: "/Kima/app/Controllers/ContactosController.php?action=create",
                data: formData,
                dataType: "json",
                success: function(response) {
                    console.log("Respuesta recibida:", response);
                    if (response.status === "success") {
                        alert("✅ Contacto agregado correctamente.");

                        let modal = $("#kt_modal_add_customer");

                        modal.modal("hide"); // Cierra el modal
                        modal.on("hidden.bs.modal", function() {
                            $(".modal-backdrop").remove(); // Elimina el fondo gris
                        });

                        cargarClientes(); // Recargar la tabla
                        $("#kt_modal_add_customer_form")[0].reset(); // Resetear formulario
                    } else {
                        alert("❌ Error: " + response.message);
                    }
                },
                error: function() {
                    alert("❌ Error en la solicitud AJAX.");
                },
                complete: function() {
                    submitButton.prop("disabled", false);
                }
            });
        });
    });
    </script>

    <script>
    const icono = document.querySelector('#menu_contactos').previousElementSibling.querySelector('i');
    const span = document.getElementById('menu_contactos');

    icono.style.color = 'white';
    span.style.color = 'white';


    const flexRootElements = document.querySelectorAll('.flex-root');

    flexRootElements.forEach(element => {
        element.setAttribute('style', 'flex: 0 !important;');
    });

    const fkt_app_main = document.querySelectorAll('.app-main');

    fkt_app_main.forEach(element => {
        element.setAttribute('style', 'margin-top: 50px !important;');
    });
    </script>
</body>
<!--end::Body-->

</html>



<html lang="en">


<!--end::Modal-->

<!--begin::Javascript-->
<script>
var hostUrl = "/Kima/public/assets/";
</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS y JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

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