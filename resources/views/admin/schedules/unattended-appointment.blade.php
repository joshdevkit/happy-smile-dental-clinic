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
                        <li class="breadcrumb-item active_list">Unattended Appointment</li>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unattended as $record)
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
                                    <span
                                        class="badge
                                        @if ($record->user_id && $record->walk_in == 1) bg-primary
                                        @elseif ($record->user_id)
                                            bg-success
                                        @else
                                            bg-danger @endif">
                                        @if ($record->user_id && $record->walk_in == 1)
                                            Walk-In Registered Client
                                        @elseif ($record->user_id)
                                            Online
                                        @elseif (!$record->user_id && $record->is_guest)
                                            (Guest)
                                            Online
                                        @else
                                            Walk-In Guest
                                        @endif
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
