<?php
$title = "Contactos"; // Título dinámico
include '../../layout.php'; // Asegúrate de que la ruta sea correcta

require_once "../../config/database.php";

$idCliente = $_GET['id'] ?? null;

if (!$idCliente) {
    die("❌ ID del contacto no proporcionado.");
}

try {
    $stmt = $conn->prepare("SELECT * FROM Tickets WHERE id = ?");
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
                                    <a href="/Kima/app/Views/Tickets.php" class="btn btn-light-primary fw-bold">
                                        <i class="fas fa-arrow-left me-2"></i> Volver
                                    </a>
                                </div>

                                <!--begin::Summary-->
                                <div class="d-flex flex-center flex-column mb-5">
                                    <!--begin::Avatar-->

                                    <!--end::Avatar-->

                                </div>

                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold">Datos del ticket</div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>

                                <div class="pb-5 fs-6">
                                    <div class="row">
                                        <!-- Columna 1 -->
                                        <div class="col-md-6">
                                            <div class="fw-bold mt-5">ID</div>
                                            <div class="text-gray-600" id="view-ticket-id"></div>

                                            <div class="fw-bold mt-5">Cliente</div>
                                            <div class="text-gray-600" id="view-ticket-cliente">
                                            </div>

                                            <div class="fw-bold mt-5">Producto</div>
                                            <div class="text-gray-600" id="view-ticket-producto">
                                            </div>

                                            <div class="fw-bold mt-5">Descripción</div>
                                            <div class="text-gray-600" id="view-ticket-descripcion">
                                            </div>


                                        </div>

                                        <!-- Columna 2 -->
                                        <div class="col-md-6">
                                            <div class="fw-bold mt-5">Responsable</div>
                                            <div class="text-gray-600" id="view-ticket-responsable">

                                            </div>

                                            <div class="fw-bold mt-5">Estado</div>
                                            <div class="text-gray-600" id="view-ticket-estado">
                                            </div>

                                            <div class="fw-bold mt-5">Fecha creación</div>
                                            <div class="text-gray-600" id="view-ticket-fecha-creacion"></div>

                                            <div class="fw-bold mt-5">Fecha finalización</div>
                                            <div class="text-gray-600" id="view-ticket-fecha-fin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul id="view-ticket-documentos" class="list-group mb-3"></ul>

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
    $(document).ready(function() {
        // ✅ Aquí colocás el ID del ticket que querés cargar automáticamente
        const ticketId = <?= isset($_GET['id']) ? $_GET['id'] : 'null' ?>;

        if (ticketId) {
            cargarTicket(ticketId);
        }
    });

    function obtenerColorEstado(estadoID) {
        switch (parseInt(estadoID)) {
            case 3:
                return "bg-primary"; // Cerrado
            case 2:
                return "bg-warning"; // En progreso
            case 5:
                return "bg-success"; // Abierto
            case 4:
                return "bg-info"; // Pendiente
            default:
                return "bg-dark"; // Estado desconocido
        }
    }

    function cargarTicket(ticketId) {
        $.ajax({
            url: `/Kima/app/Controllers/TicketController.php?action=obtenerTicketShow&id=${ticketId}`,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    let ticket = response.data;

                    console.log('View Ticket', ticket);

                    // Asignar los valores en el modal
                    $("#view-ticket-id").text(ticket.ID);
                    $("#view-ticket-cliente").text(ticket.Cliente);
                    $("#view-ticket-producto").text(ticket.TipoProducto);
                    $("#view-ticket-responsable").text(ticket.Responsable);
                    let estadoColor = obtenerColorEstado(ticket.EstadoID);
                    $("#view-ticket-estado").html(
                        `<span style="color: #fff;" class="badge ${estadoColor}">${ticket.Estado}</span>`
                    );
                    $("#view-ticket-fecha-creacion").text(ticket.FechaCreacion);
                    $("#view-ticket-fecha-fin").text(ticket.FechaFin ? ticket.FechaFin : "No finalizado");
                    $("#view-ticket-descripcion").text(ticket.Descripcion);

                    // Cargar documentos relacionados
                    $.ajax({
                        url: `/Kima/app/Controllers/TicketController.php?action=obtenerDocumentosPorTicket&ticket_id=${ticket.ID}`,
                        type: "GET",
                        dataType: "json",
                        success: function(docResponse) {
                            let documentosHTML = "";

                            if (docResponse.status === "success" && docResponse.data.length >
                                0) {
                                docResponse.data.forEach(doc => {
                                    documentosHTML += `
                                    <li class="list-group-item">
                                        <a href="${doc.RutaArchivo}" target="_blank">
                                            <i class="fa fa-file me-2"></i>${doc.NombreArchivo}
                                        </a>
                                    </li>`;
                                });
                            } else {
                                documentosHTML =
                                    `<li class="list-group-item text-muted">Sin documentos adjuntos</li>`;
                            }

                            $("#view-ticket-documentos").html(documentosHTML);
                        },
                        error: function() {
                            $("#view-ticket-documentos").html(
                                `<li class="list-group-item text-danger">Error al cargar documentos</li>`
                            );
                        }
                    });

                    // Mostrar el modal
                    $("#modalViewTicket").modal("show");

                } else {
                    alert("❌ Error al obtener los datos del ticket.");
                }
            },
            error: function() {
                alert("❌ Error en la petición AJAX.");
            }
        });
    }
    </script>


    <script>
    const icono = document.querySelector('#menu_tickets').previousElementSibling.querySelector('i');
    const span = document.getElementById('menu_tickets');

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