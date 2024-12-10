@extends('layouts.app')

@section('content')
    <div class="container mt-5 py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-white">
                    <div class="card-header border-0 bg-white text-center py-5">
                        <h3 class="fw-bold mb-5">{{ __('Reset your Password') }}</h3>
                        Please provide the email address when you signed up your account. <br>
                        If you forgot your email. Please <strong class="text-primary">Contact Us.</strong>
                    </div>
                    <div class="card-body border-0 bg-white">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group d-flex justify-content-center mt-5">
                                <button type="submit" class="btn btn-primary w-50">Reset Password</button>
                            </div>
                        </form>
                    </div>
                    <p class="text-center">Create new account? <a href="{{ route('register') }}">Register</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
