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
                                            {{ $schedule->first_name }} {{ $schedule->middle_name }}
                                            {{ $schedule->last_name }} {{ $schedule->suffix ?? '' }}
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
                                            @else
                                                Walk-In Guest
                                            @endif
                                        </span>
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm unattended"
                                            data-id="{{ $schedule->schedule_id }}">Unattended</button>
                                        <button class="btn btn-success btn-sm">Paid</button>
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
        });
    </script>
@endsection
