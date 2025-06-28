<?php
$title = "Comunicados"; // Título dinámico
include '../../layout.php'; // Asegúrate de que la ruta sea correcta


require_once "../../config/database.php"; // Asegura que este archivo tiene la conexión a SQL Server

try {
    // Consulta para obtener el total de registros y la suma del tamaño de los archivos
    $query = "SELECT COUNT(id) AS total_archivos, SUM(tamaño) AS total_tamano FROM archivos";
    $stmt = $conn->query($query);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Extraer valores
    $totalArchivos = $resultado['total_archivos'];
    $totalTamanoGB = round(($resultado['total_tamano'] / (1024 * 1024)), 2); // Convertir KB a GB y redondear a 2 decimales
} catch (PDOException $e) {
    die("Error al obtener datos: " . $e->getMessage());
}

try {
    // Consulta para obtener el total de registros y la suma del tamaño de los archivos
    $query = "SELECT COUNT(id) AS total_carpetas FROM carpetas";
    $stmt = $conn->query($query);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Extraer valores
    $totalCarpeta = $resultado['total_carpetas'];
} catch (PDOException $e) {
    die("Error al obtener datos: " . $e->getMessage());
}


?>
<html lang="en">

<body>
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <!--begin::Title-->
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bell fs-2 me-2"></i>
                            <h1 class="page-heading text-gray-900 fw-bold fs-3 my-0">Comunicados Emitidos</h1>
                        </div>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="index.html" class="text-muted text-hover-primary">Ministerio de Salud</a>
                            </li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                </div>
                <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Card-->
                    <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10"
                        style="background-size: auto calc(100% + 10rem); background-position-x: 100%; background-image: url('/Kima/assets/media/illustrations/sketchy-1/4.png')">
                        <!--begin::Card header-->
                        <div class="card-header pt-10">
                            <div class="d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="symbol symbol-circle me-5">
                                    <div
                                        class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                                        <i class="ki-duotone ki-abstract-47 fs-2x text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Title-->
                                <div class="d-flex flex-column">
                                    <h2 class="mb-1">Gestión de Carpetas</h2>
                                    <div class="text-muted fw-bold">
                                        <span class="mx-3"></span><?= $totalTamanoGB ?>
                                        <span class="mx-3">|</span><?= $totalCarpeta ?> items
                                    </div>
                                </div>
                                <!--end::Title-->
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pb-0">
                            <!--begin::Navs-->
                            <div class="d-flex overflow-auto h-55px">
                                <ul
                                    class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-semibold flex-nowrap">
                                    <!--begin::Nav item-->
                                    <li class="nav-item">
                                        <a class="nav-link text-active-primary me-6"
                                            href="Views/Comunicados.php">Archivos</a>
                                    </li>
                                    <!--end::Nav item-->
                                    <!--begin::Nav item-->
                                    <li class="nav-item">
                                        <a class="nav-link text-active-primary me-6 active"
                                            href="Views/ComunicadosFolders.php">Carpetas</a>
                                    </li>
                                    <!--end::Nav item-->
                                </ul>
                            </div>
                            <!--begin::Navs-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Card-->
                    <div class="card card-flush">
                        <!--begin::Card header-->
                        <div class="card-header pt-8">
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" data-kt-filemanager-table-filter="search"
                                        class="form-control form-control-solid w-300px ps-15"
                                        placeholder="Buscar Archivos & Carpetas" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">
                                    <button class="btn btn-flex btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalCrearCarpeta">
                                        <i class="ki-duotone ki-add-folder fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Nueva Carpeta
                                    </button>
                                </div>

                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Table-->
                            <div id="contenedorCarpetasAcordeon" class="table-responsive mt-4"></div>

                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

    <!-- Modal HTML simplificado -->
    <div class="modal fade" id="modalCrearCarpeta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formCrearCarpetaConArchivos" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Carpeta con Archivos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" class="form-control mb-3" name="nombre" placeholder="Nombre de la carpeta"
                        required>
                    <input type="hidden" id="carpetaCreadaId" name="carpeta_id">


                    <label for="archivosExistentes">Seleccionar archivos existentes:</label>
                    <select id="archivosExistentes" name="archivos[]" multiple class="form-select"
                        style="height: 150px;">
                        <!-- Se llenará por AJAX -->
                    </select>
                    <small class="form-text text-muted">Usa Ctrl (o Cmd en Mac) para seleccionar varios
                        archivos.</small>

                    <br>


                    <label class="mt-4">Subir nuevos archivos (opcional):</label>
                    <input type="file" name="archivo[]" multiple class="form-control" accept=".pdf">
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Crear Carpeta y Asociar Archivos</button>
                </div>
            </form>
        </div>
    </div>

    </div>
    <!--end::Modal - Invite Friend-->
    <!--end::Modals-->
    <!--begin::Javascript-->
    <script>
    // ✅ Ejecutar la carga cuando el DOM esté listo
    $(document).ready(function() {
        cargarCarpetasTipoAcordeon();
    });

    function cargarCarpetasTipoAcordeon() {
        $.ajax({
            url: "/Kima/Kima2/app/Controllers/ComunicadosController.php?action=obtenerCarpetasConArchivos",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    let html = `<table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Tamaño</th>
                            <th>Fecha de creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>`;

                    response.data.forEach((carpeta, index) => {
                        html += `
                    <tr>
                        <td class="w-25px align-middle text-center">
                            <button class="btn btn-sm btn-icon btn-primary btn-toggle-carpeta" data-index="${index}">
                                <span class="fw-bold">+</span>
                            </button>
                        </td>
                        <td class="align-middle" ><i class="fas fa-folder text-primary me-2"></i> ${carpeta.nombre}</td>
                        <td class="align-middle">-</td>
                        <td class="align-middle">${carpeta.fecha_creacion}</td>
                        <td class="align-middle">
                            <div class="dropdown">
    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        ⋯
    </button>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item btn-renombrar-carpeta" href="#" data-id="${carpeta.id}" data-nombre="${carpeta.nombre}">
                ✏️ Renombrar
            </a>
        </li>
        <li>
            <a class="dropdown-item text-danger btn-eliminar-carpeta" href="#" data-id="${carpeta.id}">
                🗑️ Eliminar
            </a>
        </li>
        <li>
            <button class="dropdown-item btn-copiar-enlace-carpeta" data-enlace="${carpeta.ruta}">
                🔗 Copiar Enlace
            </button>
        </li>
    </ul>
</div>

                        </td>
                    </tr>
                    <tr class="contenido-carpeta" style="display:none;" data-index="${index}">
                        <td></td>
                        <td colspan="4">
                            <ul class="list-group">`;

                        if (carpeta.archivos.length > 0) {
                            carpeta.archivos.forEach(archivo => {
                                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="${archivo.ruta}" target="_blank">📄 ${archivo.nombre}</a>
                            </li>`;
                            });
                        } else {
                            html += `<li class="list-group-item text-muted">Sin archivos</li>`;
                        }

                        html += `</ul>
                        </td>
                    </tr>`;
                    });

                    html += `</tbody></table>`;
                    $("#contenedorCarpetasAcordeon").html(html);
                }
            }
        });
    }

    $('#modalCrearCarpeta').on('shown.bs.modal', function() {
        const $select = $('#archivosExistentes');
        $select.empty(); // Limpiar

        $.ajax({
            url: '/Kima/Kima2/app/Controllers/ComunicadosController.php?action=listarArchivos',
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    res.data.forEach(archivo => {
                        $select.append(
                            `<option value="${archivo.id}">${archivo.nombre}</option>`
                        );
                    });
                } else {
                    alert("❌ No se pudieron cargar los archivos");
                }
            },
            error: function(err) {
                console.error("❌ Error AJAX:", err);
            }
        });
    });


    $('#formCrearCarpetaConArchivos').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);


        $.ajax({
            url: '/Kima/Kima2/app/Controllers/ComunicadosController.php?action=crearCarpetaConArchivos',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                const response = JSON.parse(res);
                if (response.status === 'success') {
                    alert('✅ Carpeta creada con éxito');

                    // Asigna el ID a un campo oculto
                    $('#carpetaCreadaId').val(response.carpeta_id);

                    // Si hay archivos nuevos seleccionados, subirlos con carpeta_id
                    let archivosNuevos = $('input[name="archivo[]"]')[0].files;
                    if (archivosNuevos.length > 0) {
                        for (let i = 0; i < archivosNuevos.length; i++) {
                            const archivo = archivosNuevos[i];
                            const formData = new FormData();
                            formData.append("archivo", archivo);
                            formData.append("carpeta_id", response.carpeta_id);


                            let archivosInvalidos = Array.from(archivosNuevos).filter(file => !file
                                .name.endsWith('.pdf'));
                            if (archivosInvalidos.length > 0) {
                                alert("❌ Solo se permiten archivos PDF. Archivo inválido: " +
                                    archivosInvalidos[0].name);
                                return;
                            }

                            $.ajax({
                                url: "/Kima/Kima2/app/Controllers/ComunicadosController.php?action=subirArchivo",
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(subidaRes) {
                                    const res = JSON.parse(subidaRes);
                                    if (res.status === "success") {
                                        console.log("✅ Archivo subido con carpeta:",
                                            archivo.name);
                                    } else {
                                        console.error("❌ Archivo no subido:", archivo
                                            .name);
                                    }
                                },
                                error: function() {
                                    console.error("❌ Error subiendo archivo:", archivo
                                        .name);
                                }
                            });
                        }
                    }

                    $('#modalCrearCarpeta').modal('hide');
                    location.reload();
                } else {
                    alert('❌ Error: ' + response.message);
                }
            }
        });
    });


    // 📌 Evento para copiar enlace de la carpeta
    $(document).on("click", ".btn-copiar-enlace-carpeta", function(e) {
        e.preventDefault();

        const enlaceRelativo = $(this).data("enlace");
        const url = window.location.origin + enlaceRelativo;

        // Copiar al portapapeles
        navigator.clipboard.writeText(url).then(() => {
            mostrarToastCorto("✅ Enlace de carpeta copiado");
        }).catch(err => {
            alert("❌ Error al copiar enlace");
        });
    });

    // ✅ Mostrar un pequeño modal/toast por 2 segundos
    function mostrarToastCorto(mensaje) {
        const toast = $(`
        <div class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-4" role="alert" aria-live="assertive" aria-atomic="true" style="z-index:9999;">
            <div class="d-flex">
                <div class="toast-body">${mensaje}</div>
            </div>
        </div>
    `);

        $("body").append(toast);
        const bsToast = new bootstrap.Toast(toast[0], {
            delay: 2000
        });
        bsToast.show();

        // Eliminar luego de ocultarse
        toast.on("hidden.bs.toast", function() {
            toast.remove();
        });
    }


    $(document).on("click", ".btn-renombrar-carpeta", function(e) {
        e.preventDefault();

        const id = $(this).data("id");
        const nombreActual = $(this).data("nombre");

        const nuevoNombre = prompt("📁 Nuevo nombre para la carpeta:", nombreActual);

        if (nuevoNombre && nuevoNombre !== nombreActual) {
            $.ajax({
                url: "/Kima/Kima2/app/Controllers/ComunicadosController.php?action=renombrarComunicado",
                type: "POST",
                data: {
                    id: id,
                    nombre: nuevoNombre,
                    tipo: "carpeta"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert("✅ Carpeta renombrada correctamente.");
                        cargarCarpetasTipoAcordeon(); // Recarga la tabla
                    } else {
                        alert("❌ No se pudo renombrar: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("❌ Error al renombrar carpeta:", error);
                    alert("❌ Hubo un error al procesar la solicitud.");
                }
            });
        }
    });

    $(document).on("click", ".btn-eliminar-carpeta", function(e) {
        e.preventDefault();

        const id = $(this).data("id");

        if (confirm(
                "⚠️ ¿Estás seguro de que deseas eliminar esta carpeta y los archivos dentro de la misma?")) {
            $.ajax({
                url: "/Kima/Kima2/app/Controllers/ComunicadosController.php?action=eliminarComunicado",
                type: "POST",
                data: {
                    id: id,
                    tipo: "carpeta"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert("✅ Carpeta eliminada correctamente.");
                        cargarCarpetasTipoAcordeon(); // Recargar acordeón
                    } else {
                        alert("❌ No se pudo eliminar: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("❌ Error al eliminar carpeta:", error);
                    alert("❌ Hubo un error al procesar la solicitud.");
                }
            });
        }
    });



    // Evento para abrir/cerrar acordeón
    $(document).on("click", ".btn-toggle-carpeta", function() {
        const index = $(this).data("index");
        const $contenido = $(`.contenido-carpeta[data-index="${index}"]`);
        const $btn = $(this);

        $contenido.toggle();
        $btn.find("span").text($contenido.is(":visible") ? "-" : "+");
    });
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="/Kima/Kima2/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/Kima/Kima2/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="/Kima/Kima2/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="/Kima/Kima2/assets/js/custom/apps/file-manager/list.js"></script>
    <script src="/Kima/Kima2/assets/js/widgets.bundle.js"></script>
    <script src="/Kima/Kima2/assets/js/custom/widgets.js"></script>
    <script src="/Kima/Kima2/assets/js/custom/apps/chat/chat.js"></script>
    <script src="/Kima/Kima2/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="/Kima/Kima2/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="/Kima/Kima2/assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>