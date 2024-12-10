@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center bg-white">
                        <h4 class="text-success fw-bold">{{ __('REGISTER') }}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ old('first_name') }}" autofocus>
                                    @error('first_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name"
                                        value="{{ old('middle_name') }}">
                                    @error('middle_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="suffix" class="form-label">Suffix</label>
                                    <input type="text" class="form-control" id="suffix" name="suffix"
                                        value="{{ old('suffix') }}">
                                    @error('suffix')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="number" class="form-control" id="age" name="age"
                                        value="{{ old('age') }}">
                                    @error('age')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth') }}">
                                    @error('date_of_birth')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender
                                        </option>
                                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="occupation" class="form-label">Occupation</label>
                                    <input type="text" class="form-control" id="occupation" name="occupation"
                                        value="{{ old('occupation') }}">
                                    @error('occupation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="civil_status" class="form-label">Civil Status</label>
                                    <input type="text" class="form-control" id="civil_status" name="civil_status"
                                        value="{{ old('civil_status') }}">
                                    @error('civil_status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="cellphone_no" class="form-label">Cellphone No</label>
                                    <input type="text" class="form-control" id="cellphone_no" name="cellphone_no"
                                        value="{{ old('cellphone_no') }}">
                                    @error('cellphone_no')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="mb-2">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label">Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label for="password_confirmation" class="form-label">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>

                            <div class="d-flex justify-content-center mb-2 mt-3">
                                <button type="submit" class="btn btn-success w-50">Register</button>
                            </div>

                            <div class="d-flex justify-content-center">
                                Already have an account? &nbsp;<a href="{{ route('login') }}"> Login</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
