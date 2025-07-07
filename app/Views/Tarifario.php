<?php
$title = "Tarifario"; // Título dinámico
include '../../layout.php'; // Asegúrate de que la ruta sea correcta

require_once "../../config/database.php";

try {
    // Consulta para obtener los estados de tickets
    $query = "SELECT * FROM Categoria_Serv";
    $stmt = $conn->query($query);
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener las categorias: " . $e->getMessage());
}
?>
<html lang="en">
<style>
.custom-accordion .custom-accordion-header {
    cursor: pointer;
    user-select: none;
}

.custom-accordion .custom-accordion-body {
    border-top: 1px solid #ddd;
}
</style>

<body>
    <!--begin::Main-->
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3"
                        style="margin-top: 0; padding-top: 0;">
                        <!--begin::Title-->
                        <div class="d-flex align-items-center">
                            <i class="fas fa-wallet fs-2 me-2"></i>
                            <h1 class="page-heading text-gray-900 fw-bold fs-3 my-0">Tarifario</h1>
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
                            <li class="breadcrumb-item text-muted">Tarifario</li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>


                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <!--begin::Primary button-->
                        <button id="btnEstadisticas" class="btn btn-sm btn-info">
                            <i class="fa-solid fa-chart-column"></i> Ver Estadísticas
                        </button>

                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                            data-bs-target="#modalAddCategoria">
                            <i class="ki-duotone ki-plus fs-2"></i>Agregar Categoría
                        </button>

                        <a href="#" class="btn btn-sm fw-bold btn-primary new_service" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_add_service">
                            <i class="ki-duotone ki-plus fs-2"></i>Agregar Servicio</a>
                        <button type="button" class="btn btn-sm fw-bold btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#modalHistorial">
                            <i class="fa-solid fa-clock-rotate-left me-2"></i>Historial
                        </button>

                        <!--end::Primary button-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Content-->

            <div class="modal fade" id="modalEstadisticas" tabindex="-1" aria-labelledby="modalEstadisticasLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Estadísticas por Categoría</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label>Fecha Inicio</label>
                                    <input type="date" id="fecha_inicio" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Fecha Fin</label>
                                    <input type="date" id="fecha_fin" class="form-control">
                                </div>
                            </div>

                            <button id="btnFiltrarFechas" class="btn btn-primary mb-4">
                                <i class="fa-solid fa-filter"></i> Filtrar
                            </button>

                            <canvas id="chartCategorias"></canvas>
                        </div>

                    </div>
                </div>
            </div>


            <div class="modal fade" id="modalAddCategoria" tabindex="-1" aria-labelledby="modalAddCategoriaLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form id="formAddCategoria">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalAddCategoriaLabel">Nueva Categoría</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="nombre_categoria" class="form-label">Nombre de la categoría</label>
                                    <input type="text" class="form-control" name="nombre_categoria" required>
                                </div>
                                <div id="mensaje_categoria" class="text-center text-danger fw-bold"
                                    style="display:none;"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
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
                            <h5 class="modal-title" id="modalHistorialLabel">Historial de Servicios</h5>
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

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Card-->
                    <div class="card card-flush">
                        <!--begin::Card header-->
                        <div class="card-header pt-8">
                            <div class="d-flex align-items-center justify-content-between w-100 gap-4 flex-wrap">

                                <!-- 🔍 Búsqueda + Filtro -->
                                <div class="d-flex align-items-center gap-4 flex-grow-1">
                                    <!-- Input de búsqueda -->
                                    <div class="position-relative w-50">
                                        <i
                                            class="fa-solid fa-magnifying-glass position-absolute ms-3 top-50 translate-middle-y text-muted"></i>
                                        <input type="text" id="buscar_servicio"
                                            class="form-control form-control-solid ps-10"
                                            placeholder="Buscar servicio" />
                                    </div>

                                    <!-- Select de categoría -->
                                    <div class="w-25">
                                        <select id="filtro_categoria" class="form-select form-select-solid">
                                            <option value="">Filtro categorías</option>
                                            <?php foreach ($categorias as $categoria): ?>
                                            <option value="<?= htmlspecialchars($categoria['Nombre']); ?>">
                                                <?= htmlspecialchars($categoria['Nombre']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Botón Exportar -->
                                <div>
                                    <button type="button" class="btn btn-flex btn-light-primary"
                                        id="kt_export_tarifario">
                                        <i class="fa-solid fa-file-export me-2"></i>Exportar
                                    </button>
                                </div>

                            </div>
                        </div>

                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Table-->
                            <table id="kt_tarifario_table" class="table align-middle table-row-dashed fs-6 gy-5">

                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">ID</th>
                                        <th class="min-w-100px">Nombre del Servicio</th>
                                        <th class="min-w-100px">Precio</th>
                                        <th class="min-w-100px">Categoría</th>
                                        <th class="min-w-125px">Cantidad tramites</th>
                                        <th class="min-w-125px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600" id="kt_tarifario_table_body">

                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>

            <div class="modal fade" id="kt_modal_add_service" tabindex="-1" style="display: none;"
                data-select2-id="select2-data-kt_modal_add_service" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-1000px">
                    <!--begin::Modal content-->
                    <div class="modal-content rounded">
                        <!--begin::Modal header-->
                        <div class="modal-header pb-0 border-0 justify-content-end">
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <i class="ki-duotone ki-cross fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <div class="modal fade" id="modalMessage" tabindex="-1" aria-labelledby="modalMessageLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalMessageLabel">Información</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Aquí se insertará el mensaje dinámicamente -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"
                                            data-bs-dismiss="modal">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                            <form id="kt_modal_add_service_form" class="form">
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3" id="title_modal_custom">Crear Servicio</h1>
                                </div>
                                <div id="error-message" class="alert alert-danger text-center" style="display: none;">
                                </div>


                                <div class="row g-9 mb-8">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-semibold mb-2 required">Nombre del Servicio</label>
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Nombre del servicio" name="name_service">
                                        <!-- Campo oculto para almacenar el ID al editar -->
                                        <input type="hidden" id="id_service" name="id_service">

                                    </div>

                                    <div class="col-md-6">
                                        <label class="fs-6 fw-semibold mb-2 required">Costo del servicio</label>
                                        <input type="number" class="form-control form-control-solid"
                                            placeholder="Costo del servicio" name="costo_service">
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <label class="fs-6 fw-semibold mb-2 required">Categoria</label>
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-placeholder="Selecciona una categoria" data-hide-search="true"
                                        name="categoria_serv">
                                        <option value="">Selecciona una categoria...</option>
                                        <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= htmlspecialchars($categoria['ID']); ?>">
                                            <?= htmlspecialchars($categoria['Nombre']); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-8">
                                    <label class="fs-6 fw-semibold mb-2">Cantidad de tramites</label>
                                    <textarea class="form-control form-control-solid" rows="4" name="description"
                                        placeholder="Cantidad de tramites"></textarea>
                                </div>

                                <div class="text-center">
                                    <button type="reset" class="btn btn-light me-3"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="submit-tarifario">
                                        <span class="indicator-label">Confirmar</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Content-->
        </div>

        <!-- Modal de éxito -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">¡Éxito!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p id="successMessage">El registro se ha guardado correctamente.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--end::Main-->
    <!--begin::Javascript-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    let chart;

    function cargarEstadisticasCategorias() {
        $.get("/app/Controllers/TarifarioController.php?action=obtenerEstadisticasCategorias", function(response) {
            const res = JSON.parse(response);

            if (res.status === "success") {
                const categorias = res.data.map(row => row.categoria);
                const cantidades = res.data.map(row => row.cantidad);

                const ctx = document.getElementById("chartCategorias").getContext("2d");

                if (chart) chart.destroy(); // Destruir el anterior si existe

                chart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: categorias,
                        datasets: [{
                            label: "Servicios por Categoría",
                            data: cantidades,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    }

    // Abre modal y carga chart
    $(document).on("click", "#btnEstadisticas", function() {
        $("#modalEstadisticas").modal("show");
        setTimeout(cargarEstadisticasCategorias, 500); // para asegurar que el canvas está cargado
    });
    </script>

    <script>
    var hostUrl = "/public/assets/";
    </script>
    <script>
    $(document).ready(function() {

        $('#modalHistorial').on('shown.bs.modal', function() {
            $.ajax({
                url: "/app/Controllers/TarifarioController.php?action=getHistorialJson",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        const historial = response.data;

                        const agrupado = historial.reduce((acc, item) => {
                            if (!acc[item.TipoProductoID]) acc[item
                                .TipoProductoID] = [];
                            acc[item.TipoProductoID].push(item);
                            return acc;
                        }, {});

                        let html = '';

                        Object.entries(agrupado).forEach(([tipoID, items]) => {
                            const sectionId = `section-${tipoID}`;
                            const nombre = items[0]?.NombreAnterior ?? 'Sin nombre';

                            html += `
                        <div class="custom-accordion mb-3 border rounded">
                            <div class="custom-accordion-header p-3 bg-light fw-bold cursor-pointer" data-target="#${sectionId}">
                                Historial Producto: ${tipoID} - ${nombre} <span class="float-end">+</span>
                            </div>
                            <div id="${sectionId}" class="custom-accordion-body p-0" style="display: none;">
                                <table class="table table-bordered table-striped m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Acción</th>
                                            <th>Nombre</th>
                                            <th>Costo</th>
                                            <th>Cantidad tramites</th>
                                            <th>Categoría</th>
                                            <th>Usuario</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${items.map(item => `
                                            <tr>
                                                <td>${item.Accion}</td>
                                                <td>${item.NombreAnterior ?? '-'}</td>
                                                <td>${item.CostoAnterior ?? '-'}</td>
                                                <td>${item.DescripcionAnterior ?? '-'}</td>
                                                <td>${item.CategoriaAnteriorNombre ?? '-'}</td>
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








        // Limpiar el formulario cuando se haga clic en el botón "Agregar Servicio"
        $(document).on("click", ".new_service", function() {
            // 🔥 Limpiar los campos del formulario
            $("input[name='name_service']").val("");
            $("input[name='costo_service']").val("");
            $("textarea[name='description']").val("");
            $("#id_service").val(""); // Limpiar el ID por si quedó algo previo

            // 🔥 Cambiar el texto del botón para indicar que es una creación
            $("#submit-tarifario").attr("data-action", "create");
            $("#submit-tarifario").text("Agregar Servicio");
        });

        $(document).on("click", ".btn-edit", function() {
            let id = $(this).data("id");
            let nombre = $(this).data("nombre");
            let costo = $(this).data("costo");
            let descripcion = $(this).data("descripcion");
            let categoria_serv = $(this).data("categoria_serv");

            // 🔥 Llenar los campos del formulario con los datos actuales del servicio
            $("#id_service").val(id); // Agrega el ID en el campo oculto
            $("input[name='name_service']").val(nombre);
            $("input[name='costo_service']").val(costo);
            $("textarea[name='description']").val(descripcion);
            $("select[name='categoria_serv']").val(categoria_serv).trigger('change');


            // 🔥 Cambiar el texto del botón para que sea claro
            $("#submit-tarifario").text("Actualizar Servicio");
            $("#title_modal_custom").text("Actualizar Servicio");

            // 🔥 Cambiar el estado del botón para indicar que es una edición
            $("#submit-tarifario").attr("data-action", "update");

            // 🔥 Mostrar el modal
            $("#kt_modal_add_service").modal("show");
        });

        // 📌 Cuando se hace clic en "Agregar Servicio"
        $("#kt_modal_add_service").on("show.bs.modal", function() {
            let id = $("#id_service").val();

            if (!id) {
                $("#submit-tarifario").attr("data-action", "create"); // Indicar que es nuevo
                $("#submit-tarifario").text("Agregar Servicio"); // Texto del botón


                $("input[name='name_service']").val("");
                $("input[name='costo_service']").val("");
                $("textarea[name='description']").val("");
                $("select[name='categoria_serv']").val("");
                $("#id_service").val("");
            }
        });

        // 📌 Manejo del botón "Confirmar" (Crear o Editar)
        $("#submit-tarifario").click(function() {
            let action = $(this).attr("data-action"); // "create" o "update"

            let id = $("#id_service").val();
            let nombre = $("input[name='name_service']").val().trim();
            let costo = $("input[name='costo_service']").val().trim();
            let descripcion = $("textarea[name='description']").val().trim();
            let categoria_serv = $("select[name='categoria_serv']").val()

            // 🔥 Validar que los campos no estén vacíos solo cuando sea "create"
            if (action === "create") {
                if (nombre === "" || costo === "" || descripcion === "") {
                    $("#error-message").html("⚠️ Todos los campos son obligatorios.").show();
                    setTimeout(function() {
                        $("#error-message").fadeOut();
                    }, 10000); // Desaparece en 10s
                    return;
                } else {
                    $("#error-message").hide();
                }
            }

            let formData = {
                id: id,
                nombre: nombre,
                costo: costo,
                descripcion: descripcion,
                categoria_serv: categoria_serv
            };

            let url = (action === "update") ?
                "/app/Controllers/TarifarioController.php?action=update" :
                "/app/Controllers/TarifarioController.php?action=create";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        // 🔥 Mostrar mensaje en el modal de éxito
                        $("#successMessage").text(response.message);
                        $("#successModal").modal("show");

                        // 🔥 Cerrar el modal de agregar servicio después de éxito
                        $("#kt_modal_add_service").modal("hide");

                        // 🔄 Recargar la página después de 2 segundos
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        $("#error-message").html(response.message).show();
                        setTimeout(function() {
                            $("#error-message").fadeOut();
                        }, 10000);
                    }
                },
                error: function() {
                    $("#error-message").html("❌ Error en la solicitud. Intenta de nuevo.")
                        .show();
                    setTimeout(function() {
                        $("#error-message").fadeOut();
                    }, 10000);
                }
            });
        });

        let table; // 👈 Declarala arriba

        function loadTarifario() {
            $.ajax({
                url: "/app/Controllers/TarifarioController.php?action=getAllJson",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        let rows = "";
                        response.data.forEach(function(producto) {
                            rows += `
                        <tr>
                            <td>${producto.ID}</td>
                            <td>${producto.Nombre}</td>
                            <td>$${producto.Costo}</td>
                            <td>${producto.CategoriaNombre}</td>
                            <td>${producto.Descripcion}</td>
                            <td>
                                <button class="btn btn-icon btn-light-primary me-2 btn-edit" 
                                    data-id="${producto.ID}" data-nombre="${producto.Nombre}" 
                                    data-costo="${producto.Costo}" data-descripcion="${producto.Descripcion}" data-categoria_serv="${producto.id_categoria_serv}">
                                    <i class='fa fa-pencil'></i>
                                </button>
                                <button class="btn btn-icon btn-light-danger btn-delete" data-id="${producto.ID}">
                                    <i class='fa-solid fa-trash'></i>
                                </button>
                            </td>
                        </tr>`;
                        });

                        if ($.fn.DataTable.isDataTable("#kt_tarifario_table")) {
                            $("#kt_tarifario_table").DataTable().destroy();
                        }

                        $("#kt_tarifario_table_body").html(rows);

                        // 👇 Ahora sí: asignamos el DataTable a la variable global
                        table = $("#kt_tarifario_table").DataTable({
                            paging: true,
                            ordering: true,
                            searching: true,
                            responsive: true,
                            pageLength: 10,
                            dom: 'Brtip',
                            buttons: [{
                                extend: 'excelHtml5',
                                title: 'Tarifario',
                                className: 'd-none', // ✅ oculto visualmente
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4]
                                }
                            }],
                            order: [
                                [2, "DESC"]
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
                                // ✅ Oculta el buscador automático solo cuando ya está cargado
                                $('.dataTables_filter').hide();
                            }
                        });


                        // 👇 Activamos búsqueda personalizada solo después de cargar
                        $("#buscar_servicio").off("keyup").on("keyup", function() {
                            table.search(this.value).draw();
                        });

                        $("#kt_export_tarifario").on("click", function() {
                            table.button('.buttons-excel').trigger();
                        });



                        $("#filtro_categoria").on("change", function() {
                            let valor = this.value;
                            table.column(3).search(valor).draw();
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



        // 📌 Llamamos a la función para cargar los datos
        loadTarifario();



        $(document).on("click", ".btn-delete", function() {
            let id = $(this).data("id");
            if (confirm("¿Estás seguro de eliminar este servicio?")) {
                $.ajax({
                    type: "POST",
                    url: "/app/Controllers/TarifarioController.php?action=delete",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $("#successModal .modal-header").removeClass("bg-danger")
                                .addClass("bg-success");
                            $("#successModal .modal-title").text("¡Éxito!");
                            $("#successMessage").text(response.message);
                            $("#successModal").modal("show");
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            $("#successModal .modal-header").removeClass("bg-success")
                                .addClass("bg-danger");
                            $("#successModal .modal-title").text("Error");
                            $("#successMessage").text(response.message);
                            $("#successModal").modal("show");
                        }
                    },
                    error: function() {
                        $("#successModal .modal-header").removeClass("bg-success").addClass(
                            "bg-danger");
                        $("#successModal .modal-title").text("Error");
                        $("#successMessage").text("Error en la solicitud AJAX.");
                        $("#successModal").modal("show");
                    }
                });
            }
        });

        $("#formAddCategoria").submit(function(e) {
            e.preventDefault();
            let nombre = $("input[name='nombre_categoria']").val().trim();

            if (nombre === "") {
                $("#mensaje_categoria").text("⚠️ El nombre es obligatorio").show();
                return;
            }

            $.ajax({
                type: "POST",
                url: "/app/Controllers/TarifarioController.php?action=createCategoria",
                data: {
                    nombre_categoria: nombre
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#mensaje_categoria").hide();
                        $("#modalAddCategoria").modal("hide");
                        alert("✅ " + response.message);
                        location.reload();
                    } else {
                        $("#mensaje_categoria").text(response.message).show();
                    }
                },
                error: function() {
                    $("#mensaje_categoria").text("❌ Error al guardar la categoría.").show();
                }
            });
        });


        function cargarEstadisticasPorFecha(inicio, fin) {
            $.get(`/app/Controllers/TarifarioController.php?action=estadisticasPorFecha&inicio=${inicio}&fin=${fin}`,
                function(response) {
                    const res = JSON.parse(response);

                    if (res.status === "success") {
                        const categorias = res.data.map(row => row.categoria);
                        const cantidades = res.data.map(row => row.cantidad);

                        const ctx = document.getElementById("chartCategorias").getContext("2d");

                        if (chart) chart.destroy();

                        chart = new Chart(ctx, {
                            type: "bar",
                            data: {
                                labels: categorias,
                                datasets: [{
                                    label: "Servicios por Categoría (filtrados)",
                                    data: cantidades,
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    } else {
                        alert("No hay datos para ese rango de fechas.");
                    }
                });
        }

        $("#btnFiltrarFechas").on("click", function() {
            const inicio = $("#fecha_inicio").val();
            const fin = $("#fecha_fin").val();

            if (!inicio || !fin) {
                alert("Selecciona ambas fechas.");
                return;
            }

            cargarEstadisticasPorFecha(inicio, fin);
        });

        $("#btnEstadisticas").on("click", function() {
            $("#modalEstadisticas").modal("show");
            setTimeout(() => cargarEstadisticasCategorias(), 500);
        });




    });
    </script>
    <script>
    const icono = document.querySelector('#menu_tarifario').previousElementSibling.querySelector('i');
    const span = document.getElementById('menu_tarifario');

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

    <!-- Botones para exportar Excel -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="/public/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/public/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="/public/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="/public/assets/js/custom/apps/file-manager/list.js"></script>
    <script src="/public/assets/js/widgets.bundle.js"></script>
    <script src="/public/assets/js/custom/widgets.js"></script>
    <script src="/public/assets/js/custom/apps/chat/chat.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>