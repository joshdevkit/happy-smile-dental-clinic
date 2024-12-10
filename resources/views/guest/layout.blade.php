<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('client/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
        href="{{ asset('client/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('client/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fullcalendar/lib/main.min.css') }}">
    <script src="{{ asset('fullcalendar/lib/main.min.js') }}"></script>
    <script src="{{ asset('client/plugins/jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .fc .fc-col-header-cell-cushion {
            display: inline-block;
            padding: 2px 4px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light sticky-top">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle"></i>
                        {{ Session::get('otp_email') }}
                    </a>
                </li>
            </ul>
        </nav>

        <style>
            .active-link {
                background-color: green !important;
                color: #fff !important;
            }

            .nav-link {
                transition: background-color 0.3s ease, color 0.3s ease;
                color: #000;
                text-decoration: none;
            }

            .nav-link:hover {
                background-color: darkgreen !important;
                color: white !important;
            }

            .nav-link.active-link:hover {
                background-color: green !important;
            }
        </style>


        <aside class="main-sidebar bg-white sidebar-white elevation-4">
            <a href="{{ route('client.dashboard') }}" class="text-center d-block">
                <img src="{{ asset('client/dist/img/brand.jpg') }}" alt="AdminLTE Logo" class="brand-image mb-2"
                    style="opacity: .8; max-width: 100%; height: auto;">
            </a>
            <hr>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('guest.homepage') }}"
                                class="nav-link {{ request()->routeIs('guest.homepage') ? 'active-link' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Available Schedules
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="findAppointmentLink">
                                <i class="nav-icon fas fa-search"></i>
                                <p>
                                    Find my Appointment
                                </p>
                            </a>
                        </li>

                        <div class="search-container" style="display:none;">
                            <input type="text" id="tracking_number" class="form-control"
                                placeholder="Enter Tracking Number" />
                            <button type="button" id="searchAppointment" class="btn btn-primary mt-2">Search</button>
                            <div id="searchResult" class="mt-3"></div>
                        </div>
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link" id="findAppointmentLink">
                                <i class="nav-icon fas fa-angle-left"></i>
                                <p>
                                    Go back to Homepage
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>

            </div>
        </aside>


        <div class="content-wrapper">
            @yield('header')
            <section class="content">
                @yield('content')
            </section>
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="#">HAPPY SMILE DENTAL CLINIC</a>.</strong>
            All rights reserved.

        </footer>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @stack('scripts')
    <script src="{{ asset('client/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('/client/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('/client/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('/client/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/client/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('/client/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('/client/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/client/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/client/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#dataTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#findAppointmentLink').on('click', function(e) {
                e.preventDefault();
                $('.search-container').toggle();
            });

            $('#searchAppointment').on('click', function() {
                var trackingNumber = $('#tracking_number').val().trim();

                $('#searchResult').empty();
                if (trackingNumber === "") {
                    $('#searchResult').append(
                        '<div class="alert alert-danger">Please enter a tracking number.</div>');
                    return;
                }

                $.ajax({
                    url: '{{ route('search-appointment') }}',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        tracking_number: trackingNumber
                    },
                    success: function(response) {
                        if (!response.success) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Appointment not found',
                                text: 'No appointment matches the provided tracking number.',
                            });
                        } else {
                            window.location.href = `${response.url}`
                        }
                    },
                    error: function() {
                        $('#searchResult').append(
                            '<div class="alert alert-danger">Something went wrong. Please try again later.</div>'
                        );
                    }
                });
            });
        });
    </script>
</body>

</html>
