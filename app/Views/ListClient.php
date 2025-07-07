<?php
$title = "ListClient"; // Título dinámico
include '../layout.php'; // Asegúrate de que la ruta sea correcta
?>
<html lang="en">

<body>
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base"
                data-select2-id="select2-data-129-7foh">
                <!--begin::Filter-->
                <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-filter fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Filter</button>
                <!--begin::Menu 1-->
                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true"
                    id="kt-toolbar-filter" data-select2-id="select2-data-kt-toolbar-filter" style="">
                    <!--begin::Header-->
                    <div class="px-7 py-5">
                        <div class="fs-4 text-gray-900 fw-bold">Filtrar Opciones</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Separator-->
                    <div class="separator border-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Content-->
                    <div class="px-7 py-5" data-select2-id="select2-data-128-as4y">
                        <!--begin::Input group-->
                        <div class="mb-10" data-select2-id="select2-data-127-7ttp">
                            <!--begin::Label-->
                            <label class="form-label fs-5 fw-semibold mb-3">Mes:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css"
                                rel="stylesheet" />
                            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
                            <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                data-placeholder="Selecciona una opción" data-allow-clear="true"
                                data-kt-customer-table-filter="month" data-dropdown-parent="#kt-toolbar-filter">
                                <option></option>
                                <option value="aug">August</option>
                                <option value="sep">September</option>
                                <option value="oct">October</option>
                                <option value="nov">November</option>
                                <option value="dec">December</option>
                            </select>
                            <script>
                            $(document).ready(function() {
                                $('[data-kt-select2="true"]').select2({
                                    placeholder: "Selecciona una opción",
                                    allowClear: true,
                                    width: 'resolve'
                                });
                            });
                            </script>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->

                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Resetear</button>
                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true"
                                data-kt-customer-table-filter="filter">Aplicar</button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Menu 1-->
                <!--end::Filter-->
                <!--begin::Export-->

                <!--end::Export-->
                <!--begin::Add customer-->

                <!--end::Add customer-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Group actions-->
            <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                <div class="fw-bold me-5">
                    <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
                </div>
                <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete
                    Selected</button>
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
                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable" id="kt_customers_table"
                    style="width: 100%;">
                    <colgroup>
                        <col data-dt-column="0" style="width: 36.3906px;">
                        <col data-dt-column="1" style="width: 133.406px;">
                        <col data-dt-column="2" style="width: 167.641px;">
                        <col data-dt-column="3" style="width: 192.172px;">
                        <col data-dt-column="4" style="width: 136.328px;">
                        <col data-dt-column="5" style="width: 178.297px;">
                        <col data-dt-column="6" style="width: 112.266px;">
                    </colgroup>
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2 dt-orderable-none" data-dt-column="0" rowspan="1" colspan="1"
                                aria-label="
																
																	
																
															"><span class="dt-column-title">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_customers_table .form-check-input" value="1">
                                    </div>
                                </span><span class="dt-column-order"></span></th>
                            <th class="min-w-125px dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                colspan="1" aria-label="Customer Name: Activate to sort" tabindex="0">
                                <span class="dt-column-title" role="button">Nombre del Cliente</span><span
                                    class="dt-column-order"></span>
                            </th>
                            <th class="min-w-125px dt-orderable-asc dt-orderable-desc" data-dt-column="2" rowspan="1"
                                colspan="1" aria-label="Email: Activate to sort" tabindex="0"><span
                                    class="dt-column-title" role="button">Correo</span><span
                                    class="dt-column-order"></span></th>
                            <th class="min-w-125px dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1"
                                colspan="1" aria-label="Company: Activate to sort" tabindex="0">
                                <span class="dt-column-title" role="button">Nombre de la
                                    compañia</span><span class="dt-column-order"></span>
                            </th>
                            <th class="min-w-125px dt-orderable-asc dt-orderable-desc" data-dt-column="5" rowspan="1"
                                colspan="1" aria-label="Created Date: Activate to sort" tabindex="0">
                                <span class="dt-column-title" role="button">Created Date</span><span
                                    class="dt-column-order"></span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <a href="apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Emma
                                    Smith</a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">smith@kpmg.com</a>
                            </td>
                            <td>-</td>

                            <td data-order="2020-12-14T20:43:00-06:00">14 Dec 2020, 8:43
                                pm</td>

                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <a href="apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Melody
                                    Macy</a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">melody@altbox.com</a>
                            </td>
                            <td>Google</td>

                            <td data-order="2020-12-01T10:12:00-06:00">01 Dec 2020,
                                10:12 am</td>

                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <a href="apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Max
                                    Smith</a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">max@kt.com</a>
                            </td>
                            <td>Bistro Union</td>

                            <td data-order="2020-11-12T14:01:00-06:00">12 Nov 2020, 2:01
                                pm</td>

                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <a href="apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Sean
                                    Bean</a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">sean@dellito.com</a>
                            </td>
                            <td>Astro Limited</td>

                            <td data-order="2020-10-21T17:54:00-06:00">21 Oct 2020, 5:54
                                pm</td>

                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <a href="apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Brian
                                    Cox</a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">brian@exchange.com</a>
                            </td>
                            <td>-</td>

                            <td data-order="2020-10-19T07:32:00-06:00">19 Oct 2020, 7:32
                                am</td>

                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <a href="apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Mikaela
                                    Collins</a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">mik@pex.com</a>
                            </td>
                            <td>Keenthemes</td>

                            <td data-order="2020-09-23T00:37:00-06:00">23 Sep 2020,
                                12:37 am</td>

                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <a href="apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Francis
                                    Mitcham</a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">f.mit@kpmg.com</a>
                            </td>
                            <td>Paypal</td>

                            <td data-order="2020-09-11T15:15:00-06:00">11 Sep 2020, 3:15
                                pm</td>

                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <a href="apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Olivia
                                    Wild</a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">olivia@corpmail.com</a>
                            </td>
                            <td>-</td>

                            <td data-order="2020-09-03T01:08:00-06:00">03 Sep 2020, 1:08
                                am</td>

                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <a href="apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Neil
                                    Owen</a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">owen.neil@gmail.com</a>
                            </td>
                            <td>Paramount</td>

                            <td data-order="2020-09-01T16:58:00-06:00">01 Sep 2020, 4:58
                                pm</td>

                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <a href="apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Dan
                                    Wilson</a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">dam@consilting.com</a>
                            </td>
                            <td>Trinity Studio</td>

                            <td data-order="2020-08-18T15:34:00-06:00">18 Aug 2020, 3:34
                                pm</td>

                        </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
            <div id="" class="row">
                <div id=""
                    class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                    <div><select name="kt_customers_table_length" aria-controls="kt_customers_table"
                            class="form-select form-select-solid form-select-sm" id="dt-length-0">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select><label for="dt-length-0"></label></div>
                </div>
                <div id=""
                    class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                    <div class="dt-paging paging_simple_numbers">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                <li class="dt-paging-button page-item disabled"><button class="page-link previous"
                                        role="link" type="button" aria-controls="kt_customers_table"
                                        aria-disabled="true" aria-label="Previous" data-dt-idx="previous"
                                        tabindex="-1"><i class="previous"></i></button></li>
                                <li class="dt-paging-button page-item active"><button class="page-link" role="link"
                                        type="button" aria-controls="kt_customers_table" aria-current="page"
                                        data-dt-idx="0">1</button>
                                </li>
                                <li class="dt-paging-button page-item"><button class="page-link" role="link"
                                        type="button" aria-controls="kt_customers_table" data-dt-idx="1">2</button>
                                </li>
                                <li class="dt-paging-button page-item"><button class="page-link" role="link"
                                        type="button" aria-controls="kt_customers_table" data-dt-idx="2">3</button>
                                </li>
                                <li class="dt-paging-button page-item"><button class="page-link" role="link"
                                        type="button" aria-controls="kt_customers_table" data-dt-idx="3">4</button>
                                </li>
                                <li class="dt-paging-button page-item"><button class="page-link next" role="link"
                                        type="button" aria-controls="kt_customers_table" aria-label="Next"
                                        data-dt-idx="next"><i class="next"></i></button></li>
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
    <!--begin::Javascript-->
    </div>
    <script>
    var hostUrl = "/Kima/assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="/Kima/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/Kima/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="/Kima/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="/Kima/assets/js/custom/apps/file-manager/list.js"></script>
    <script src="/Kima/assets/js/widgets.bundle.js"></script>
    <script src="/Kima/assets/js/custom/widgets.js"></script>
    <script src="/Kima/assets/js/custom/apps/chat/chat.js"></script>
    <script src="/Kima/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="/Kima/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="/Kima/assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>