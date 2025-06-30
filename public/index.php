<?php
$title = "Inicio"; // Título dinámico
include '../layout.php'; // Asegúrate de que la ruta sea correcta

require_once "../config/database.php";

$usuarioID = $_SESSION['usuario_id'] ?? null;

$darkmode = $_SESSION['darkmode'] ?? 0;


$cantidadTickets = 0;

if ($usuarioID) {
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM Tickets WHERE ResponsableID = ? and EstadoID != '3'");
    $stmt->execute([$usuarioID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $cantidadTickets = $result['total'];
}

try {
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM Tickets WHERE ResponsableID = ? and EstadoID = '4'");
    $stmt->execute([$usuarioID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $countTicketPending = $result['total'];

} catch (PDOException $e) {
    die("❌ Error: " . $e->getMessage());
}

try {
    $stmt = $conn->prepare("SELECT COUNT(*) as total 
                            FROM Tickets 
                            WHERE ResponsableID = ? 
                              AND EstadoID = '3' 
                              AND FechaCreacion >= DATEADD(DAY, -30, GETDATE())");
    $stmt->execute([$usuarioID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $countTicketClosed = $result['total'];

} catch (PDOException $e) {
    die("❌ Error: " . $e->getMessage());
}


$porcentaje = 0;

if ($cantidadTickets > 0) {
    $porcentaje = ($countTicketPending / $cantidadTickets) * 100;
    $porcentaje = number_format($porcentaje, 2); // Formatear a 2 decimales
}


?>
<html lang="en">
<style>
    .btn_center_i{
        padding-right: 0px !important;
    }
</style>
<body>
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3"></div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center gap-2 gap-lg-3" style="margin-top: 25px;">
                        <!--<a href="apps/projects/list.html" class="btn btn-sm fw-bold btn-secondary">Mis Proyectos</a>
                        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_create_project">Nuevo Proyecto</a>--->
                        <button class="btn btn-sm fw-bold btn-primary" id="btnAgregarNota">
                            <i class="fas fa-edit"></i> Agregar Nota
                        </button>


                        <a href="/app/Views/tarifario.php" class="btn btn-sm fw-bold btn-primary"><i
                                class="fa-solid fa-plus"></i>Agregar servicio tarifario</a>

                    </div>
                    <!--end::Actions-->
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-15 mb-10">
                            <!--begin::Card widget 16-->
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 h-md-50 mb-5 mb-xl-10"
                                style="background-color: #080655">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Amount-->
                                        <span
                                            class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2"><?= $cantidadTickets ?></span>
                                        <!--end::Amount-->
                                        <!--begin::Subtitle-->
                                        <span class="text-white opacity-50 pt-1 fw-semibold fs-6">Tickets
                                            Activos</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex align-items-end pt-0">
                                    <!--begin::Progress-->
                                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                                        <div
                                            class="d-flex justify-content-between fw-bold fs-6 text-white opacity-50 w-100 mt-auto mb-2">
                                            <span><?= $countTicketPending  ?> Pendientes</span>
                                            <span><?= $porcentaje ?>%</span>
                                        </div>
                                        <div class="h-8px mx-3 w-100 bg-light-danger rounded">
                                            <div class="bg-danger rounded h-8px" role="progressbar"
                                                style="width: <?= $porcentaje ?>%;" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--begin::Card widget 7-->
                            <!--begin::Card widget: Total de Tickets Cerrados del Mes-->
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Amount-->
                                        <span
                                            class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2"><?= $countTicketClosed ?></span>
                                        <!--end::Amount-->
                                        <!--begin::Subtitle-->
                                        <span class="text-gray-500 pt-1 fw-semibold fs-6">Tickets Cerrados en los
                                            ultimos 30 días.</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <!--<div class="card-body d-flex flex-column justify-content-end pe-0">
                                   
                                    <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Mes de Noviembre 2024</span>
                                    
                                    <div class="symbol-group symbol-hover flex-nowrap">
                                       
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                            title="Usuario 1">
                                            <span class="symbol-label bg-primary text-inverse-primary fw-bold">U1</span>
                                        </div>
                                   
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                            title="Usuario 2">
                                            <span class="symbol-label bg-success text-inverse-success fw-bold">U2</span>
                                        </div>
                                  
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                            title="Usuario 3">
                                            <span class="symbol-label bg-warning text-inverse-warning fw-bold">U3</span>
                                        </div>
                                      
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                            title="Usuario 4">
                                            <span class="symbol-label bg-danger text-inverse-danger fw-bold">U4</span>
                                        </div>
                                       
                                    </div>
                                 
                                </div>-->
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget-->


                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-lg-12 col-xl-12 col-xxl-6 mb-10 mb-xl-0">
                            <div class="card h-md-100">
                                <!--begin::Header-->
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-900">Notas Importantes</span>
                                        <span class="text-muted mt-1 fw-semibold fs-7">Actualizaciones clave</span>
                                    </h3>
                                    <!--begin::Actions-->
                                    <!--end::Actions-->
                                </div>
                                <!--end::Header-->

                                <!--begin::Body-->
                                <div class="card-body pt-5" id="notesList">


                                </div>
                                <!--end::Body-->
                            </div>
                        </div>

                        <!-- Modal Nota -->
                        <div class="modal fade" id="modalNota" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="formNota">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Agregar Nota</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="nota_id" name="id">
                                            <div class="mb-3">
                                                <label for="titulo_nota" class="form-label">Título</label>
                                                <input type="text" class="form-control" id="titulo_nota" name="titulo"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="descripcion_nota" class="form-label">Descripción</label>
                                                <textarea class="form-control" id="descripcion_nota" name="descripcion"
                                                    rows="4" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Guardar Nota</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!--end::Col-->
                    </div>
                    <!--begin::Row-->
                    <!--Inicia Charts  --->

                    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                        <!--begin::Col Izquierdo-->
                        <div class="col-xxl-6">
                            <div class="card card-flush h-md-100">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <h3 class="card-title d-flex flex-column">
                                        <span class="card-label fw-bold fs-3 mb-1">Categoría de tickets</span>
                                        <span class="text-muted fw-semibold fs-7">Distribucón de Tickets por
                                            categoría</span>
                                    </h3>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Gráfico de Clientes-->
                                    <div id="ticketsByCategoryChart" style="height: 350px;"></div>

                                    <!--end::Gráfico de Clientes-->
                                </div>
                                <!--end::Body-->
                            </div>
                        </div>
                        <!--end::Col Izquierdo-->
                        <!--begin::Col Derecho-->
                        <div class="col-xxl-6">
                            <div class="card card-flush h-md-100">
                                <div class="card-header pt-5">
                                    <h3 class="card-title d-flex flex-column">
                                        <span class="card-label fw-bold fs-3 mb-1">Estado de Tickets</span>
                                        <span class="text-muted fw-semibold fs-7">Distribución de tickets por
                                            estado</span>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div id="ticketsChart" style="height: 350px;"></div>
                                    <!-- 🔥 Aquí se mostrará el gráfico -->
                                </div>
                            </div>

                        </div>
                        <!--end::Col Derecho-->
                    </div>

                    <!-- Finaliza Charts  --->
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                        <!--begin::Col Izquierdo-->
                        <div class="col-xxl-6">
                            <div class="card card-flush h-md-100">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <h3 class="card-title d-flex flex-column">
                                        <span class="card-label fw-bold fs-3 mb-1">Tiempos de resolución</span>
                                        <span class="text-muted fw-semibold fs-7">Tickets abiertos, con mayor tiempo sin
                                            solución (ID de tickets)</span>
                                    </h3>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Gráfico de Clientes -->
                                    <div id="delayedTicketsChart" style="height: 350px;"></div>


                                    <!--end::Gráfico de Clientes-->
                                </div>
                                <!--end::Body-->
                            </div>
                        </div>
                        <!--end::Col Izquierdo-->
                        <!--begin::Col Derecho-->
                        <div class="col-xxl-6">
                            <div class="card card-flush h-md-100">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <h3 class="card-title d-flex flex-column">
                                        <span class="card-label fw-bold fs-3 mb-1">Tiempo Promedio Atención de
                                            Tickets</span>
                                        <span class="text-muted fw-semibold fs-7">Promedio de atención de tickets</span>
                                    </h3>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Gráfico de Categorías-->

                                    <div id="avgResponseTimeChart" style="height: 350px;"></div>
                                    <!--end::Gráfico de Categorías-->
                                </div>
                                <!--end::Body-->
                            </div>
                        </div>
                        <!--end::Col Derecho-->
                    </div>

                    <!--begin::Row-->
                    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                        <!--begin::Col Izquierdo-->
                        <div class="col-xxl-6">
                            <div class="card card-flush h-md-100">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <h3 class="card-title d-flex flex-column">
                                        <span class="card-label fw-bold fs-3 mb-1">Tickets Resueltos por
                                            Responsable</span>
                                        <span class="text-muted fw-semibold fs-7">Cantidad de tickets resultos por
                                            responsable</span>
                                    </h3>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Gráfico de Clientes -->
                                    <div id="ticketsClosedByUserChart" style="height: 350px;"></div>


                                    <!--end::Gráfico de Clientes-->
                                </div>
                                <!--end::Body-->
                            </div>
                        </div>
                        <!--end::Col Izquierdo-->
                        <!--begin::Col Derecho-->
                        <div class="col-xxl-6">
                            <div class="card card-flush h-md-100">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <h3 class="card-title d-flex flex-column">
                                        <span class="card-label fw-bold fs-3 mb-1">Pregreso de Tickets</span>
                                        <span class="text-muted fw-semibold fs-7">Progreso de los tickets según su
                                            estado</span>
                                    </h3>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Gráfico de Categorías-->

                                    <div id="paretoChart" style="height: 350px;"></div>
                                    <!--end::Gráfico de Categorías-->
                                </div>
                                <!--end::Body-->
                            </div>
                        </div>
                        <!--end::Col Derecho-->
                    </div>


                    <div class="card mb-5 mb-xl-8">
                        <!-- Botones de filtro -->
                        <div class="card-header pt-5">
                            <h3 class="card-title d-flex flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Tickets cerrados</span>
                                <span class="text-muted fw-semibold fs-7">Tickets cerrados en el último mes y último
                                    trimestre</span>
                                <br>
                            </h3>
                        </div>

                        <div class="card-body pt-3">
                            <div class="mb-4">
                                <button id="btnMes" class="btnFiltroFecha btn btn-primary me-2">Último Mes</button>
                                <button id="btnTrimestre" class="btnFiltroFecha btn btn-outline-primary">Último
                                    Trimestre</button>
                            </div>


                            <table id="tablaTickets" class="table table-striped table-bordered" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th>Fecha Creación</th>
                                        <th>Fecha Cierre</th>
                                        <th>Estado</th>
                                        <th>Responsable</th>
                                        <th>Cliente</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>


                    <div class="card mb-5 mb-xl-8">
                        <!-- Botones de filtro -->
                        <div class="card-header pt-5">
                            <h3 class="card-title d-flex flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Tickets Asignados</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">Tickets asociados al usuario
                                    actual</span>
                            </h3>
                        </div>

                        <div class="card-body pt-3">
                            <table id="tablaTicketsUsuario" class="table table-striped table-bordered"
                                style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th>Fecha Creación</th>
                                        <th>Categoría</th>
                                        <th>Estado</th>
                                        <th>Responsable</th>
                                        <th>Cliente</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalTicket" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Producto:</strong> <span id="modalCategoria"></span></p>
                    <p><strong>Descripción:</strong> <span id="modalDescripcion"></span></p>
                    <p><strong>Fecha de creación:</strong> <span id="modalFecha"></span></p>
                    <p><strong>Estado:</strong> <span id="modalEstado"></span></p>
                    <p><strong>Cliente:</strong> <span id="modalCliente"></span></p>
                    <p><strong>Responsable:</strong> <span id="modalResponsable"></span></p>
                    <p><strong>Prioridad:</strong> <span id="modalPrioridad"></span></p>
                    <div class="mb-3">
                        <h6>🗨️ Comentarios:</h6>
                        <ul id="listaComentarios" class="list-group"></ul>
                    </div>
                    <div class="mb-3">
                        <h6>📎 Archivos Adjuntos:</h6>
                        <ul id="listaDocumentos" class="list-group"></ul>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <!--end::Modal - Invite Friend-->
    <!--end::Modals-->
    <!--begin::Javascript-->
    <script>
    var hostUrl = "/public/assets/";

    $(".btnFiltroFecha").on("click", function() {
        // Quitar clases activas a todos
        $(".btnFiltroFecha").removeClass("btn-primary").addClass("btn-outline-primary");

        // Activar solo el que se clickeó
        $(this).removeClass("btn-outline-primary").addClass("btn-primary");

        // Filtro según el botón clickeado
        const filtro = this.id === 'btnMes' ? 'mes' : 'trimestre';

        // Cargar los tickets con ese filtro
        cargarTickets(filtro);
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        const tablaUser = $('#tablaTicketsUsuario').DataTable({
            language: {
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }

            },
            order: [
                [2, 'desc']
            ],
            columns: [{
                    data: 'ID'
                },
                {
                    data: 'Descripcion'
                },
                {
                    data: 'FechaCreacion'
                },
                {
                    data: 'NombreCategoria'
                },
                {
                    data: 'NombreEstado'
                },
                {
                    data: 'ResponsableNombre'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `${row.ClienteNombre} - ${row.ClienteEmpresa}`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    className: "text-center",
                    render: function(data, type, row) {
                        return `
            <button class="btn btn-sm btn-primary btnVerTicket" 
                data-id="${row.ID}" 
                title="Ver detalles del ticket">
                <i class="btn_center_i fas fa-eye"></i>
            </button>
        `;
                    }
                }
            ]
        });

        function cargarTicketsUser() {
            $.ajax({
                url: `/app/Controllers/InicioController.php?action=getTicketsByUser`,
                type: "GET",
                dataType: "json",
                success: function(res) {
                    console.log('Tickets Mal', res);
                    if (res.status === "success") {
                        tablaUser.clear().rows.add(res.data).draw();
                    } else {
                        tablaUser.clear().draw();
                        alert("⚠️ " + res.message);
                    }
                },
                error: function() {
                    alert("❌ Error al cargar los datos");
                }
            });
        }


        // Cargar por defecto el último mes
        cargarTicketsUser();


        $(document).on("click", ".btnVerTicket", function() {
            const ticketId = $(this).data("id");

            $.ajax({
                url: `/app/Controllers/InicioController.php?action=getTicketDetalle&id=${ticketId}`,
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.status === "success") {
                        const t = res.data.ticket;
                        const comentarios = res.data.comentarios;
                        const documentos = res.data.documentos;

                        $("#modalTitulo").text(`Ticket #${t.ID}`);
                        $("#modalDescripcion").text(t.Descripcion);
                        $("#modalFecha").text(t.FechaCreacion);
                        $("#modalEstado").text(t.NombreEstado);
                        $("#modalCategoria").text(t.NombreCategoria);
                        $("#modalCliente").text(`${t.ClienteNombre} - ${t.ClienteEmpresa}`);
                        $("#modalResponsable").text(t.ResponsableNombre);
                        $("#modalPrioridad").text(t.NombrePrioridad);
                        // Mostrar comentarios
                        let comentariosHtml = '';
                        if (comentarios.length > 0) {
                            comentarios.forEach(com => {
                                comentariosHtml += `
            <li class="list-group-item">
                <strong>${com.UsuarioNombre}:</strong> ${com.Comentario}
                <br><small class="text-muted">${new Date(com.Fecha).toLocaleString()}</small>
            </li>`;
                            });
                        } else {
                            comentariosHtml =
                                `<li class="list-group-item text-muted">Sin comentarios</li>`;
                        }

                        $("#listaComentarios").html(comentariosHtml);

                        let documentosHtml = '';
                        if (documentos.length > 0) {
                            documentos.forEach(doc => {
                                documentosHtml += `
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>${doc.NombreArchivo}</span>
            <a href="/public/${doc.RutaArchivo}" target="_blank" class="btn btn-sm btn-primary">Ver</a>
        </li>`;
                            });
                        } else {
                            documentosHtml =
                                `<li class="list-group-item text-muted">Sin archivos adjuntos</li>`;
                        }
                        $("#listaDocumentos").html(documentosHtml);


                        $("#modalTicket").modal("show");
                    } else {
                        alert(res.message);
                    }
                },
                error: function() {
                    alert("❌ No se pudo cargar la información del ticket.");
                }
            });
        });

    });
    </script>
    <script>
    $(document).ready(function() {
        const tabla = $('#tablaTickets').DataTable({
            language: {
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }

            },
            order: [
                [3, 'desc']
            ],
            columns: [{
                    data: 'ID'
                },
                {
                    data: 'Descripcion'
                },
                {
                    data: 'FechaCreacion'
                },
                {
                    data: 'FechaFin',
                    render: function(data) {
                        return data ? data.split(' ')[0] : '';
                    }
                },
                {
                    data: 'NombreEstado'
                },
                {
                    data: 'ResponsableNombre'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `${row.ClienteNombre} - ${row.ClienteEmpresa}`;
                    }
                }
            ]
        });

        function cargarTickets(filtro = 'mes') {
            $.ajax({
                url: `/app/Controllers/InicioController.php?action=getTicketsByDateRange&filtro=${filtro}`,
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.status === "success") {
                        tabla.clear().rows.add(res.data).draw();
                    } else {
                        tabla.clear().draw();
                        alert("⚠️ " + res.message);
                    }
                },
                error: function() {
                    alert("❌ Error al cargar los datos");
                }
            });
        }

        $("#btnMes").on("click", function() {
            cargarTickets('mes');
        });

        $("#btnTrimestre").on("click", function() {
            cargarTickets('trimestre');
        });

        // Cargar por defecto el último mes
        cargarTickets('mes');
    });
    </script>
    <script>
    $(document).ready(function() {

        function cargarNotas() {
            $.get("/app/Controllers/NotasController.php?action=listarNotas", function(res) {
                if (res.status === "success") {
                    let html = "";

                    res.data.forEach(nota => {
                        html += `
<div class="mb-5 p-4 bg-white rounded shadow-sm position-relative">
    <h5 class="fw-bold text-gray-800">${nota.titulo}</h5>
    <p class="text-gray-600 mb-2">${nota.descripcion}</p>
    <span class="text-muted fs-7">Actualizado: ${formatearFecha(nota.fecha)}</span>

    <!-- 🔥 Contenedor de botones -->
    <div class="position-absolute top-0 end-0 mt-3 me-3 d-flex gap-2">
        <button 
            type="button" 
            class="btn btn-icon btn-sm btn-light btnEditarNota" 
            data-id="${nota.id}" 
            title="Editar nota">
            <i class="fas fa-pen text-primary"></i>
        </button>

        <button 
            type="button" 
            class="btn btn-icon btn-sm btn-light btnEliminarNota"  
            data-id="${nota.id}" 
            title="Eliminar nota">
            <i class="fas fa-trash-alt text-danger"></i>
        </button>
    </div>
</div>`;

                    });


                    $("#notesList").html(html);
                } else {
                    $("#notesList").html("<p class='text-muted'>No hay notas registradas.</p>");
                }
            }, "json");
        }

        // Formatear fecha tipo YYYY-MM-DD a algo más legible
        function formatearFecha(fecha) {
            let f = new Date(fecha);
            return f.toLocaleDateString("es-CR", {
                day: "2-digit",
                month: "long",
                year: "numeric"
            });
        }

        // Abrir modal en modo agregar
        $("#btnAgregarNota").on("click", function() {
            $("#nota_id").val("");
            $("#titulo_nota").val("");
            $("#descripcion_nota").val("");
            $("#modalNota .modal-title").text("Agregar Nota");
            $("#modalNota").modal("show");
        });

        // Guardar o editar nota
        $("#formNota").on("submit", function(e) {
            e.preventDefault();

            let id = $("#nota_id").val();
            let titulo = $("#titulo_nota").val();
            let descripcion = $("#descripcion_nota").val();

            if (!titulo || !descripcion) {
                alert("Por favor, complete todos los campos.");
                return;
            }

            $.ajax({
                url: "/app/Controllers/NotasController.php?action=guardar",
                type: "POST",
                data: {
                    id,
                    titulo,
                    descripcion
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === "success") {
                        alert(res.message);
                        $("#modalNota").modal("hide");
                        cargarNotas(); // función que debes tener para refrescar listado
                    } else {
                        alert(res.message);
                    }
                },
                error: function() {
                    alert("Error al guardar la nota.");
                }
            });
        });

        cargarNotas();

        // Editar nota (al hacer clic en botón)
        $(document).on("click", ".btnEditarNota", function() {
            let id = $(this).data("id");

            $.get(`/app/Controllers/NotasController.php?action=obtenerNota&id=${id}`, function(
                res) {
                if (res.status === "success") {
                    let nota = res.data;
                    $("#nota_id").val(nota.id);
                    $("#titulo_nota").val(nota.titulo);
                    $("#descripcion_nota").val(nota.descripcion);
                    $("#modalNota .modal-title").text("Editar Nota");
                    $("#modalNota").modal("show");
                } else {
                    alert(res.message);
                }
            }, "json");
        });

        // Eliminar nota (al hacer clic en botón)
        $(document).on("click", ".btnEliminarNota", function() {
            let id = $(this).data("id");

            if (confirm("¿Estás seguro de eliminar esta nota?")) {
                $.post("/app/Controllers/NotasController.php?action=eliminar", {
                    id
                }, function(res) {
                    if (res.status === "success") {
                        alert(res.message);
                        cargarNotas();
                    } else {
                        alert(res.message);
                    }
                }, "json");
            }
        });


    });
    </script>

    <script>
    am5.ready(function() {
        // 📌 Gráfico 1: Tickets por Estado
        var rootTickets = am5.Root.new("ticketsChart");
        rootTickets.setThemes([am5themes_Animated.new(rootTickets)]);

        var chartTickets = rootTickets.container.children.push(
            am5percent.PieChart.new(rootTickets, {
                layout: rootTickets.verticalLayout
            })
        );

        var seriesTickets = chartTickets.series.push(
            am5percent.PieSeries.new(rootTickets, {
                valueField: "value",
                categoryField: "category"
            })
        );

        // 🔥 Cargar datos dinámicos desde PHP
        fetch("/app/Controllers/InicioController.php?action=getTicketsByState")
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    seriesTickets.data.setAll(data.data);
                } else {
                    console.error("⚠️ No se encontraron datos de tickets.");
                }
            })
            .catch(error => console.error("❌ Error al cargar los datos de tickets.", error));

        seriesTickets.labels.template.setAll({
            text: "{category}: {valuePercentTotal.formatNumber('0.0')}%",
            fontSize: 14,
            fontWeight: "bold",
            fill: am5.color("#555"),
            centerX: am5.percent(50),
            centerY: am5.percent(50)
        });

        chartTickets.appear(1000, 100);

        // 📌 Gráfico 2: Tickets por Categoría
        var rootCategories = am5.Root.new("ticketsByCategoryChart");
        rootCategories.setThemes([am5themes_Animated.new(rootCategories)]);

        var chartCategories = rootCategories.container.children.push(
            am5percent.PieChart.new(rootCategories, {
                layout: rootCategories.verticalLayout
            })
        );

        var seriesCategories = chartCategories.series.push(
            am5percent.PieSeries.new(rootCategories, {
                valueField: "value",
                categoryField: "category"
            })
        );

        // ✅ Obtener datos desde PHP (AJAX)
        fetch("/app/Controllers/InicioController.php?action=getTicketsByCategory")
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    seriesCategories.data.setAll(data.data);
                } else {
                    console.error("❌ Error al obtener datos:", data.message);
                }
            })
            .catch(error => console.error("❌ Error en la petición AJAX:", error));

        seriesCategories.slices.template.setAll({
            tooltipText: "{category}: {valuePercentTotal.formatNumber('0.0')}% ({value})"
        });

        seriesCategories.labels.template.setAll({
            text: "{category} ({valuePercentTotal.formatNumber('0.0')}%)"
        });

        chartCategories.appear(1000, 100);

        // 📌 Gráfico 3: Tickets con Mayor Tiempo de Resolución (Gráfico de Barras)
        var rootDelayTime = am5.Root.new("delayedTicketsChart");
        rootDelayTime.setThemes([am5themes_Animated.new(rootDelayTime)]);

        var chartDelay = rootDelayTime.container.children.push(
            am5xy.XYChart.new(rootDelayTime, {
                panX: true,
                panY: false,
                wheelX: "panX",
                wheelY: "zoomX",
                layout: rootDelayTime.verticalLayout
            })
        );

        // ✅ Definir el eje X (Tickets)
        var xAxisDelay = chartDelay.xAxes.push(
            am5xy.CategoryAxis.new(rootDelayTime, {
                categoryField: "ID",
                renderer: am5xy.AxisRendererX.new(rootDelayTime, {
                    minGridDistance: 30
                })
            })
        );

        // ✅ Definir el eje Y (Horas Totales en decimal)
        var yAxisDelay = chartDelay.yAxes.push(
            am5xy.ValueAxis.new(rootDelayTime, {
                renderer: am5xy.AxisRendererY.new(rootDelayTime, {})
            })
        );

        // ✅ Crear la serie de columnas
        var seriesDelay = chartDelay.series.push(
            am5xy.ColumnSeries.new(rootDelayTime, {
                name: "Tiempo en Horas",
                xAxis: xAxisDelay,
                yAxis: yAxisDelay,
                valueYField: "horas_totales",
                categoryXField: "ID"
            })
        );

        // ✅ Personalizar las columnas (Barras)
        seriesDelay.columns.template.setAll({
            strokeWidth: 2,
            stroke: am5.color(0x000000), // Borde negro
            fillOpacity: 0.8
        });

        // ✅ Agregar etiquetas dentro de las barras con el tiempo formateado y la alerta "En atraso"
        seriesDelay.bullets.push(function(root, series, dataItem) {
            let tiempoProceso = dataItem.dataContext.tiempo_proceso;
            let segundosEnProceso = dataItem.dataContext.segundos_en_proceso;

            let container = am5.Container.new(
                root, {}); // 📌 Contenedor para manejar múltiples etiquetas

            // 🔹 Etiqueta de tiempo en negro
            let labelTiempo = am5.Label.new(root, {
                text: tiempoProceso,
                fill: am5.color(0x000000), // Negro
                centerX: am5.percent(50),
                centerY: am5.percent(-10),
                fontSize: 12,
                fontWeight: "bold"
            });

            container.children.push(labelTiempo); // ✅ Se agrega al contenedor

            // 🔥 Si el ticket lleva más de 4 horas (14400 segundos), agregar "⚠️ En atraso"
            if (segundosEnProceso > 14400) {
                let labelAtraso = am5.Label.new(root, {
                    text: "⚠️ En atraso",
                    fill: am5.color(0xff0000), // Rojo
                    centerX: am5.percent(60),
                    centerY: am5.percent(-60),
                    fontSize: 12,
                    fontWeight: "bold"
                });

                container.children.push(labelAtraso); // ✅ Se agrega al contenedor
            }

            return am5.Bullet.new(root, {
                locationY: 1,
                sprite: container // 📌 Se usa el contenedor con ambas etiquetas
            });
        });

        // ✅ Cargar datos dinámicos
        fetch("/app/Controllers/InicioController.php?action=getDelayedTickets")
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    xAxisDelay.data.setAll(data.data);
                    seriesDelay.data.setAll(data.data);
                } else {
                    console.error("❌ Error al obtener datos:", data.message);
                }
            })
            .catch(error => console.error("❌ Error en AJAX:", error));

        chartDelay.appear(1000, 100);


        // 📌 Gráfico 4: Tickets con Tiempo Promedio de Atención
        var rootAvgTime = am5.Root.new("avgResponseTimeChart");
        rootAvgTime.setThemes([am5themes_Animated.new(rootAvgTime)]);

        var chartAverage = rootAvgTime.container.children.push(
            am5xy.XYChart.new(rootAvgTime, {
                panX: true,
                panY: false,
                wheelX: "panX",
                wheelY: "zoomX",
                layout: rootAvgTime.verticalLayout
            })
        );

        var yAxis = chartAverage.yAxes.push(
            am5xy.ValueAxis.new(rootAvgTime, {
                renderer: am5xy.AxisRendererY.new(rootAvgTime, {})
            })
        );

        var xAxis = chartAverage.xAxes.push(
            am5xy.CategoryAxis.new(rootAvgTime, {
                categoryField: "label",
                renderer: am5xy.AxisRendererX.new(rootAvgTime, {})
            })
        );

        var seriesAverage = chartAverage.series.push(
            am5xy.ColumnSeries.new(rootAvgTime, {
                name: "Tiempo Promedio",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                categoryXField: "label"
            })
        );

        // 📌 Agregar etiquetas dentro de la barra con el tiempo promedio en horas
        seriesAverage.bullets.push(function(root, series, dataItem) {
            return am5.Bullet.new(root, {
                locationY: 0.5, // Centrar en la barra
                sprite: am5.Label.new(root, {
                    text: dataItem.dataContext.value.toFixed(2) +
                        "h", // Mostrar el valor con 2 decimales y "h"
                    fill: am5.color(0x000000), // Color negro
                    centerX: am5.percent(50),
                    centerY: am5.percent(50),
                    fontSize: 14,
                    fontWeight: "bold"
                })
            });
        });


        // ✅ Cargar datos dinámicos
        fetch("/app/Controllers/InicioController.php?action=getAverageResponseTime")
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    console.log("Tiempo promedio de atención:", data.promedio);

                    xAxis.data.setAll([{
                        label: "Tiempo Promedio"
                    }]);
                    seriesAverage.data.setAll([{
                        label: "Tiempo Promedio",
                        value: data.promedio
                    }]); // ✅ Asignar valor correcto

                } else {
                    console.error("❌ Error al obtener datos:", data.message);
                }
            })
            .catch(error => console.error("❌ Error en AJAX:", error));


        chartAverage.appear(1000, 100);



        // 📌 Gráfico #5: Tickets Cerrados por Responsable
        var rootUsers = am5.Root.new("ticketsClosedByUserChart");
        rootUsers.setThemes([am5themes_Animated.new(rootUsers)]);

        var chartUser = rootUsers.container.children.push(
            am5xy.XYChart.new(rootUsers, {
                panX: true,
                panY: false,
                wheelX: "panX",
                wheelY: "zoomX",
                layout: rootUsers.verticalLayout
            })
        );

        // 📌 Crear ejes X (Usuarios) y Y (Cantidad de tickets)
        var xAxisUser = chartUser.xAxes.push(
            am5xy.CategoryAxis.new(rootUsers, {
                categoryField: "label", // Asegurar que el campo coincide con la respuesta
                renderer: am5xy.AxisRendererX.new(rootUsers, {
                    minGridDistance: 30
                })
            })
        );

        var yAxisUser = chartUser.yAxes.push(
            am5xy.ValueAxis.new(rootUsers, {
                min: 0,
                extraMax: 0.5, // Asegurar que hay espacio para las barras
                renderer: am5xy.AxisRendererY.new(rootUsers, {})
            })
        );

        // 📌 Crear la serie de barras
        var seriesUser = chartUser.series.push(
            am5xy.ColumnSeries.new(rootUsers, {
                name: "Tickets Cerrados",
                xAxis: xAxisUser,
                yAxis: yAxisUser,
                valueYField: "value", // Asegurar que coincide con la respuesta del backend
                categoryXField: "label",
                tooltip: am5.Tooltip.new(rootUsers, {
                    labelText: "{label}: {valueY} tickets"
                })
            })
        );

        // 📌 Personalizar las barras
        seriesUser.columns.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5,
            strokeOpacity: 0
        });

        // 📌 Agregar etiquetas dentro de las barras con la cantidad de tickets cerrados
        seriesUser.bullets.push(function(root, series, dataItem) {
            return am5.Bullet.new(root, {
                locationY: 0.5,
                sprite: am5.Label.new(root, {
                    text: dataItem.dataContext.value
                        .toString(), // 🔥 Accede correctamente al valor
                    fill: am5.color(0x000000), // Negro
                    centerX: am5.percent(50),
                    centerY: am5.percent(50),
                    fontSize: 14,
                    fontWeight: "bold"
                })
            });
        });



        // 🔥 Obtener datos desde PHP (AJAX)
        fetch("/app/Controllers/InicioController.php?action=getTicketsClosedByUser")
            .then(response => response.json())
            .then(data => {
                console.log("Datos recibidos:", data); // Verifica en consola

                if (data.status === "success" && data.data.length > 0) {
                    // Asegurar que 'value' es un número en el frontend por si el backend aún envía strings
                    data.data = data.data.map(item => ({
                        label: item.label,
                        value: Number(item.value) // 🔥 Convertir a número explícitamente
                    }));

                    xAxisUser.data.setAll(data.data);
                    seriesUser.data.setAll(data.data);
                } else {
                    console.error("❌ No hay datos para mostrar");
                }
            })
            .catch(error => console.error("❌ Error en AJAX:", error));


        // 📌 Animaciones
        seriesUser.appear(1000);
        chartUser.appear(1000, 100);


        // 📌 Gráfico #6: Progreso de Tickets

        var rootPareto = am5.Root.new("paretoChart");
        rootPareto.setThemes([am5themes_Animated.new(rootPareto)]);

        var chartPareto = rootPareto.container.children.push(
            am5xy.XYChart.new(rootPareto, {
                panX: true,
                panY: false,
                wheelX: "panX",
                wheelY: "zoomX",
                layout: rootPareto.verticalLayout
            })
        );

        // 📌 Ejes X y Y (Tickets)
        var xAxisPareto = chartPareto.xAxes.push(
            am5xy.CategoryAxis.new(rootPareto, {
                categoryField: "category",
                renderer: am5xy.AxisRendererX.new(rootPareto, {
                    minGridDistance: 30
                })
            })
        );

        var yAxisPareto = chartPareto.yAxes.push(
            am5xy.ValueAxis.new(rootPareto, {
                min: 0,
                extraMax: 0.2, // Espacio extra para la etiqueta
                renderer: am5xy.AxisRendererY.new(rootPareto, {})
            })
        );

        // 📌 **Serie de Barras (Tickets por Estado)**
        var seriesBarsPareto = chartPareto.series.push(
            am5xy.ColumnSeries.new(rootPareto, {
                name: "Tickets por Estado",
                xAxis: xAxisPareto,
                yAxis: yAxisPareto,
                valueYField: "value",
                categoryXField: "category",
                tooltip: am5.Tooltip.new(rootPareto, {
                    labelText: "{category}: {valueY} tickets"
                })
            })
        );

        // 📌 **Agregar etiquetas dentro de las barras con la cantidad de tickets**
        seriesBarsPareto.bullets.push(function(root, series, dataItem) {
            return am5.Bullet.new(root, {
                locationY: 0.5,
                sprite: am5.Label.new(root, {
                    text: dataItem.get("valueY")
                        .toString(), // 🔥 Se obtiene correctamente el valor
                    fill: am5.color(0x000000), // Negro
                    centerX: am5.percent(50),
                    centerY: am5.percent(50),
                    fontSize: 14,
                    fontWeight: "bold"
                })
            });
        });

        // 📌 **Cargar datos dinámicamente**
        fetch("/app/Controllers/InicioController.php?action=getTicketsPareto")
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    xAxisPareto.data.setAll(data.data);
                    seriesBarsPareto.data.setAll(data.data);
                } else {
                    console.error("❌ Error al obtener datos:", data.message);
                }
            })
            .catch(error => console.error("❌ Error en AJAX:", error));

        chartPareto.appear(1000, 100);

    });
    </script>

    <script>
    const icono = document.querySelector('#menu_inicio').previousElementSibling.querySelector('i');
    const span = document.getElementById('menu_inicio');

    icono.style.color = 'white';
    span.style.color = 'white';
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="/public/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/public/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="/public/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/public/assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="/public/assets/js/charts-ra.js"></script>
    <script src="/Kimav/Kima2/assets/js/widgets.bundle.js"></script>
    <script src="/public/assets/js/custom/widgets.js"></script>
    <script src="/public/assets/js/custom/apps/chat/chat.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/create-project/type.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/create-project/budget.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/create-project/settings.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/create-project/team.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/create-project/targets.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/create-project/files.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/create-project/complete.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/create-project/main.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/new-address.js"></script>
    <script src="/public/assets/js/custom/utilities/modals/users-search.js"></script>

    <script>
    var hostUrl = "/public/assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="/public/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/public/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="/public/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
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