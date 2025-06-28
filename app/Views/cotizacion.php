<?php
$title = "Cotizacion"; // Título dinámico
include '../../layout.php'; // Asegúrate de que la ruta sea correcta
?>

<style>
#clientes-container {
    display: none;
    /* Ocultar tabla por defecto */
}

.dataTables_filter {
    display: none !important;
}

.title_coti_show {
    color: blue !important;
    font-weight: 700 !important;
}

.box-shadow {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    border-radius: 6px;
    padding: 15px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
}
</style>




<html lang="en">

<body>
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->

            <div class="modal fade" id="modalCotizacion" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Crear Cotización</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="cliente" class="form-label">Cliente:</label>
                                <input type="hidden" id="cliente_id">
                                <input type="text" id="search" class="form-control mt-2"
                                    placeholder="Escribe para buscar el cliente">
                                <div id="clientes-container">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Empresa</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody id="clientes-list">
                                            <!-- Aquí se mostrarán los resultados -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="producto" class="form-label">Producto:</label>
                                <input type="text" id="searchProducto" class="form-control mt-2"
                                    placeholder="Escribe para buscar un producto">
                                <div id="productos-container" style="display: none;">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Precio</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productos-list">
                                            <!-- Aquí se mostrarán los productos encontrados -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listaProductos">
                                    <!-- Aquí se agregarán los productos seleccionados -->
                                </tbody>
                            </table>

                            <h4>Subtotal: $<span id="subtotal">0.00</span></h4>
                            <h4>IVA (13%): $<span id="iva">0.00</span></h4>
                            <h3>Total: $<span id="total">0.00</span></h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="cancelarCotizacion">Cancelar</button>
                            <button class="btn btn-success" id="guardarCotizacion">Guardar Cotización</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3"
                    style="margin-top: 0; padding-top: 0;">
                    <!--begin::Title-->
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-invoice fs-2 me-2"></i>
                        <h1 class="page-heading text-gray-900 fw-bold fs-3 my-0">Cotización</h1>
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
                        <li class="breadcrumb-item text-muted">Cotización</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Breadcrumb-->
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Agregar Cotización-->

                    <a class="btn btn-sm fw-bold btn-primary" id="btnAbrirModal">
                        <i class="fa-solid fa-plus"></i>Agregar Cotización
                    </a>
                    <!--end::Agregar Cotización-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card card-flush">
                    <div class="card-header pt-8">
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="fa-solid fa-magnifying-glass position-absolute ms-3"></i>
                                <input type="text" id="customSearch"
                                    class="form-control form-control-solid w-250px ps-10"
                                    placeholder="Buscar cotización" />
                            </div>
                            <!--end::Search-->
                        </div>
                    </div>
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Cotización Table-->
                        <table id="kt_quote_list" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">ID</th>
                                    <th class="min-w-150px">Cliente</th>
                                    <th class="min-w-125px">Descripción</th>
                                    <th class="w-125px">Monto</th>
                                    <th class="w-125px">Fecha</th>
                                    <th class="min-w-150px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">

                            </tbody>
                        </table>
                        <!--end::Cotización Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
    </div>
    <!--end::Main-->
    <!-- MODAL PARA EDITAR COTIZACION -->
    <div class="modal fade" id="modalEditarCotizacion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Cotización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="cotizacion_id">

                    <div class="mb-3">
                        <label for="cliente_editar" class="form-label">Cliente:</label>
                        <input type="hidden" id="cliente_id_editar">
                        <input type="text" id="search_editar" class="form-control mt-2" placeholder="Buscar cliente">
                        <div id="clientes-container-editar" style="display:none">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Empresa</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody id="clientes-list-editar"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="producto_editar" class="form-label">Producto:</label>
                        <input type="text" id="searchProductoEditar" class="form-control mt-2"
                            placeholder="Buscar producto">
                        <div id="productos-container-editar" style="display:none">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody id="productos-list-editar"></tbody>
                            </table>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="listaProductosEditar"></tbody>
                    </table>

                    <h4>Subtotal: $<span id="subtotal_editar">0.00</span></h4>
                    <h4>IVA (13%): $<span id="iva_editar">0.00</span></h4>
                    <h3>Total: $<span id="total_editar">0.00</span></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary" id="guardarCambiosCotizacion">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVerCotizacion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle de Cotización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="box-shadow">
                        <p><strong>Cliente:</strong> <span id="ver_cliente"></span></p>
                        <p><strong>Fecha:</strong> <span id="ver_fecha"></span></p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="title_coti_show">Producto</th>
                                    <th class="title_coti_show">Cantidad</th>
                                    <th class="title_coti_show">Precio</th>
                                    <th class="title_coti_show">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="ver_productos"></tbody>
                        </table>
                    </div>
                    <div class="box-shadow">
                        <h4>Subtotal: $<span id="ver_subtotal">0.00</span></h4>
                        <h4>IVA (13%): $<span id="ver_iva">0.00</span></h4>
                        <h3>Total: $<span id="ver_total">0.00</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--begin::Modal para Agregar Cotización-->
    <div class="modal fade" id="kt_modal_add_quote" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Agregar Nueva Cotización</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="create_quote.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre_cliente" class="form-label">Nombre del Cliente</label>
                            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" class="form-control" id="monto" name="monto" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cotización</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal-->
    <!-- ✅ jQuery (necesario para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ✅ Bootstrap JS (opcional pero común si usas modales, etc) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ DataTables core -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <!-- ✅ DataTables Bootstrap 5 (opcional si quieres integrarlo con estilos Bootstrap) -->
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- ✅ DataTables CSS (en el `<head>` si aún no está) -->
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!--begin::Javascript-->
    <script>
    $(document).ready(function() {


        $(document).on("click", ".verCotizacion", function() {
            const id = $(this).data("id");

            $.ajax({
                url: `/Kima/Kima2/app/Controllers/CotizacionesController.php?action=obtenerCotizacion&id=${id}`,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        const cot = response.cotizacion;
                        const productos = response.productos;

                        $("#ver_cliente").text(
                            `${cot.cliente_nombre} - ${cot.cliente_empresa}`);
                        $("#ver_fecha").text(cot.fecha_creacion);
                        $("#ver_subtotal").text(parseFloat(cot.subtotal).toLocaleString(
                            "es-CR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));

                        $("#ver_iva").text(parseFloat(cot.iva).toLocaleString("es-CR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));

                        $("#ver_total").text(parseFloat(cot.total).toLocaleString("es-CR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));


                        let html = "";
                        productos.forEach(prod => {
                            html += `<tr>
                        <td>${prod.nombre_producto}</td>
                        <td>${prod.cantidad}</td>
                        <td>₡${parseFloat(prod.precio).toLocaleString("es-CR", { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td>₡${parseFloat(prod.subtotal).toLocaleString("es-CR", { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>

                    </tr>`;
                        });
                        $("#ver_productos").html(html);

                        $("#modalVerCotizacion").modal("show");
                    } else {
                        alert("No se pudo cargar la cotización.");
                    }
                }
            });
        });


        // Confirmar cancelación de la cotización
        $("#cancelarCotizacion").on("click", function() {
            if (confirm(
                    "¿Estás seguro que deseas cancelar la cotización actual? Se perderán todos los datos ingresados."
                )) {
                // Limpiar datos del formulario
                $("#cliente_id").val("");
                $("#search").val("");
                $("#clientes-container").hide();
                $("#clientes-list").empty();

                listaProductos = [];
                actualizarTabla();

                // Cerrar el modal
                $("#modalCotizacion").modal("hide");
            }
        });


        let listaProductosEditar = [];

        // Buscar clientes
        $("#search").on("keyup", function() {
            let query = $(this).val().trim();

            if (query.length < 2) {
                $("#clientes-container").hide();
                $("#clientes-list").html("");
                return;
            }

            $.ajax({
                url: "/Kima/Kima2/app/Controllers/CotizacionesController.php?action=buscarClientes",
                type: "POST",
                data: {
                    query: query
                },
                dataType: "json",
                success: function(data) {
                    let html = "";
                    data.forEach(function(cliente) {
                        html += `<tr class="cliente-item" data-id="${cliente.id}" data-nombre="${cliente.nombre}" data-empresa="${cliente.empresa}">
                        <td>${cliente.nombre}</td>
                        <td>${cliente.empresa}</td>
                        <td>${cliente.email}</td>
                    </tr>`;
                    });

                    if (data.length > 0) {
                        $("#clientes-list").html(html);
                        $("#clientes-container").show();
                    } else {
                        $("#clientes-container").hide();
                    }
                }
            });
        });

        $(document).on("click", ".editarCotizacion", function() {
            const id = $(this).data("id");

            $.ajax({
                url: `/Kima/Kima2/app/Controllers/CotizacionesController.php?action=obtenerCotizacion&id=${id}`,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        const cot = response.cotizacion;
                        const productos = response.productos;

                        console.log('cliente', response.cotizacion);

                        $("#cotizacion_id").val(cot.id);
                        $("#cliente_id_editar").val(cot.cliente_id);
                        $("#search_editar").val(
                            `${cot.cliente_nombre} - ${cot.cliente_empresa}`);

                        listaProductosEditar = productos.map(p => ({
                            id: p.producto_id,
                            nombre: p.nombre_producto,
                            cantidad: parseInt(p.cantidad),
                            precio: parseFloat(p.precio),
                            subtotal: parseFloat(p.subtotal)
                        }));

                        actualizarTablaEditar();
                        $("#modalEditarCotizacion").modal("show");
                    } else {
                        alert("No se pudo cargar la cotización.");
                    }
                }
            });
        });

        function actualizarTablaEditar() {
            let html = "";
            let subtotalGeneral = 0;

            listaProductosEditar.forEach((producto, index) => {
                subtotalGeneral += producto.subtotal;

                html += `<tr>
            <td>${producto.id}</td>
            <td>${producto.nombre}</td>
            <td><input type="number" class="form-control cantidadProductoEditar" data-index="${index}" value="${producto.cantidad}" min="1"></td>
            <td>${producto.precio.toFixed(2)}</td>
            <td>$${producto.subtotal.toFixed(2)}</td>
            <td><button class="btn btn-danger btn-sm eliminarProductoEditar" data-index="${index}">X</button></td>
        </tr>`;
            });

            $("#listaProductosEditar").html(html);

            let iva = subtotalGeneral * 0.13;
            let total = subtotalGeneral + iva;

            $("#subtotal_editar").text(subtotalGeneral.toFixed(2));
            $("#iva_editar").text(iva.toFixed(2));
            $("#total_editar").text(total.toFixed(2));
        }

        $(document).on("click", ".eliminarProductoEditar", function() {
            let index = $(this).data("index");
            listaProductosEditar.splice(index, 1);
            actualizarTablaEditar();
        });

        $(document).on("change", ".cantidadProductoEditar", function() {
            let index = $(this).data("index");
            let nuevaCantidad = parseInt($(this).val());
            if (nuevaCantidad < 1) nuevaCantidad = 1;

            listaProductosEditar[index].cantidad = nuevaCantidad;
            listaProductosEditar[index].subtotal = listaProductosEditar[index].precio * nuevaCantidad;
            actualizarTablaEditar();
        });


        $("#guardarCambiosCotizacion").on("click", function() {
            let cotizacion_id = $("#cotizacion_id").val();
            let cliente_id = $("#cliente_id_editar").val();
            let subtotal = parseFloat($("#subtotal_editar").text());
            let iva = parseFloat($("#iva_editar").text());
            let total = parseFloat($("#total_editar").text());

            if (!cliente_id || listaProductosEditar.length === 0) {
                alert("Debe seleccionar un cliente y al menos un producto.");
                return;
            }

            let productos = JSON.stringify(listaProductosEditar);

            $.ajax({
                url: "/Kima/Kima2/app/Controllers/CotizacionesController.php?action=actualizarCotizacion",
                type: "POST",
                data: {
                    cotizacion_id,
                    cliente_id,
                    subtotal,
                    iva,
                    total,
                    productos
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert("Cotización actualizada correctamente.");
                        $("#modalEditarCotizacion").modal("hide");
                        cargarCotizaciones();
                    } else {
                        alert("Error al actualizar.");
                    }
                }
            });
        });





        // Seleccionar cliente
        $(document).on("click", ".cliente-item", function() {
            let clienteId = $(this).data("id"); // Obtener el ID del cliente
            let nombreCliente = $(this).data("nombre");
            let empresaCliente = $(this).data("empresa");

            // Colocar el ID en el input oculto
            $("#cliente_id").val(clienteId);

            // Mostrar "Nombre - Empresa" en el input de búsqueda
            $("#search").val(`${nombreCliente} - ${empresaCliente}`);

            // Ocultar la tabla de clientes
            $("#clientes-container").hide();
        });

        // Buscar clientes en el modal de edición
        $("#search_editar").on("keyup", function() {
            let query = $(this).val().trim();

            if (query.length < 2) {
                $("#clientes-container-editar").hide();
                $("#clientes-list-editar").html("");
                return;
            }

            $.ajax({
                url: "/Kima/Kima2/app/Controllers/CotizacionesController.php?action=buscarClientes",
                type: "POST",
                data: {
                    query
                },
                dataType: "json",
                success: function(data) {
                    let html = "";
                    data.forEach(function(cliente) {
                        html += `<tr class="cliente-item-editar" data-id="${cliente.id}" data-nombre="${cliente.nombre}" data-empresa="${cliente.empresa}">
                    <td>${cliente.nombre}</td>
                    <td>${cliente.empresa}</td>
                    <td>${cliente.email}</td>
                </tr>`;
                    });

                    if (data.length > 0) {
                        $("#clientes-list-editar").html(html);
                        $("#clientes-container-editar").show();
                    } else {
                        $("#clientes-container-editar").hide();
                    }
                }
            });
        });

        // Seleccionar cliente en edición
        $(document).on("click", ".cliente-item-editar", function() {
            let clienteId = $(this).data("id");
            let nombreCliente = $(this).data("nombre");
            let empresaCliente = $(this).data("empresa");

            $("#cliente_id_editar").val(clienteId);
            $("#search_editar").val(`${nombreCliente} - ${empresaCliente}`);
            $("#clientes-container-editar").hide();
        });


        // Buscar productos
        let listaProductos = [];

        // Buscar productos
        $("#searchProducto").on("keyup", function() {
            let query = $(this).val().trim();

            if (query.length < 2) {
                $("#productos-container").hide();
                $("#productos-list").html("");
                return;
            }

            $.ajax({
                url: "/Kima/Kima2/app/Controllers/CotizacionesController.php?action=buscarProductos",
                type: "POST",
                data: {
                    query: query
                },
                dataType: "json",
                success: function(data) {

                    console.log('datos', data);
                    let html = "";
                    data.forEach(function(producto) {
                        html += `<tr class="producto-item" data-id="${producto.ID}" data-nombre="${producto.Nombre}" data-precio="${producto.Costo}">
                                <td>${producto.Nombre}</td>
                                <td>${producto.Costo}</td>
                            </tr>`;
                    });

                    if (data.length > 0) {
                        $("#productos-list").html(html);
                        $("#productos-container").show();
                    } else {
                        $("#productos-container").hide();
                    }
                }
            });
        });

        // Seleccionar producto y agregarlo o incrementar cantidad si ya existe
        $(document).on("click", ".producto-item", function() {
            let idProducto = parseFloat($(this).data("id"));
            let nombreProducto = $(this).data("nombre");
            let precioProducto = parseFloat($(this).data("precio"));

            // Buscar si el producto ya está en la lista
            let productoExistente = listaProductos.find(producto => producto.nombre === nombreProducto);

            if (productoExistente) {
                // Si el producto ya existe, aumentar la cantidad
                productoExistente.cantidad += 1;
                productoExistente.subtotal = productoExistente.cantidad * productoExistente.precio;
            } else {
                // Si el producto no existe, agregarlo a la lista
                listaProductos.push({
                    id: idProducto,
                    nombre: nombreProducto,
                    cantidad: 1,
                    precio: precioProducto,
                    subtotal: precioProducto
                });
            }

            actualizarTabla();
            $("#productos-container").hide();
            $("#searchProducto").val(""); // Limpiar el input
        });

        // Buscar productos en el modal de edición
        $("#searchProductoEditar").on("keyup", function() {
            let query = $(this).val().trim();

            if (query.length < 2) {
                $("#productos-container-editar").hide();
                $("#productos-list-editar").html("");
                return;
            }

            $.ajax({
                url: "/Kima/Kima2/app/Controllers/CotizacionesController.php?action=buscarProductos",
                type: "POST",
                data: {
                    query
                },
                dataType: "json",
                success: function(data) {
                    let html = "";
                    data.forEach(function(producto) {
                        html += `<tr class="producto-item-editar" data-id="${producto.ID}" data-nombre="${producto.Nombre}" data-precio="${producto.Costo}">
                    <td>${producto.Nombre}</td>
                    <td>${producto.Costo}</td>
                </tr>`;
                    });

                    if (data.length > 0) {
                        $("#productos-list-editar").html(html);
                        $("#productos-container-editar").show();
                    } else {
                        $("#productos-container-editar").hide();
                    }
                }
            });
        });

        // Seleccionar producto en edición
        $(document).on("click", ".producto-item-editar", function() {
            let idProducto = parseFloat($(this).data("id"));
            let nombreProducto = $(this).data("nombre");
            let precioProducto = parseFloat($(this).data("precio"));

            let productoExistente = listaProductosEditar.find(p => p.nombre === nombreProducto);

            if (productoExistente) {
                productoExistente.cantidad += 1;
                productoExistente.subtotal = productoExistente.cantidad * productoExistente.precio;
            } else {
                listaProductosEditar.push({
                    id: idProducto,
                    nombre: nombreProducto,
                    cantidad: 1,
                    precio: precioProducto,
                    subtotal: precioProducto
                });
            }

            actualizarTablaEditar();
            $("#productos-container-editar").hide();
            $("#searchProductoEditar").val("");
        });


        // Función para actualizar la tabla con los productos seleccionados
        function actualizarTabla() {
            let html = "";
            let subtotalGeneral = 0;

            listaProductos.forEach((producto, index) => {
                subtotalGeneral += producto.subtotal;

                html += `<tr>
                        <td>${producto.id}</td>
                        <td>${producto.nombre}</td>
                        <td><input type="number" class="form-control cantidadProducto" data-index="${index}" value="${producto.cantidad}" min="1"></td>
                        <td>${producto.precio.toFixed(2)}</td>
                        <td>$${producto.subtotal.toFixed(2)}</td>
                        <td><button class="btn btn-danger btn-sm eliminarProducto" data-index="${index}">X</button></td>
                    </tr>`;
            });

            $("#listaProductos").html(html);

            let iva = subtotalGeneral * 0.13;
            let total = subtotalGeneral + iva;

            $("#subtotal").text(subtotalGeneral.toFixed(2));
            $("#iva").text(iva.toFixed(2));
            $("#total").text(total.toFixed(2));
        }

        // Actualizar cantidad manualmente desde el input
        $(document).on("change", ".cantidadProducto", function() {
            let index = $(this).data("index");
            let nuevaCantidad = parseInt($(this).val());

            if (nuevaCantidad < 1) nuevaCantidad = 1;

            listaProductos[index].cantidad = nuevaCantidad;
            listaProductos[index].subtotal = listaProductos[index].precio * nuevaCantidad;

            actualizarTabla();
        });

        // Eliminar producto de la tabla
        $(document).on("click", ".eliminarProducto", function() {
            let index = $(this).data("index");
            listaProductos.splice(index, 1);
            actualizarTabla();
        });

        $(document).on("click", ".eliminarCotizacion", function() {
            const id = $(this).data("id");

            if (confirm(
                    "¿Estás seguro de que deseas eliminar esta cotización? Esta acción no se puede deshacer."
                )) {
                $.ajax({
                    url: "/Kima/Kima2/app/Controllers/CotizacionesController.php?action=eliminarCotizacion",
                    type: "POST",
                    data: {
                        id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            alert("Cotización eliminada correctamente.");
                            cargarCotizaciones
                                (); // Recargar la tabla sin refrescar la página
                        } else {
                            alert("Error al eliminar la cotización.");
                            console.error(response.message);
                        }
                    },
                    error: function() {
                        alert("Ocurrió un error inesperado al intentar eliminar.");
                    }
                });
            }
        });




        $("#btnAbrirModal").click(function() {
            $("#modalCotizacion").modal("show");
        });


        $("#guardarCotizacion").on("click", function() {
            let cliente_id = $("#cliente_id").val();
            let subtotal = parseFloat($("#subtotal").text());
            let iva = parseFloat($("#iva").text());
            let total = parseFloat($("#total").text());

            // Verificar si hay datos
            if (!cliente_id || listaProductos.length === 0) {
                alert("Debe seleccionar un cliente y al menos un producto.");
                return;
            }

            // Convertir lista de productos a JSON
            let productos = JSON.stringify(listaProductos);

            $.ajax({
                url: "/Kima/Kima2/app/Controllers/CotizacionesController.php?action=guardarCotizacion",
                type: "POST",
                data: {
                    cliente_id: cliente_id,
                    subtotal: subtotal,
                    iva: iva,
                    total: total,
                    productos: productos
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert("Cotización guardada correctamente.");
                        location.reload(); // Recargar la página
                    } else {
                        alert("Error al guardar la cotización.");
                    }
                }
            });
        });

        let table = $("#kt_quote_list").DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "/Kima/Kima2/app/Controllers/CotizacionesController.php?action=listarCotizaciones",
                "type": "GET",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return `
                    <a href="/Kima/Kima2/app/Views/clientes.php?id=${row.cliente_id}" class="btn btn-sm btn-link text-primary fw-semibold">
                        ${row.cliente}
                    </a>`;
                    }
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        return `Cotización N°${data}`;
                    }
                },
                {
                    "data": "total",
                    "render": function(data, type, row) {
                        return `$${data}`;
                    }
                },
                {
                    "data": "fecha_creacion"
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        return `
                            <button class='btn btn-icon btn-light-secondary me-2 verCotizacion' data-id="${data}">
                                <i class='fa-solid fa-eye'></i>
                            </button>
                            <a class='btn btn-icon btn-light-info me-2' href='/Kima/Kima2/app/Controllers/CotizacionesController.php?action=descargarPDF&id=${data}' target="_blank">
                                <i class='fa fa-file-pdf'></i>
                            </a>
                            <button class='btn btn-icon btn-light-primary me-2 editarCotizacion' data-id="${data}">
                                <i class='fa fa-pencil' aria-hidden='true'></i>
                            </button>
                            <button class='btn btn-icon btn-light-danger eliminarCotizacion' data-id="${data}">
                                <i class='fa-solid fa-trash'></i>
                            </button>`;
                    }
                }
            ],
            "paging": true,
            "searching": true,
            "info": true,
            "lengthMenu": [5, 10, 25, 50],
            "pageLength": 5,
            "ordering": true, // Permite ordenar columnas
            "order": [
                [4, "desc"]
            ],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });

        // 🔄 Función para recargar la tabla sin refrescar la página
        function cargarCotizaciones() {
            table.ajax.reload(null, false); // Recargar datos sin mover de página
        }

        $(document).on("keyup", "#customSearch", function() {
            if (table) {
                table.search(this.value).draw();
            }
        });

        const icono = document.querySelector('#menu_cotizacion').previousElementSibling.querySelector('i');
        const span = document.getElementById('menu_cotizacion');

        icono.style.color = 'white';
        span.style.color = 'white';

        const flexRootElementscolun = document.querySelectorAll('.flex-column-fluid');

        flexRootElementscolun.forEach(element => {
            element.setAttribute('style', 'flex: none !important;');
        });

        const flexRootElements = document.querySelectorAll('.flex-root');

        flexRootElements.forEach(element => {
            element.setAttribute('style', 'flex: 0 !important;');
        });

        const fkt_app_main = document.querySelectorAll('.app-main');

        fkt_app_main.forEach(element => {
            element.setAttribute('style', 'margin-top: 50px !important;');
        });

    });
    </script>
    <!--end::Javascript-->
</body>

</html>