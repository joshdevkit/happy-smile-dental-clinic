@extends('client.app')
<style>
    .transac_card-body {
        max-height: 300px;
        /* Set desired max height for scrolling */
        overflow-y: auto;
        /* Enables vertical scrolling */
    }
</style>
@section('header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Appointment History</li>
                        <li class="breadcrumb-item active">Profile</li>
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
            <div class="col-md-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Profile</h3>
                    </div>
                    <div class="card-body text-center">
                        <form action="{{ route('update-avatar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 position-relative">
                                <label for="avatarInput" class="d-inline-block">
                                    <img id="avatar"
                                        src="{{ auth()->user()->avatar ? asset('avatar/' . auth()->user()->avatar) : asset('client/dist/img/default-150x150.png') }}"
                                        class="rounded-circle" alt="User Avatar"
                                        style="width: 150px; height: 150px; cursor: pointer; border: 1px solid black;">
                                </label>

                                <input type="file" id="avatarInput" name="avatar" accept="image/*"
                                    onchange="previewImage(event)" class="d-none">
                            </div>
                            <div class="form-group">
                                <label for="avatarInput">Upload Avatar</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Transaction Summary</h3>
                    </div>
                    <div class="card-body overflow-auto transac_card-body" style="max-height: 300px;">
                        @foreach ($data as $record)
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="text-success">Date/Time:</h6>
                                <h6>{{ date('F d, Y', strtotime($record->schedule->date_added)) }} -
                                    {{ date('h:i A', strtotime($record->start_time)) }}
                                    {{ date('h:i A', strtotime($record->end_time)) }} </h6>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="text-success">Service:</h6>
                                <h6>{{ $record->service->name }}</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="text-success">Service Price:</h6>
                                <h6>{{ $record->service->price }}</h6>
                            </div>
                            <hr>
                        @endforeach
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
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Change
                                    Password</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <div>
                                    <h4>User Information</h4>
                                    <form id="userProfileForm" action="{{ route('profile.update') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label for="firstName">First Name:</label>
                                                <input type="text" id="firstName" name="first_name"
                                                    class="form-control mb-3" value="{{ $user->first_name }}" disabled>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="middleName">Middle Name:</label>
                                                <input type="text" id="middleName" name="middle_name"
                                                    class="form-control mb-3" value="{{ $user->middle_name }}" disabled>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="lastName">Last Name:</label>
                                                <input type="text" id="lastName" name="last_name"
                                                    class="form-control mb-3" value="{{ $user->last_name }}" disabled>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="suffix">Suffix:</label>
                                                <input type="text" id="suffix" name="suffix"
                                                    class="form-control mb-3" value="{{ $user->suffix }}" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="email">Email:</label>
                                                <input type="email" id="email" name="email" class="form-control"
                                                    value="{{ $user->email }}" readonly>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="age">Age:</label>
                                                <input type="number" id="age" name="age" class="form-control"
                                                    value="{{ $user->age }}" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="dateOfBirth">Date of Birth:</label>
                                                <input type="date" id="dateOfBirth" name="date_of_birth"
                                                    class="form-control" value="{{ $user->date_of_birth }}" disabled>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="gender">Gender:</label>
                                                <select id="gender" name="gender" class="form-control" disabled>
                                                    <option value="Male"
                                                        {{ $user->gender == 'Male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="Female"
                                                        {{ $user->gender == 'Female' ? 'selected' : '' }}>Female
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="occupation">Occupation:</label>
                                                <input type="text" id="occupation" name="occupation"
                                                    class="form-control" value="{{ $user->occupation }}" disabled>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="civilStatus">Civil Status:</label>
                                                <input type="text" id="civilStatus" name="civil_status"
                                                    class="form-control" value="{{ $user->civil_status }}" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="cellphoneNo">Cellphone No:</label>
                                                <input type="text" id="cellphoneNo" name="cellphone_no"
                                                    class="form-control" value="{{ $user->cellphone_no }}" disabled>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-warning" id="updateProfileBtn">Update
                                            Profile</button>
                                        <button type="submit" class="btn btn-primary" id="saveChangesBtn" disabled>Save
                                            Changes</button>
                                    </form>

                                </div>
                            </div>
                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal" action="{{ route('update-password') }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Current
                                            Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="inputPassword"
                                                name="current_password" placeholder="Current Password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputNewPassword" class="col-sm-2 col-form-label">New
                                            Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="inputNewPassword"
                                                name="new_password" placeholder="New Password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputConfirmPassword" class="col-sm-2 col-form-label">Confirm New
                                            Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="inputConfirmPassword"
                                                name="new_password_confirmation" placeholder="Confirm New Password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
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
    <script>
        function previewImage(event) {
            const avatarImg = document.getElementById('avatar');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                avatarImg.src = e.target.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        document.getElementById('updateProfileBtn').addEventListener('click', function() {
            const formElements = document.querySelectorAll('#userProfileForm input, #userProfileForm select');
            formElements.forEach(element => {
                element.disabled = false;
            });

            document.getElementById('saveChangesBtn').disabled = false;
        });
    </script>

    <style>
        #avatarInput {
            display: block;
        }
    </style>
@endsection
