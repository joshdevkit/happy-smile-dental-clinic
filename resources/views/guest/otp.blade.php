@extends('layouts.app')

@section('content')
    <div class="container py-5 mt-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="bg-white shadow rounded">
                    <div class="card border-0 bg-white mb-5">
                        <div class="card-header text-center border-0 bg-white">
                            <h2 class="mt-5 text-success ">VERIFICATION</h2>
                            <p class="text-center {{ session('message') ? 'text-danger' : 'text-success' }}">
                                {{ session('message') ?? 'We have sent a verification (One Time Pin) to your email. Please check it.' }}
                            </p>
                        </div>
                        <div class="card-body mb-5">
                            <div class="row">
                                <form action="{{ route('guest.verifyOtp') }}" method="POST">
                                    @csrf
                                    <div class="col-md-7 mx-auto">
                                        <div class="form-group">
                                            <label for="otp">OTP</label>
                                            <input type="text" name="otp" id="otp" class="form-control">
                                        </div>
                                        <div class="form-group mt-5">
                                            <button type="submit" class="btn btn-primary w-100">Verify</button>
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
@endsection
