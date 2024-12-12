@extends('admin.app')

@section('header')
    <style>
        .active_list {
            color: green !important;

        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a>Dashboard</a></li>
                        <li class="breadcrumb-item ">About Clients</li>
                        <li class="breadcrumb-item">About Appointment</li>
                        <li class="breadcrumb-item active_list">Today's Appointment</li>
                        <li class="breadcrumb-item">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid px-3">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <table id="dataTable" class="table mt-3">
                    <thead class="bg-black text-white">
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Service</th>
                            <th>Appointment Date/Time</th>
                            <th>Role</th>
                            <th>Process of Availing</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($today->isNotEmpty())
                            @foreach ($today as $schedule)
                                <tr>
                                    <td>{{ $schedule->schedule_id }}</td>
                                    <td>
                                        @if ($schedule->user_id)
                                            {{ $schedule->full_name }}
                                        @elseif (!$schedule->user_id && $schedule->is_guest)
                                            {{ $schedule->guest_name }}
                                        @else
                                            {{ $schedule->walk_in_name }}
                                        @endif
                                    </td>
                                    <td>{{ $schedule->service_name ?? 'N/A' }}</td>
                                    <td>
                                        {{ date('F d, Y', strtotime($schedule->date_added)) }}
                                        {{ date('h:i A', strtotime($schedule->start_time)) }} -
                                        {{ date('h:i A', strtotime($schedule->end_time)) }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $schedule->user_id ? 'bg-primary' : 'bg-danger' }}">
                                            {{ $schedule->user_id ? 'Registered Client' : 'Guest' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge
                                            @if ($schedule->user_id && $schedule->walk_in == 1) bg-primary
                                            @elseif ($schedule->user_id)
                                                bg-success
                                            @else
                                                bg-danger @endif">
                                            @if ($schedule->user_id && $schedule->walk_in == 1)
                                                Walk-In Registered Client
                                            @elseif ($schedule->user_id)
                                                Online
                                            @elseif (!$schedule->user_id && $schedule->is_guest)
                                                (Guest)
                                                Online
                                            @else
                                                Walk-In Guest
                                            @endif
                                        </span>
                                    </td>

                                    <td>
                                        @if (empty($schedule->client_sched_id))
                                            <button type="button" class="btn btn-danger btn-sm unattended"
                                                data-id="{{ $schedule->schedule_id }}">Unattend</button>
                                        @endif
                                        @if (empty($schedule->client_sched_id))
                                            <button type="button" class="btn btn-success btn-sm paid"
                                                data-id="{{ $schedule->schedule_id }}"
                                                data-full-name="{{ $schedule->user_id ? $schedule->full_name : $schedule->walk_in_name }}"
                                                data-service-name="{{ $schedule->service_name ?? 'N/A' }}"
                                                data-service-price="{{ $schedule->service_price }}"
                                                data-reservation-price="{{ $schedule->reservation_fee }}"
                                                data-appointment-date="{{ date('F d, Y', strtotime($schedule->date_added)) }} {{ date('h:i A', strtotime($schedule->end_time)) }} - {{ date('h:i A', strtotime($schedule->start_time)) }} ">
                                                Paid
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-success btn-sm disabled">
                                                Paid
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">No appointments for today.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Area</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('payment') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transactionID">Transaction ID</label>
                                    <input readonly type="text" name="transactionID" id="transactionID"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="clientName">Client Name</label>
                                    <input type="text" id="clientName" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="serviceName">Service</label>
                                    <input type="text" id="serviceName" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="appointmentDate">Appointment Date</label>
                                    <textarea readonly class="form-control" id="appointmentDate" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="clinicName">Clinic Name</label>
                                    <input type="text" id="clinicName" value="{{ config('app.name') }}"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="paymentDate">Payment Date</label>
                                    <input type="date" name="paymentDate" id="paymentDate" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="payment">Payment Method</label>
                                        <select name="payment" id="payment" class="form-select form-control">
                                            <option value="">Select</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Online">Online</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="amount">Amount</label>
                                        <input readonly type="text" name="amount" id="amount"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" name="remarks" rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $(document).on('click', '.unattended', function() {
                var schedule_id = $(this).data('id')
                Swal.fire({
                    title: "Mark this Appointment as Unattended ?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Proceed"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('appointments.updateStatus') }}',
                            method: 'POST',
                            data: {

                                schedule_id: schedule_id,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: "Marked as Unattended!",
                                        text: "The appointment has been marked as Not Attended.",
                                        icon: "success"
                                    }).then(() => {
                                        location
                                            .reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: response.message,
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "An error occurred while updating the appointment.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            })

            $(document).on('click', '.paid', function() {
                var schedule_id = $(this).data('id')
                $('#transactionID').val(schedule_id)
                var schedule_id = $(this).data('id');
                var full_name = $(this).data('full-name');
                var service_name = $(this).data('service-name');
                var appointment_date = $(this).data('appointment-date');
                var service_price = $(this).data('service-price');
                var reservation_fee = $(this).data('reservation-price')
                var totalAmount = parseFloat(reservation_fee) + parseFloat(service_price)
                $('#clientName').val(full_name);
                $('#serviceName').val(service_name);
                $('#appointmentDate').val(appointment_date);
                $('#amount').val(totalAmount)
                $('#paymentModal').modal('show')

            });
        });
    </script>
@endsection
