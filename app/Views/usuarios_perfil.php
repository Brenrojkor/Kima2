<?php
$title = "Usuario"; // Título dinámico
include '../../layout.php'; // Asegúrate de que la ruta sea correcta

require_once "../../config/database.php";

$idUsuario = $_GET['id'] ?? null;

if (!$idUsuario) {
    die("❌ ID del cliente no proporcionado.");
}

try {
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE ID = ?");
    $stmt->execute([$idUsuario]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        die("❌ Cliente no encontrado.");
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
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                        <!--begin::Card-->
                        <div class="card mb-5 mb-xl-8">
                            <!--begin::Card body-->
                            <div class="card-body pt-15">
                                <!--begin::Summary-->
                                <div class="d-flex flex-center flex-column mb-5">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-150px symbol-circle mb-7 position-relative">
                                        <img id="img_perfil"
                                            src="<?= $cliente['ImagenPerfil'] ? '/uploads/usuarios/' . $cliente['ImagenPerfil'] : '/public/assets/media/avatars/cuenta.png' ?>"
                                            alt="Perfil" class="w-100 h-100">

                                        <!-- Botón de lápiz -->
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-active-color-primary position-absolute top-0 end-0 mt-1 me-1"
                                            data-bs-toggle="modal" data-bs-target="#modalCambiarFoto">
                                            <i class="fa fa-pencil-alt fs-6"></i>
                                        </button>
                                    </div>

                                    <!--end::Avatar-->
                                    <!--begin::Name-->
                                    <a href="#"
                                        class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1"><?= htmlspecialchars($cliente['Nombre']) ?></a>
                                    <!--end::Name-->
                                    <!--begin::Email-->
                                    <a href="#"
                                        class="fs-5 fw-semibold text-muted text-hover-primary mb-6"><?= htmlspecialchars($cliente['Email']) ?></a>
                                    <!--end::Email-->
                                </div>
                                <!--end::Summary-->
                                <!--begin::Details toggle-->
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold">Perfil del Usuario</div>
                                    <!--begin::Badge-->

                                    <!--begin::Badge-->
                                </div>
                                <!--end::Details toggle-->
                                <div class="separator separator-dashed my-3"></div>
                                <!--begin::Details content-->
                                <div class="pb-5 fs-6">
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">ID</div>
                                    <div class="text-gray-600"><?= htmlspecialchars($cliente['ID']) ?></div>
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">Email</div>
                                    <div class="text-gray-600">
                                        <a href="#"
                                            class="text-gray-600 text-hover-primary"><?= htmlspecialchars($cliente['Email']) ?></a>
                                    </div>
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">ROL</div>
                                    <div class="text-gray-600"><?= htmlspecialchars($cliente['Rol']) ?>
                                    </div>
                                </div>
                                <!--end::Details content-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Sidebar-->
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid ms-lg-15">
                        <!--begin:::Tabs-->
                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8"
                            role="tablist">
                            <!--begin:::Tab item-->
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                    href="#kt_ecommerce_customer_overview" aria-selected="true" role="tab">General</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="/app/Views/Usuarios.php" class="boton-gris">Ir a listado</a>


                                <style>
                                .boton-gris {
                                    display: inline-block;
                                    padding: 10px 20px;
                                    font-size: 16px;
                                    color: white;
                                    background-color: gray;
                                    border: none;
                                    border-radius: 5px;
                                    text-decoration: none;
                                    text-align: center;
                                    cursor: pointer;
                                    transition: background-color 0.3s ease;
                                }

                                .boton-gris:hover {
                                    background-color: darkgray;
                                }
                                </style>
                            </li>
                            <li>
                                <button style="margin-left: 10px;" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalCambiarPassword">
                                    <i class="fa-solid fa-key"></i> Cambiar Contraseña
                                </button>
                            </li>
                            <!--end:::Tab item-->
                        </ul>
                        <!--end:::Tabs-->
                        <!--begin:::Tab content-->
                        <div class="tab-content" id="myTabContent">
                            <!--begin:::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_ecommerce_customer_overview" role="tabpanel">

                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Historial</h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0 pb-5">
                                        <!--begin::Table-->
                                        <div id="kt_table_customers_payment_wrapper"
                                            class="dt-container dt-bootstrap5 dt-empty-footer">
                                            <div id="" class="table-responsive">
                                                <table class="table align-middle table-row-dashed gy-5 dataTable"
                                                    id="kt_table_customers_payment" style="width: 100%;">
                                                    <colgroup>
                                                        <col data-dt-column="0" style="width: 115.891px;">
                                                        <col data-dt-column="1" style="width: 91.9531px;">
                                                        <col data-dt-column="3" style="width: 40.9219px;">
                                                    </colgroup>
                                                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                                        <tr class="text-start text-muted text-uppercase gs-0">
                                                            <th class="min-w-100px dt-orderable-asc dt-orderable-desc"
                                                                data-dt-column="0" rowspan="1" colspan="1"
                                                                aria-label="order No.: Activate to sort" tabindex="0">
                                                                <span class="dt-column-title" role="button">Número de
                                                                    Orden</span><span class="dt-column-order"></span>
                                                            </th>
                                                            <th data-dt-column="1" rowspan="1" colspan="1"
                                                                class="dt-orderable-asc dt-orderable-desc"
                                                                aria-label="Status: Activate to sort" tabindex="0"><span
                                                                    class="dt-column-title"
                                                                    role="button">Estado</span><span
                                                                    class="dt-column-order"></span></th>
                                                            <th class="min-w-100px dt-orderable-none" data-dt-column="4"
                                                                rowspan="1" colspan="1" aria-label="Date"><span
                                                                    class="dt-column-title">Date</span><span
                                                                    class="dt-column-order"></span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                                        <tr>
                                                            <td>
                                                                <a href="apps/ecommerce/sales/details.html"
                                                                    class="text-gray-600 text-hover-primary mb-1">#15819</a>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge badge-light-success">Completado</span>
                                                            </td>


                                                            <td>14 Dec 2020, 8:43 pm</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="apps/ecommerce/sales/details.html"
                                                                    class="text-gray-600 text-hover-primary mb-1">#15533</a>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge badge-light-success">Completado</span>
                                                            </td>


                                                            <td>01 Dec 2020, 10:12 am</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="apps/ecommerce/sales/details.html"
                                                                    class="text-gray-600 text-hover-primary mb-1">#14806</a>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge badge-light-success">Completado</span>
                                                            </td>


                                                            <td>12 Nov 2020, 2:01 pm</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="apps/ecommerce/sales/details.html"
                                                                    class="text-gray-600 text-hover-primary mb-1">#15887</a>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-light-warning">En
                                                                    Proceso</span>
                                                            </td>


                                                            <td>21 Oct 2020, 5:54 pm</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="apps/ecommerce/sales/details.html"
                                                                    class="text-gray-600 text-hover-primary mb-1">#15476</a>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge badge-light-success">Completado</span>
                                                            </td>


                                                            <td>19 Oct 2020, 7:32 am</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot></tfoot>
                                                </table>
                                            </div>
                                            <div id="" class="row">
                                                <div id=""
                                                    class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                                </div>
                                                <div id=""
                                                    class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                                    <div class="dt-paging paging_simple_numbers">
                                                        <nav aria-label="pagination">
                                                            <ul class="pagination">
                                                                <li class="dt-paging-button page-item disabled">
                                                                    <button class="page-link previous" role="link"
                                                                        type="button"
                                                                        aria-controls="kt_table_customers_payment"
                                                                        aria-disabled="true" aria-label="Previous"
                                                                        data-dt-idx="previous" tabindex="-1"><i
                                                                            class="previous"></i></button>
                                                                </li>
                                                                <li class="dt-paging-button page-item active">
                                                                    <button class="page-link" role="link" type="button"
                                                                        aria-controls="kt_table_customers_payment"
                                                                        aria-current="page" data-dt-idx="0">1</button>
                                                                </li>
                                                                <li class="dt-paging-button page-item">
                                                                    <button class="page-link" role="link" type="button"
                                                                        aria-controls="kt_table_customers_payment"
                                                                        data-dt-idx="1">2</button>
                                                                </li>
                                                                <li class="dt-paging-button page-item">
                                                                    <button class="page-link next" role="link"
                                                                        type="button"
                                                                        aria-controls="kt_table_customers_payment"
                                                                        aria-label="Next" data-dt-idx="next"><i
                                                                            class="next"></i></button>
                                                                </li>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>

                            <!--end:::Tab content-->
                        </div>
                        <!--end::Content-->
                    </div>

                    <!-- Modal Cambiar Contraseña -->
                    <div class="modal fade" id="modalCambiarPassword" tabindex="-1"
                        aria-labelledby="modalCambiarPasswordLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="formCambiarPassword">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Cambiar Contraseña</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Nueva Contraseña</label>
                                            <input type="password" class="form-control" name="nueva" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Confirmar Contraseña</label>
                                            <input type="password" class="form-control" name="confirmar" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Actualizar</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--end::Layout-->
                    <!--begin::Modals-->
                    <!--begin::Modal - New Address-->
                    <div class="modal fade" id="kt_modal_update_address" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Form-->
                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#"
                                    id="kt_modal_update_address_form">
                                    <!--begin::Modal header-->
                                    <div class="modal-header" id="kt_modal_update_address_header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bold">Actualizar Direccion</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div id="kt_modal_update_address_close"
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
                                    <div class="modal-body py-10 px-lg-17">
                                        <!--begin::Scroll-->
                                        <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                            id="kt_modal_update_address_scroll" data-kt-scroll="true"
                                            data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_update_address_header"
                                            data-kt-scroll-wrappers="#kt_modal_update_address_scroll"
                                            data-kt-scroll-offset="300px" style="max-height: 656px;">
                                            <!--begin::Billing toggle-->

                                            <!--end::Billing toggle-->
                                            <!--begin::Billing form-->
                                            <div id="kt_modal_update_address_billing_info" class="collapse show">
                                                <!--begin::Input group-->
                                                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold mb-2 required">Direccion
                                                        1</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid" placeholder=""
                                                        name="address1" value="101, Collins Street">
                                                    <!--end::Input-->
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="d-flex flex-column mb-7 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold mb-2">Address Line
                                                        2</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid" placeholder=""
                                                        name="address2">
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold mb-2 required">City /
                                                        Town</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid" placeholder=""
                                                        name="city" value="Melbourne">
                                                    <!--end::Input-->
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="row g-9 mb-7">
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-semibold mb-2 required">State
                                                            / Province</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input class="form-control form-control-solid" placeholder=""
                                                            name="state" value="Victoria">
                                                        <!--end::Input-->
                                                        <div
                                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        </div>
                                                        <div
                                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-semibold mb-2 required">Post
                                                            Code</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input class="form-control form-control-solid" placeholder=""
                                                            name="postcode" value="3000">
                                                        <!--end::Input-->
                                                        <div
                                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        </div>
                                                        <div
                                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Billing form-->
                                        </div>
                                        <!--end::Scroll-->
                                    </div>
                                    <!--end::Modal body-->
                                    <!--begin::Modal footer-->
                                    <div class="modal-footer flex-center">
                                        <!--begin::Button-->
                                        <button type="reset" id="kt_modal_update_address_cancel"
                                            class="btn btn-light me-3">Discard</button>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" id="kt_modal_update_address_submit"
                                            class="btn btn-primary">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                    <!--end::Modal footer-->
                                </form>
                                <!--end::Form-->
                            </div>
                        </div>
                    </div>
                    <!--end::Modal - New Address-->
                    <!--begin::Modal - Update password-->
                    <div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bold">Update Password</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                        data-kt-users-modal-action="close">
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
                                    <form id="kt_modal_update_password_form"
                                        class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                                        <!--begin::Input group=-->
                                        <div class="fv-row mb-10 fv-plugins-icon-container">
                                            <label class="required form-label fs-6 mb-2">Current
                                                Password</label>
                                            <input class="form-control form-control-lg form-control-solid"
                                                type="password" placeholder="" name="current_password"
                                                autocomplete="off">
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Input group=-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row fv-plugins-icon-container"
                                            data-kt-password-meter="true">
                                            <!--begin::Wrapper-->
                                            <div class="mb-1">
                                                <!--begin::Label-->
                                                <label class="form-label fw-semibold fs-6 mb-2">New
                                                    Password</label>
                                                <!--end::Label-->
                                                <!--begin::Input wrapper-->
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-lg form-control-solid"
                                                        type="password" placeholder="" name="new_password"
                                                        autocomplete="off">
                                                    <span
                                                        class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                        data-kt-password-meter-control="visibility">
                                                        <i class="ki-duotone ki-eye-slash fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                        <i class="ki-duotone ki-eye d-none fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </span>
                                                </div>
                                                <!--end::Input wrapper-->
                                                <!--begin::Meter-->
                                                <div class="d-flex align-items-center mb-3"
                                                    data-kt-password-meter-control="highlight">
                                                    <div
                                                        class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                                    </div>
                                                    <div
                                                        class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                                    </div>
                                                    <div
                                                        class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                                    </div>
                                                    <div
                                                        class="flex-grow-1 bg-secondary bg-active-success rounded h-5px">
                                                    </div>
                                                </div>
                                                <!--end::Meter-->
                                            </div>
                                            <!--end::Wrapper-->
                                            <!--begin::Hint-->
                                            <div class="text-muted">Use 8 or more characters with a mix of
                                                letters, numbers &amp; symbols.</div>
                                            <!--end::Hint-->
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Input group=-->
                                        <!--begin::Input group=-->
                                        <div class="fv-row mb-10 fv-plugins-icon-container">
                                            <label class="form-label fw-semibold fs-6 mb-2">Confirm New
                                                Password</label>
                                            <input class="form-control form-control-lg form-control-solid"
                                                type="password" placeholder="" name="confirm_password"
                                                autocomplete="off">
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Input group=-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3"
                                                data-kt-users-modal-action="cancel">Discard</button>
                                            <button type="submit" class="btn btn-primary"
                                                data-kt-users-modal-action="submit">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
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
                    <!--end::Modal - Update password-->
                    <!--begin::Modal - Update email-->
                    <div class="modal fade" id="kt_modal_update_phone" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bold">Update Phone Number</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                        data-kt-users-modal-action="close">
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
                                    <form id="kt_modal_update_phone_form"
                                        class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                                        <!--begin::Notice-->
                                        <!--begin::Notice-->
                                        <div
                                            class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                                            <!--begin::Icon-->
                                            <i class="ki-duotone ki-information fs-2tx text-primary me-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <!--end::Icon-->
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <!--begin::Content-->
                                                <div class="fw-semibold">
                                                    <div class="fs-6 text-gray-700">Please note that a valid
                                                        phone number may be required for order or shipping
                                                        rescheduling.</div>
                                                </div>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Notice-->
                                        <!--end::Notice-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7 fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Phone</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" placeholder=""
                                                name="profile_phone" value="+6141 234 567">
                                            <!--end::Input-->
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3"
                                                data-kt-users-modal-action="cancel">Discard</button>
                                            <button type="submit" class="btn btn-primary"
                                                data-kt-users-modal-action="submit">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
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
                    <!--end::Modal - Update email-->


                </div>

            </div>
            <div class="modal fade" id="modalCambiarFoto" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form class="modal-content" id="formCambiarFoto" enctype="multipart/form-data" method="POST"
                        action="/app/Controllers/UsuariosController.php?action=actualizarFoto">
                        <div class="modal-header">
                            <h5 class="modal-title">Cambiar Foto de Perfil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="usuario_id" value="<?= $cliente['ID'] ?>">
                            <input type="file" name="foto_perfil" accept="image/*" required class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Actualizar Foto</button>
                        </div>
                    </form>
                </div>
            </div>

            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    </div>
    <!--begin::Javascript-->
    <script>
    var hostUrl = "/public/assets/";


    $('#formCambiarPassword').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: '/app/Controllers/UsuariosController.php?action=cambiarPassword',
            type: 'POST',
            data: formData,
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status === 'success') {
                    alert('Contraseña actualizada correctamente');
                    const modalElement = document.getElementById('modalCambiarPassword');
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    modal.hide();

                    $('#formCambiarPassword')[0].reset();

                    setTimeout(() => {
                        location.reload();
                    }, 1000);

                } else {
                    alert(res.message);
                }
            }
        });
    });
    </script>

    <script>
    const icono = document.querySelector('#menu_usuario').previousElementSibling.querySelector('i');
    const span = document.getElementById('menu_usuario');

    icono.style.color = 'white';
    span.style.color = 'white';
    </script>
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