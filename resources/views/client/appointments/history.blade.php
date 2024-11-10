@extends('client.app')

@section('header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Appointment History</li>
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
                            <th>Appointment Date</th>
                            <th>Service Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointment as $schedule)
                            <tr>
                                <td>{{ $schedule->id }}</td>
                                <td>{{ trim("{$schedule->user->first_name} {$schedule->user->middle_name} {$schedule->user->last_name}") }}
                                </td>
                                <td>{{ $schedule->service->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->schedule->date_added)->format('M/d/Y') }}</td>
                                <td>{{ $schedule->service->price }}</td>
                                <td>
                                    <span
                                        class="badge
                                        @if ($schedule->status == 'Pending') badge-warning
                                        @elseif($schedule->status == 'Success') badge-success
                                        @elseif($schedule->status == 'Not Attended') badge-danger
                                        @elseif($schedule->status == 'Confirmed') badge-info
                                        @elseif($schedule->status == 'Cancelled') badge-dark @endif">
                                        {{ $schedule->status }}
                                    </span>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
