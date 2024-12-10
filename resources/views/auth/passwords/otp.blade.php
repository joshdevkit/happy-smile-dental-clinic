@extends('layouts.app')

@section('content')
    <div class="container mt-5 py-5">
        <form method="POST" action="{{ route('verifyOtp') }}">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card bg-white">
                        <div class="card-header border-0 bg-white text-center py-5">
                            <h3 class="fw-bold mb-5">{{ __('Reset your Password') }}</h3>
                            Please provide the OTP sent to your email. <br>
                        </div>
                        <div class="card-body border-0 bg-white">
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="otp">OTP</label>
                                    <input type="text" name="otp" id="otp" class="form-control" required>
                                </div>
                                @error('otp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="form-group d-flex justify-content-center mt-5">
                                    <button type="submit" class="btn btn-primary w-50">Verify OTP</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
