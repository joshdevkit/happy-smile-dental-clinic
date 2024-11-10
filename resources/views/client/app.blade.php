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
    <style>
        .fc .fc-col-header-cell-cushion {
            display: inline-block;
            padding: 2px 4px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('client.nav')
        @include('client.aside')

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
</body>

</html>
