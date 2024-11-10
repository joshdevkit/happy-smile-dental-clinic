@extends('admin.app')

@section('header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">About Clients</li>
                        <li class="breadcrumb-item">About Appointment</li>
                        <li class="breadcrumb-item">Clients Info</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-3">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Clients Info</h3>
                    </div>
                    <div class="card-body text-center">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 position-relative">
                                <label for="avatarInput" class="d-inline-block">
                                    <img id="avatar" src="{{ asset('client/dist/img/default-150x150.png') }}"
                                        class="rounded-circle" alt="User Avatar"
                                        style="width: 150px; height: 150px; cursor: pointer; border: 1px solid black;">
                                </label>
                                <input type="file" id="avatarInput" name="avatar" accept="image/*"
                                    onchange="previewImage(event)" class="d-none">
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity"
                                    data-toggle="tab">Information</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <div>
                                    <h4>User Information</h4>
                                    <form id="userProfileForm" action="" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label for="firstName">First Name:</label>
                                                <input type="text" id="firstName" name="first_name"
                                                    class="form-control mb-3" value="{{ $data->first_name }}" disabled>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="middleName">Middle Name:</label>
                                                <input type="text" id="middleName" name="middle_name"
                                                    class="form-control mb-3" value="{{ $data->middle_name }}" disabled>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="lastName">Last Name:</label>
                                                <input type="text" id="lastName" name="last_name"
                                                    class="form-control mb-3" value="{{ $data->last_name }}" disabled>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="suffix">Suffix:</label>
                                                <input type="text" id="suffix" name="suffix"
                                                    class="form-control mb-3" value="{{ $data->suffix }}" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="email">Email:</label>
                                                <input type="email" id="email" name="email" class="form-control"
                                                    value="{{ $data->email }}" readonly>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="age">Age:</label>
                                                <input type="number" id="age" name="age" class="form-control"
                                                    value="{{ $data->age }}" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="dateOfBirth">Date of Birth:</label>
                                                <input type="date" id="dateOfBirth" name="date_of_birth"
                                                    class="form-control" value="{{ $data->date_of_birth }}" disabled>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="gender">Gender:</label>
                                                <select id="gender" name="gender" class="form-control" disabled>
                                                    <option value="Male" {{ $data->gender == 'Male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="Female"
                                                        {{ $data->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="occupation">Occupation:</label>
                                                <input type="text" id="occupation" name="occupation"
                                                    class="form-control" value="{{ $data->occupation }}" disabled>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="civilStatus">Civil Status:</label>
                                                <input type="text" id="civilStatus" name="civil_status"
                                                    class="form-control" value="{{ $data->civil_status }}" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="cellphoneNo">Cellphone No:</label>
                                                <input type="text" id="cellphoneNo" name="cellphone_no"
                                                    class="form-control" value="{{ $data->cellphone_no }}" disabled>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #avatarInput {
            display: block;
        }
    </style>
@endsection
