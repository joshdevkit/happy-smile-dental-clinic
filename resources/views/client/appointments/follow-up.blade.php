@extends('client.app')

@section('header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Followup Appointment</li>
                        <li class="breadcrumb-item ">Profile</li>
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
                <table class="table" id="dataTable">
                    <thead class="bg-black text-white">
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Service</th>
                            <th>Followup Service for</th>
                            <th>Appointment Date/Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $record)
                            <tr>
                                <td>{{ $record->id }}</td>
                                <td>{{ Auth::user()->first_name }} {{ Auth::user()->middle_name ?? '' }}
                                    {{ Auth::user()->last_name }}</td>
                                <td>{{ $record->service->name }}</td>
                                <td>{{ $record->followup->service->name }}</td>
                                <td>
                                    {{ date('F d, Y', strtotime($record->followup->date)) }} -
                                    {{ date('h:i A', strtotime($record->followup->start_time)) }} to
                                    {{ date('h:i A', strtotime($record->followup->end_time)) }}
                                </td>
                                <td>
                                    @php
                                        $followUpCreatedAt = \Carbon\Carbon::parse($record->followup->created_at);
                                        $currentTime = \Carbon\Carbon::now();

                                        $timeDiffInMinutes = $currentTime->diffInMinutes($followUpCreatedAt);
                                    @endphp

                                    @if ($record->followup->is_accepted == 0)
                                        @if ($timeDiffInMinutes <= 60)
                                            <button class="btn btn-sm btn-success btn-accept"
                                                data-id="{{ $record->followup->id }}">Accept</button>
                                            <button class="btn btn-sm btn-danger btn-decline"
                                                data-id="{{ $record->followup->id }}">Decline</button>
                                        @else
                                            <button class="btn btn-sm btn-success btn-accept" disabled>Accept</button>
                                            <button class="btn btn-sm btn-danger btn-decline" disabled>Decline</button>
                                        @endif
                                    @elseif($record->followup->is_accepted == 2)
                                        <span class="badge badge-danger">Rejected</span>
                                    @else
                                        <span class="badge badge-success">Accepted</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            // Handle Accept Button
            $('.btn-accept').click(function() {
                const followupId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to accept this follow-up?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Accept!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('accept') }}',
                            method: 'POST',
                            data: {
                                id: followupId,
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(response) {
                                Swal.fire('Accepted!',
                                    'The follow-up has been accepted.', 'success');
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            },
                            error: function() {
                                Swal.fire('Error!', 'Something went wrong. Try again.',
                                    'error');
                            }
                        });
                    }
                });
            });

            // Handle Decline Button
            $('.btn-decline').click(function() {
                const followupId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to decline this follow-up?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Decline!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('reject') }}',
                            method: 'POST',
                            data: {
                                id: followupId,
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(response) {
                                Swal.fire('Declined!',
                                    'The follow-up has been declined.', 'success');
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            },
                            error: function() {
                                Swal.fire('Error!', 'Something went wrong. Try again.',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
