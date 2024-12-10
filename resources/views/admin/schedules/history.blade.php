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
                        <li class="breadcrumb-item active_list">Appointment History</li>
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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
                        @foreach ($history as $record)
                            <tr>
                                <td>{{ $record->id }}</td>
                                <td>
                                    @if ($record->user_id)
                                        {{ $record->user->first_name }} {{ $record->user->middle_name }}
                                        {{ $record->user->last_name }}
                                    @elseif (!$record->user_id && $record->is_guest)
                                        {{ $record->guest_name }}
                                    @else
                                        {{ $record->walk_in_name }}
                                    @endif
                                </td>

                                <td>{{ $record->service->name }}</td>
                                <td>
                                    {{ date('F d, Y', strtotime($record->schedule->date_added)) }}
                                    {{ date('h:i A', strtotime($record->start_time)) }} -
                                    {{ date('h:i A', strtotime($record->end_time)) }}
                                </td>
                                <td>
                                    @php
                                        echo $record->user_id ? 'Registered Client' : 'Guest';
                                    @endphp
                                </td>

                                <td>
                                    @php
                                        if ($record->is_guest) {
                                            echo 'Guest';
                                        } elseif ($record->user_id) {
                                            echo 'Online';
                                        } else {
                                            echo 'Walk-In';
                                        }
                                    @endphp
                                </td>

                                <td>
                                    @if ($record->user_id && empty($record->followup->record_id))
                                        <button type="button" class="btn btn-sm btn-success follow_up"
                                            data-id="{{ $record->id }}"
                                            data-name="{{ $record->user->first_name }} {{ $record->user->middle_name }} {{ $record->user->last_name }}"
                                            data-user="{{ $record->user->id }}">Follow
                                            Up
                                        </button>
                                    @elseif($record->user_id && !empty($record->followup->record_id))
                                        <button type="button" class="btn btn-success btn-sm disabled">Follow Up
                                            Sent</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @include('admin.schedules.modals.follow-up')

    <script>
        $(document).ready(function() {
            $(document).on('click', '.follow_up', function() {
                var schedId = $(this).data('id')
                var clientName = $(this).data('name')
                var userId = $(this).data('user')
                $('#followUpModal').modal('show')
                $('#record_id').val(schedId)
                $('#patient_name').val(clientName)
            })
        });
    </script>
@endsection
