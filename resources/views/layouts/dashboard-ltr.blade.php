<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{ config('app.name', 'HAM') }}</title>
    <link rel="stylesheet" href="{{ asset('LTR/plugins/datatables/dataTables.bootstrap4.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('LTR/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('LTR/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('LTR/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('LTR/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('LTR/plugins/toastr/toastr.min.css') }}">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('LTR/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('LTR/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('LTR/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('LTR/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('LTR/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('LTR/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('LTR/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('LTR/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('LTR/plugins/summernote/summernote-bs4.css') }}">
    <link href="{{ asset('Inline-Valideater/jquerysctipttop_ltr.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('LTR/plugins/datatables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <script src="{{ asset('Inline-Valideater/js/jquery.valideater-0.2.2_en.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('LTR/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('LTR/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('LTR/dist/js/demo.js') }}"></script>
    <script src="{{ asset('LTR/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('LTR/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('LTR/dist/js/pages/dashboard2.js') }}"></script>
    <script src="{{ asset('LTR/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('LTR/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('LTR/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>


    <script src="{{ asset('LTR/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('LTR/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('LTR/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('LTR/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('LTR/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('LTR/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('LTR/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

    <script src="{{ asset('LTR/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script src="{{ asset('LTR/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('LTR/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('LTR/plugins/datatables/buttons.colVis.min.js') }}"></script>

    <script>
        $("#ConfirmPassword").change(function() {
            var oldpassword = document.getElementById("oldpassword").value;
            var NewPassword = document.getElementById("NewPassword").value;
            var ConfirmPassword = document.getElementById("ConfirmPassword").value;

            if (NewPassword != ConfirmPassword) {
                toastr.error("Password Mis Matches");

                document.getElementById("ConfirmPassword").value = "";
            }

            if (oldpassword == '') {
                toastr.error("Old Password is Required");

            }


            if (NewPassword == '') {
                toastr.error("New Password is Required");

            }
        });
    </script>
    <script type="text/javascript">
        function PrintDiv() {
            var contents = document.getElementById("modal-body").innerHTML;
            var frame1 = document.createElement('iframe');
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            var frameDoc = (frame1.contentWindow) ? frame1.contentWindow : (frame1.contentDocument.document) ? frame1
                .contentDocument.document : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write('<html><head><title>HSM ERP</title>');
            frameDoc.document.write('</head><body>');
            frameDoc.document.write(contents);
            frameDoc.document.write('</body></html>');
            frameDoc.document.close();
            setTimeout(function() {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                document.body.removeChild(frame1);
            }, 500);
            return false;
        }


        function PrintDiv2() {
            var contents = document.getElementById("modal-body").innerHTML;
            var frame1 = document.createElement('iframe');
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            var frameDoc = (frame1.contentWindow) ? frame1.contentWindow : (frame1.contentDocument.document) ? frame1
                .contentDocument.document : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write('<html><head><title>Orignal Copy</title>');
            frameDoc.document.write('</head><body>');
            frameDoc.document.write(contents);
            frameDoc.document.write(
                '</body><footer style=" position: fixed;  bottom: 0; "><font face="arial" size="2"><strong><br> Orignal Copy </strong></font></footer></html>'
            );
            frameDoc.document.close();
            setTimeout(function() {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                document.body.removeChild(frame1);
            }, 500);
            return false;


        }

        function PrintDiv3() {
            var contents = document.getElementById("modal-body").innerHTML;
            var frame1 = document.createElement('iframe');
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            var frameDoc = (frame1.contentWindow) ? frame1.contentWindow : (frame1.contentDocument.document) ? frame1
                .contentDocument.document : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write('<html><head><title>Client Copy</title>');
            frameDoc.document.write('</head><body>');
            frameDoc.document.write(contents);
            frameDoc.document.write(
                '</body><footer style=" position: fixed;  bottom: 0; "><font face="arial" size="2"><strong><br> Client Copy </strong></font></footer></html>'
            );
            frameDoc.document.close();
            setTimeout(function() {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                document.body.removeChild(frame1);
            }, 500);
            return false;


        }

        function PrintDiv4() {
            var contents = document.getElementById("modal-body").innerHTML;
            var frame1 = document.createElement('iframe');
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            var frameDoc = (frame1.contentWindow) ? frame1.contentWindow : (frame1.contentDocument.document) ? frame1
                .contentDocument.document : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write('<html><head><title>HAM Copy</title>');
            frameDoc.document.write('</head><body>');
            frameDoc.document.write(contents);
            frameDoc.document.write(
                '</body><footer style=" position: fixed;  bottom: 0; "><table border="0" width="100%"><tr><td align="center"><font face="arial" size="2"><strong> HAM Copy </strong></font></td></tr></table></footer></html>'
            );
            frameDoc.document.close();
            setTimeout(function() {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                document.body.removeChild(frame1);
            }, 500);
            return false;


        }

        $('#modal-change').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)

            var modal = $(this)


        })
    </script>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <!-- Messages Dropdown Menu -->
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">

                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-user"></i>
                        <span class="badge badge-danger navbar-badge"></span> </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <center>
                                <div class="image">
                                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}"
                                        class="img-circle elevation-2" width="110" height="100" alt="User Image">
                                </div>

                                <a href="#" class="d-block"></a>

                            </center>

                            <table border="0" width="100%" align="center">
                                <tr>
                                    <td colspan="2" align="center">{{ Auth::user()->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td align="center" width="60%"> <a href="#" class="dropdown-item dropdown-footer"
                                            data-toggle="modal" data-target="#modal-change">
                                            <image src="{{ asset('dist/img/change.png') }}" width="20" height="20">
                                                Chane My Password
                                        </a> </td>
                                    <td align="center" width="40%"> <a href="#" class="dropdown-item dropdown-footer"
                                            data-toggle="modal" data-target="#modal-logout">
                                            <image src="{{ asset('dist/img/exit.png') }}" width="20" height="20">
                                                Logout
                                        </a> </td>
                                </tr>

                            </table>


                            <div class="dropdown-divider"></div>

                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">

                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">
                            @if (Auth::user()->level_id == 1)@endif
                            @if (Auth::user()->level_id == 2) {{ \App\Models\Ticket::count() }} @endif
                            @if (Auth::user()->level_id == 3) {{ \App\Models\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count() }} @endif
                            @if (Auth::user()->level_id == 4) {{ \App\Models\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }} @endif
                            @if (Auth::user()->level_id == 5) {{ \App\Models\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }} @endif
                        </span> </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                        @for ($i = 1; $i <= 9; $i++)
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            <span class="float-right text-sm text-muted">

                                                @if (Auth::user()->level_id == 1)

                                                @endif
                                                @if (Auth::user()->level_id == 2)
                                                    {{ \App\Models\Ticket::where(['status_id' => $i])->get()->count() }} :
                                                    Tickets
                                                @endif
                                                @if (Auth::user()->level_id == 3)
                                                    {{ \App\Models\Ticket::where(['status_id' => $i])->where(['teamleader_id' => Auth::user()->id])->get()->count() }}
                                                    : Tickets
                                                @endif
                                                @if (Auth::user()->level_id == 4)
                                                    {{ \App\Models\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }}
                                                    : Tickets
                                                @endif
                                                @if (Auth::user()->level_id == 5)
                                                    {{ \App\Models\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }}
                                                    : Tickets
                                                @endif

                                            </span>
                                        </h3>
                                        <p class="text-sm">{{ \App\Models\TicketStatus::find($i)->name }}</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>

                        @endfor

                        <a href="#" class="dropdown-item dropdown-footer">See All</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">

                            @if (Auth::user()->level_id == 1)

                            @endif
                            @if (Auth::user()->level_id == 2)
                                {{ \App\Models\Ticket::count() }}
                            @endif
                            @if (Auth::user()->level_id == 3)
                                {{ \App\Models\Ticket::where(['status_id' => 6])->where(['teamleader_id' => Auth::user()->id])->get()->count() }}
                            @endif
                            @if (Auth::user()->level_id == 4)
                                {{ \App\Models\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }}
                            @endif
                            @if (Auth::user()->level_id == 5)
                                {{ \App\Models\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }}
                            @endif

                        </span> </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">



                            @if (Auth::user()->level_id == 1)

                            @endif
                            @if (Auth::user()->level_id == 2)
                                {{ \App\Models\Ticket::where(['status_id' => 1])->where(['teamleader_id' => Auth::user()->id])->get()->count() }}
                                New Tickets
                            @endif
                            @if (Auth::user()->level_id == 3)
                                {{ \App\Models\Ticket::where(['status_id' => 6])->where(['teamleader_id' => Auth::user()->id])->get()->count() }}
                                New Tickets
                            @endif
                            @if (Auth::user()->level_id == 4)
                                {{ \App\Models\Ticket::where(['status_id' => 1])->where(['created_by_id' => Auth::user()->id])->get()->count() }}
                                New Tickets
                            @endif
                            @if (Auth::user()->level_id == 5)
                                {{ \App\Models\Ticket::where(['status_id' => 1])->where(['created_by_id' => Auth::user()->id])->get()->count() }}
                                New Tickets
                            @endif

                        </span>
                        <div class="dropdown-divider"></div>

                        @if (isset($shownew))
                            @foreach ($shownew as $data)


                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-file mr-2"></i> {{ $data->station_en ?? '' }}
                                    <span
                                        class="float-right text-muted text-sm">{{ $show->breakdown_en ?? '' }}</span>
                                </a>
                                <div class="dropdown-divider"></div>
                            @endforeach
                        @endif

                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                            class="fas fa-th-large"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">
                    <font color="black">.</font>
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name ?? '' }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview menu-open">
                            <a href="{{ route('home') }}" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>

                        </li>
                        @if (false)
                            @if (false)
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon far fa-plus-square"></i>
                                        <p>
                                            Settings
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href="{{ route('User.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Users</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('Clients.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Clients</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('Blocks.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Blocks</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ route('Locations.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Locations</p>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a href="{{ route('Wells.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Wells</p>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a href="{{ route('Rig.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Rig</p>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a href="{{ route('ServiceCategory.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>ServiceCategory</p>
                                            </a>
                                        </li>



                                        <li class="nav-item">
                                            <a href="{{ route('Currency.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Currency</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ route('Contract.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Contracts</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endif
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Services
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('breakdown.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Breakdowns</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('hse.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>HSE</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        @if (Gate::allows('view-reports'))

                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-table"></i>
                                    <p>
                                        Reports
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{ route('breakdown-report') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Breakdown Tickets</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('maintenance-report') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Spare Part Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('pm-report') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Preventive Maintenace</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('pm-fireexting-report') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Fireexting</p>
                                        </a>
                                    </li>
                        @endif
                    </ul>
                    </li>

                    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('link.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-link"></i>
                            <p>
                                Links
                            </p>
                        </a>

                    </li>

                    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Users
                            </p>
                        </a>

                    </li>
                    </ul>

                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->
    </div>

    <div class="modal fade" id="modal-change">
        <div class="modal-dialog">
            <div class="modal-content bg-default">
                <div class="modal-header">
                    <h4 class="modal-title">Change My Password</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ asset('change') }}">

                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                                <input id="username" type="hidden" name="username" class="form-control"
                                    value="{{ Auth::user()->UserName ?? '' }}">
                                <input id="id" type="hidden" name="id" class="form-control"
                                    value="{{ Auth::user()->id ?? '' }}">
                                <input id="email" type="email" name="email" readonly="true" class="form-control"
                                    value="{{ Auth::user()->email ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label>Old Password</label>
                                <input id="Oldpassword2" type="hidden" name="Oldpassword2" class="form-control "
                                    value="{{ Auth::user()->password ?? '' }}">
                                <input id="Oldpassword" type="password" name="Oldpassword"
                                    class="form-control @error('Oldpassword') is-invalid @enderror"
                                    data-vldtr="required" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <label>New Password</label>
                                <input id="NewPassword" type="password" name="NewPassword" data-vldtr="required"
                                    class="form-control @error('NewPassword') is-invalid @enderror">
                            </div>
                            <div class="col-md-6">
                                <label>Confirm Password</label>
                                <input id="ConfirmPassword" type="password" name="ConfirmPassword"
                                    class="form-control @error('ConfirmPassword') is-invalid @enderror"
                                    data-vldtr="matches" data-vldtr-matches="NewPassword" class="form-control">
                            </div>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-outline-light"
                        data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-outline-light">Change</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="modal-logout">
        <div class="modal-dialog modal-sm">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">log out system</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>are you sure you wont to exit ?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-outline-light" data-dismiss="modal">No</button>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        <button type="button" class="btn btn-success btn-outline-light">Yes</button>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</body>

</html>
