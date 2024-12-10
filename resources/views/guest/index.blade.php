@extends('layouts.app')

@section('content')
    <div class="container py-5 mt-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="bg-white shadow rounded">
                    <div class="card border-0 bg-white mb-5">
                        <div class="card-header text-center text-success border-0 bg-white">
                            <h2 class="mt-5">BOOK NOW</h2>
                        </div>
                        <div class="card-body mb-5">
                            <div class="row">
                                <form action="{{ route('appointment.store') }}" method="POST">
                                    @csrf
                                    <div class="col-md-7 mx-auto">
                                        <div class="form-group">
                                            <label for="GuestemailAddress">Email</label>
                                            <input type="email" name="GuestemailAddress" id="GuestemailAddress"
                                                class="form-control">
                                        </div>
                                        <div class="form-group mt-5">
                                            <button type="submit" class="btn btn-primary w-100">Enter</button>
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
