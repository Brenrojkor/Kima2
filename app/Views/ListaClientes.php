<?php
$title = "Clientes"; // Título dinámico
include '../../layout.php'; // Asegúrate de que la ruta sea correcta
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Cargar CSS -->
    <link href="/Kima/Kima2/public/assets/css/style.bundle.css" rel="stylesheet">


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
                                <h2 class="fw-bold">Editar Cliente</h2>
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
                                                <label class="required fs-6 fw-semibold mb-2">Empresa</label>
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

                                    <div class="fv-row mb-7">
                                        <label class="required fs-6 fw-semibold mb-2">Dirección</label>
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
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3"
                        style="margin-top: 0; padding-top: 0;">
                        <!--begin::Title-->
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fs-2 me-2"></i>
                            <h1 class="page-heading fw-bold fs-3 my-0">Clientes</h1>
                        </div>
                        <!--end::Title-->

                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="index.html" class="text-muted text-hover-primary">Inicio</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Clientes</li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                </div>
                <!--end::Toolbar container-->
            </div>



            <div id="kt_app_content" class="app-content flex-column-fluid"
                data-select2-id="select2-data-kt_app_content">
                <!--begin::Content container-->

                <div id="kt_app_content_container" class="app-container container-xxl"
                    data-select2-id="select2-data-kt_app_content_container">
                    <!--begin::Card-->
                    <div class="card" data-select2-id="select2-data-51-cgee">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6" data-select2-id="select2-data-50-goah">

                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" data-kt-customer-table-filter="search"
                                    id="searchContact" class="form-control form-control-solid w-250px ps-13"
                                        placeholder="Buscar Cliente">
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar" data-select2-id="select2-data-40-bk0z">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base"
                                    data-select2-id="select2-data-49-m3ah">
                                    <!--begin::Filter-->



                                    <!--end::Filter-->
                                    <!--begin::Export-->
                                    <!--<button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                        data-bs-target="#kt_customers_export_modal">
                                        <i class="ki-duotone ki-exit-up fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Exportar</button>-->
                                    <!--end::Export-->
                                    <!--begin::Add customer-->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_customer">Añadir clientes</button>
                                    <!--end::Add customer-->
                                </div>
                                <!--end::Toolbar-->
                                <!--begin::Group actions-->
                                <div class="d-flex justify-content-end align-items-center d-none"
                                    data-kt-customer-table-toolbar="selected">
                                    <div class="fw-bold me-5">
                                        <span class="me-2"
                                            data-kt-customer-table-select="selected_count">10</span>Seleccionar
                                    </div>
                                    <button type="button" class="btn btn-danger"
                                        data-kt-customer-table-select="delete_selected">Eliminar
                                        Seleccion</button>
                                </div>
                                <!--end::Group actions-->
                            </div>
                            <!--end::Card toolbar-->
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
                                                                                                del
                                                                                                Cliente</span><span
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
                                                                                            data-dt-column="3"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Status: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort: Activate to sort"
                                                                                            tabindex="0"><span
                                                                                                class="dt-column-title"
                                                                                                role="button">Estado</span><span
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
                                        <h2 class="fw-bold">Añadir Cliente</h2>
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
                                                        <label class="required fs-6 fw-semibold mb-2">Empresa</label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            name="empresa">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="required fs-6 fw-semibold mb-2">Cédula</label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            name="cedula">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Dirección -->
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Dirección</label>
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
                                            <span class="indicator-label">Guardar Cliente</span>
                                            <span class="indicator-progress">Por favor espere...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                </form>

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
        // Capturar el evento click del botón Editar
        $(document).on("click", ".btn-edit", function() {
            let clienteID = $(this).data("id"); // Obtener ID del cliente

            // Petición AJAX para obtener la información del cliente
            $.ajax({
                url: "/Kima/Kima2/app/Controllers/ClienteController.php?action=getClienteById",
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
                url: "/Kima/Kima2/app/Controllers/ClienteController.php?action=updateCliente",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert("✅ Cliente actualizado correctamente.");
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
                direccion: $("input[name='direccion']").val(),
                telefono: $("input[name='telefono']").val(),
                estado: $("select[name='estado']").val()
            };

            $.ajax({
                type: "POST",
                url: "/Kima/Kima2/app/Controllers/ClienteController.php?action=create",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert("✅ Cliente agregado correctamente.");
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
                    "¿Estás seguro de que deseas eliminar este cliente? Esta acción no se puede deshacer."
                )) {
                return;
            }

            // Enviar la petición AJAX para eliminar el cliente
            $.ajax({
                url: "/Kima/Kima2/app/Controllers/ClienteController.php?action=deleteCliente",
                type: "POST",
                data: {
                    id: clienteID
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert("✅ Cliente eliminado correctamente.");
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

        let table; // 👈 Variable global

        function cargarClientes() {
            console.log("Ejecutando cargarClientes()...");

            $.ajax({
                url: "/Kima/Kima2/app/Controllers/ClienteController.php?action=getAllJson",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log("Respuesta API cargarClientes:", response);

                    if (response.status === "success" && response.data.length > 0) {
                        let clientes = response.data;
                        let rows = "";

                        clientes.forEach(c => {
                            rows += `
                        <tr>
                            <td><input class="form-check-input" type="checkbox" value="${c.id}"></td>
                            <td>${c.id}</td>
                            <td>${c.nombre}</td>
                            <td>${c.email}</td>
                            <td>${c.empresa || '-'}</td>
                            <td><span class="badge ${c.estado === 'Activo' ? 'badge-light-success' : 'badge-light-danger'}">${c.estado}</span></td>
                            <td>${c.telefono || '-'}</td>
                            <td>
                                <button class="btn btn-icon btn-light-primary btn-edit" data-id="${c.id}"><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-icon btn-light-danger btn-delete" data-id="${c.id}"><i class="fa fa-trash"></i></button>
                                <a href="/Kima/app/Views/clientes.php?id=${c.id}" class="btn btn-icon btn-light-info"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>`;
                        });


                        // **Si DataTable ya está inicializado, destruirlo**
                        if ($.fn.DataTable.isDataTable("#kt_customers_table")) {
                            $("#kt_customers_table").DataTable().destroy();
                        }

                        $("#clientesTableBody").html(rows);


                        // **Re-inicializar DataTables**
                        table = $("#kt_customers_table").DataTable({
                            paging: true,
                            lengthMenu: [5, 10, 25, 50, 100],
                            pageLength: 5,
                            ordering: true,
                            order: [
                                [1, "DESC"]
                            ],
                            searching: true,
                            info: true,
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
                            }
                        });

                    } else {
                        console.error("Error: No hay datos en la respuesta del servidor.");
                        $("#clientesTableBody").html(
                            '<tr><td colspan="9" class="text-center">No hay clientes disponibles.</td></tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en AJAX:", error);
                    $("#clientesTableBody").html(
                        '<tr><td colspan="9" class="text-center text-danger">Error al cargar clientes.</td></tr>'
                    );
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
                url: "/Kima/Kima2/app/Controllers/ClienteController.php?action=create",
                data: formData,
                dataType: "json",
                success: function(response) {
                    console.log("Respuesta recibida:", response);
                    if (response.status === "success") {
                        alert("✅ Cliente agregado correctamente.");

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
    const icono = document.querySelector('#menu_clientes').previousElementSibling.querySelector('i');
    const span = document.getElementById('menu_clientes');

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
var hostUrl = "/Kima/Kima2/public/assets/";
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
<script src="/Kima/Kima2/public/assets/plugins/global/plugins.bundle.js"></script>
<script src="/Kima/Kima2/public/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="/Kima/Kima2/public/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="/Kima/Kima2/public/assets/js/custom/apps/file-manager/list.js"></script>
<script src="/Kima/Kima2/public/assets/js/widgets.bundle.js"></script>
<script src="/Kima/Kima2/public/assets/js/custom/widgets.js"></script>
<script src="/Kima/Kima2/public/assets/js/custom/apps/chat/chat.js"></script>
<script src="/Kima/Kima2/public/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="/Kima/Kima2/public/assets/js/custom/utilities/modals/create-app.js"></script>
<script src="/Kima/Kima2/public/assets/js/custom/utilities/modals/users-search.js"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>