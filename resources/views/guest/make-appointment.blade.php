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
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item active">Make an Appointment</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid px-3">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center" style="color: green;">MAKE AN APPOINTMENT</h2>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('store-appointment') }}" method="POST">
                    @csrf

                    <h4>Appointment Details</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="service">Services</label>
                            <select name="service_id" id="service_id" class="form-control"
                                onchange="updateServiceDetails()">
                                <option value="">Select Services</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}"
                                        data-fee="{{ $service->reserve_fee }}"
                                        {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p>Sign up for more services.</p>
                        </div>
                        <div class="col-md-4">
                            <label for="start_time">Start Time</label>
                            <input type="text" name="start_time" id="start_time" class="form-control"
                                value="{{ old('start_time') }}" />
                        </div>
                        <div class="col-md-4">
                            <label for="end_time">End Time</label>
                            <input type="text" name="end_time" id="end_time" class="form-control"
                                value="{{ old('end_time') }}" />
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <label for="price">Price</label>
                            <input type="text" id="price" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="reservation_fee">Reservation Fee</label>
                            <input type="text" id="reservation_fee" class="form-control" readonly>
                        </div>
                    </div>
                    <hr>
                    <h4>Contact Information</h4>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="firsname">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control"
                                value="{{ old('firstname') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="middlename">Middle Name</label>
                            <input type="text" name="middlename" id="middlename" class="form-control"
                                value="{{ old('middlename') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control"
                                value="{{ old('lastname') }}">
                        </div>
                    </div>
                    <div class="row justify-content-between mb-4">
                        <div class="col-md-4">
                            <label for="contact">Contact No</label>
                            <input type="text" name="contact" id="contact" class="form-control"
                                value="{{ old('contact') }}">
                        </div>

                        <div class="col-md-4">
                            <label for="email">Email</label>
                            <input readonly type="text" name="email" id="email" class="form-control"
                                value="{{ Session::get('otp_email') }}">
                        </div>
                    </div>
                    {{-- <div class="form-group mt-3">
                        <label for="address">Complete Address</label>
                        <textarea name="address" id="address" rows="2" class="form-control">{{ old('address') }}</textarea>
                    </div> --}}
                    <input type="hidden" name="sched_id" id="sched_id" value="{{ request()->route('id') }}">

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            var schedId = $('#sched_id').val()

            $.ajax({
                url: '{{ route('sched-details') }}',
                type: 'GET',
                data: {
                    id: schedId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (!$('#start_time').data('flatpickr')) {
                        $('#start_time').flatpickr({
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                            time_24hr: false,
                            minTime: response.start_time,
                            maxTime: response.end_time,
                        });
                    }
                    if (!$('#end_time').data('flatpickr')) {
                        $('#end_time').flatpickr({
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                            time_24hr: false,
                            minTime: response.start_time,
                            maxTime: response.end_time,
                        });
                    }
                }
            })
        });

        function updateServiceDetails() {
            const selectedOption = document.getElementById("service_id").selectedOptions[0];
            const price = selectedOption.getAttribute("data-price");
            const reservationFee = selectedOption.getAttribute("data-fee");

            document.getElementById("price").value = price ? `${price}` : "";
            document.getElementById("reservation_fee").value = reservationFee ? `${reservationFee}` : "";
        }
    </script>
@endsection
