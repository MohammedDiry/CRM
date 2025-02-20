<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Datatables - Kaiadmin Bootstrap 5 Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />
    <!-- مكتبات أخرى موجودة هنا -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a class="logo">
                        <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand"
                            class="navbar-brand" height="20" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item active">
                            <a href="{{ route('index') }}" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                                <span class="badge badge-success"></span>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Management</h4>
                        </li>
                        <li class="nav-item">
                            <a a href="{{ route('clients.index') }}">
                                <i class="fas fa-user-check"></i>
                                <p>Clients</p>
                                <span class="badge badge-success"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a a href="{{ route('leads.index') }}">
                                <i class="fas fa-user-plus"></i>
                                <p>Leads</p>
                                <span class="badge badge-success"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a a href="{{ route('projects.index') }}">
                                <i class="far fa-file-alt"></i>
                                <p>Projects</p>
                                <span class="badge badge-success"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a a href="{{ route('expenses.index') }}">
                                <i class="fas fa-hand-holding-usd"></i>
                                <p>Expenses</p>
                                <span class="badge badge-success"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a a href="{{ route('employees.index') }}">
                                <i class="fas fa-users"></i>
                                <p>Employees</p>
                                <span class="badge badge-success"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a a href="{{ route('reports.index') }}">
                                <i class="fas fa-newspaper"></i>
                                <p>Reports</p>
                                <span class="badge badge-success"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a a href="{{ route('invoices.index') }}">
                                <i class="fas fa-file-invoice-dollar me-2"></i>
                                <p>Invoices</p>
                                <span class="badge badge-success"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="../index.html" class="logo">
                            <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand"
                                class="navbar-brand" height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">


                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic d-flex align-items-center"
                                    data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="fas fa-user-circle fa-lg me-2"></i>
                                    <span class="fw-bold">{{ Auth::user()->employee->name }}<< /span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="dropdown-title">User Menu</div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('employees.show', auth()->user()->employee->id) }}">
                                                <i class="fas fa-user me-2"></i> View Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('employees.edit', auth()->user()->employee->id) }}">
                                                <i class="fas fa-cog me-2"></i> Account Settings
                                            </a>
                                        </li>
                                        <div class="dropdown-divider"></div>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </div>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">

                    <!-- سيتم تحميل المحتوى المتغير هنا -->
                    @yield('content')

                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid d-flex justify-content-between">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="http://www.themekita.com">
                                    ThemeKita
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Help </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Licenses </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright">
                        2024, made with <i class="fa fa-heart heart text-danger"></i> by
                        <a href="http://www.themekita.com">ThemeKita</a>
                    </div>
                    <div>
                        Distributed by
                        <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
                    </div>
                </div>
            </footer>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <div class="custom-template">
            <div class="title">Settings</div>
            <div class="custom-content">
                <div class="switcher">
                    <div class="switch-block">
                        <h4>Logo Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="selected changeLogoHeaderColor" data-color="dark"></button>
                            <button type="button" class="selected changeLogoHeaderColor" data-color="blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="white"></button>
                            <br />
                            <button type="button" class="changeLogoHeaderColor" data-color="dark2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Navbar Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeTopBarColor" data-color="dark"></button>
                            <button type="button" class="changeTopBarColor" data-color="blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="green"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange"></button>
                            <button type="button" class="changeTopBarColor" data-color="red"></button>
                            <button type="button" class="changeTopBarColor" data-color="white"></button>
                            <br />
                            <button type="button" class="changeTopBarColor" data-color="dark2"></button>
                            <button type="button" class="selected changeTopBarColor" data-color="blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple2"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="green2"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange2"></button>
                            <button type="button" class="changeTopBarColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Sidebar</h4>
                        <div class="btnSwitch">
                            <button type="button" class="selected changeSideBarColor" data-color="white"></button>
                            <button type="button" class="changeSideBarColor" data-color="dark"></button>
                            <button type="button" class="changeSideBarColor" data-color="dark2"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="custom-toggle">
                <i class="icon-settings"></i>
            </div>
        </div>
        <!-- End Custom template -->
    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/js/setting-demo2.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <!-- jQuery Sparkline -->
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- Chart Circle -->
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <!-- Bootstrap Notify -->
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <!-- jQuery Vector Maps -->
    <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/js/setting-demo.js') }}"></script>
    <script src="{{ asset('assets/js/demo.js') }}"></script>

    <!-- Include Select2 & jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});

            $("#multi-filter-select").DataTable({
                pageLength: 5,
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-select"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on("change", function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                    column
                                        .search(val ? "^" + val + "$" : "", true, false)
                                        .draw();
                                });

                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.append(
                                        '<option value="' + d + '">' + d + "</option>"
                                    );
                                });
                        });
                },
            });

            // Add Row
            $("#add-row").DataTable({
                pageLength: 5,
            });

            var action =
                '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

            $("#addRowButton").click(function() {
                $("#add-row")
                    .dataTable()
                    .fnAddData([
                        $("#addName").val(),
                        $("#addPosition").val(),
                        $("#addOffice").val(),
                        action,
                    ]);
                $("#addRowModal").modal("hide");
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Enable Select2 for project dropdown
            $('.select2').select2({
                placeholder: "Search for a project",
                allowClear: true
            });

            // Auto-update status based on due date
            $('#due_date').on('change', function() {
                let dueDate = new Date($(this).val());
                let today = new Date();
                let statusField = $('#status');

                if (dueDate < today) {
                    statusField.val('Overdue').change();
                } else {
                    statusField.val('Pending').change();
                }
            });

            // Auto-update payment date based on status change
            $('#status').on('change', function() {
                let status = $(this).val();
                let paymentDateField = $('#payment_date');

                if (status === 'Paid') {
                    paymentDateField.val(new Date().toISOString().slice(0, 10));
                } else {
                    paymentDateField.val('');
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let statusField = document.getElementById("status");
            let previousStatus = statusField.value; // حفظ الحالة الحالية

            statusField.addEventListener("change", function() {
                let selectedStatus = this.value;
                let confirmChange = confirm("Are you sure you want to change the invoice status?");

                if (!confirmChange) {
                    this.value = previousStatus; // إرجاع الحالة السابقة إذا ألغى المستخدم العملية
                } else {
                    previousStatus = selectedStatus; // تحديث الحالة السابقة عند التأكيد
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            console.log("Document is ready! Initializing DataTables...");

            // تحقق من وجود الجدول قبل تهيئة DataTable
            if ($("#basic-datatables").length) {
                $("#basic-datatables").DataTable({});
            } else {
                console.warn("Table #basic-datatables not found!");
            }

            if ($("#multi-filter-select").length) {
                $("#multi-filter-select").DataTable({
                    pageLength: 5,
                    initComplete: function() {
                        this.api()
                            .columns()
                            .every(function() {
                                var column = this;
                                var select = $(
                                        '<select class="form-select"><option value=""></option></select>'
                                        )
                                    .appendTo($(column.footer()).empty())
                                    .on("change", function() {
                                        var val = $.fn.dataTable.util.escapeRegex($(this)
                                    .val());

                                        column.search(val ? "^" + val + "$" : "", true, false)
                                            .draw();
                                    });

                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function(d, j) {
                                        select.append('<option value="' + d + '">' + d +
                                            "</option>");
                                    });
                            });
                    },
                });
            } else {
                console.warn("Table #multi-filter-select not found!");
            }

            // Add Row Table
            if ($("#add-row").length) {
                $("#add-row").DataTable({
                    pageLength: 5,
                });

                var action = `
                <td>
                    <div class="form-button-action">
                        <button type="button" data-bs-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" data-bs-toggle="tooltip" title="Remove" class="btn btn-link btn-danger">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </td>`;

                $("#addRowButton").click(function() {
                    console.log("Add row button clicked!");

                    $("#add-row")
                        .dataTable()
                        .fnAddData([
                            $("#addName").val(),
                            $("#addPosition").val(),
                            $("#addOffice").val(),
                            action,
                        ]);
                    $("#addRowModal").modal("hide");
                });
            } else {
                console.warn("Table #add-row not found!");
            }
        });
    </script>
    @yield('contentScript')
</body>

</html>
