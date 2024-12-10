@extends('admin.app')

@section('header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-3 col-6">
                <a href="{{ route('clients.index') }}">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalClients }}</h3>
                            <p>Total Registered Clients</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalAppointments }}</h3>
                        <p>Total Appointments</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <a href="{{ route('schedule.today') }}">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $appointmentsToday }}</h3>
                            <p>Total Appointments Today</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $unattendedAppointments }}</h3>
                        <p>Unattended Appointments Today</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Monthly Revenue</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" style="height: 250px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Visitors Insights</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="visitorsChart" style="height: 250px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="text-success">
                    Services
                    <button type="button" class="btn btn-success float-right" data-toggle="modal"
                        data-target="#addServiceModal">
                        Add Service
                    </button>
                </h2>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Service Name</th>
                            <th>Service Price</th>
                            <th>Reservation Fee</th>
                            <th>Duration</th>
                            <th>Availability</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>
                                <td>{{ $service->name }}</td>
                                <td>₱{{ number_format($service->price, 2) }}</td>
                                <td>₱{{ number_format($service->reserve_fee, 2) }}</td>
                                <td>{{ $service->duration }} mins</td>
                                <td>
                                    <span
                                        class="badge {{ $service->availability === 'available' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($service->availability) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editServiceModal" data-id="{{ $service->id }}">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteServiceModal" data-id="{{ $service->id }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.dashboard.services.modals')
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#editServiceModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');

                $.ajax({
                    url: '{{ route('services.show', '') }}/' + id,
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        $('#serviceId').val(data.id);
                        $('#editServiceName').val(data.name);
                        $('#editServicePrice').val(data.price);
                        $('#editReserveFee').val(data.reserve_fee);
                        $('#editServiceDuration').val(data.duration);
                        $('#editAvailability').val(data.availability);
                        $('#editServiceDescription').val(data.description);
                        $('#editServiceModal').modal('show');
                        if (data.classification === 1) {
                            $('#forRegistered').prop('checked', true);
                            $('#forUnregistered').prop('checked', false);
                        } else if (data.classification === 0) {
                            $('#forRegistered').prop('checked', false);
                            $('#forUnregistered').prop('checked', true);
                        }
                    },
                    error: function(xhr) {
                        console.error('An error occurred:', xhr);
                        alert('Could not load service data. Please try again.');
                    }
                });
            });

            $('#editServiceForm').on('submit', function(event) {
                event.preventDefault();

                var id = $('#serviceId').val();
                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('services.update', '') }}/' + id,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#editServiceModal').modal('hide');
                        setTimeout(() => {
                            location.reload()
                        }, 1500);
                    },
                    error: function(xhr) {
                        console.error('An error occurred:', xhr);
                        alert('Could not update service. Please try again.');
                    }
                });
            });

            $('#deleteServiceModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var actionUrl = '{{ route('services.destroy', ':id') }}';
                actionUrl = actionUrl.replace(':id', id);
                $('#deleteServiceForm').attr('action', actionUrl);
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'visitors-insight',
                type: 'GET',
                success: function(data) {
                    const visitorsCtx = document.getElementById('visitorsChart').getContext('2d');
                    const visitorsChart = new Chart(visitorsCtx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                    label: 'Guests',
                                    data: data.guests,
                                    borderColor: 'rgba(60,141,188,0.8)',
                                    backgroundColor: 'rgba(60,141,188,0.4)',
                                    fill: true,
                                },
                                {
                                    label: 'Registered Clients',
                                    data: data.registered_clients,
                                    borderColor: 'rgba(75,192,192,0.8)',
                                    backgroundColor: 'rgba(75,192,192,0.4)',
                                    fill: true,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            let revenueChart;

            $.ajax({
                url: 'revenue-data',
                method: 'GET',
                success: function(response) {
                    revenueChart = new Chart(revenueCtx, {
                        type: 'bar',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Revenue',
                                data: response.revenue,
                                backgroundColor: 'rgba(0, 166, 90, 0.8)',
                                borderColor: 'rgba(0, 166, 90, 1)',
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching chart data:', error);
                }
            });
        });
    </script>
@endpush
