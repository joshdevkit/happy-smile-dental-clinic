@extends('guest.layout')
@section('header')
    <style>
        .schedul_span {
            margin-left: 10rem;
            padding: 10px;
            margin-right: 3px;
        }

        .hover-pointer {
            cursor: pointer;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-start">
                        <li class="breadcrumb-item active">Your Appointment</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Appointment Details</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tracking Number</strong>
                            <p class="text-muted">HSDC00{{ $data->id }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Guest Name</strong>
                            <p>{{ $data->guest_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Status</strong>
                            <p class="text-{{ $data->status == 'Pending' ? 'warning' : 'success' }}">
                                {{ $data->status }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Service</strong>
                            <p>{{ $data->service->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Scheduled Time</strong>
                            <p>{{ \Carbon\Carbon::parse($data->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($data->end_time)->format('h:i A') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Contact Number</strong>
                            <p>{{ $data->guest_contact }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Email</strong>
                            <p>{{ $data->guest_email }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <strong>Created On</strong>
                            <p>{{ \Carbon\Carbon::parse($data->created_at)->format('F d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
