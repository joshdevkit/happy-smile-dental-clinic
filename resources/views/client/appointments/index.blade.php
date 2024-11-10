@extends('client.app')

@section('header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Appointments</li>
                        <li class="breadcrumb-item ">Profile</li>
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
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <table class="table" id="dataTable">
                    <thead class="bg-black text-white">
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Service</th>
                            <th>Appointment Date</th>
                            <th>Service Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointment as $schedule)
                            <tr>
                                <td>{{ $schedule->id }}</td>
                                <td>{{ trim("{$schedule->user->first_name} {$schedule->user->middle_name} {$schedule->user->last_name}") }}
                                </td>
                                <td>{{ $schedule->service->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->schedule->date_added)->format('M/d/Y') }}</td>
                                <td>{{ $schedule->service->price }}</td>
                                <td>
                                    <span
                                        class="badge
                                        @if ($schedule->status == 'Pending') badge-warning
                                        @elseif($schedule->status == 'Success') badge-success
                                        @elseif($schedule->status == 'Not Attended') badge-danger
                                        @elseif($schedule->status == 'Confirmed') badge-info
                                        @elseif($schedule->status == 'Cancelled') badge-dark @endif">
                                        {{ $schedule->status }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $scheduledDate = \Carbon\Carbon::parse($schedule->schedule->date_added);
                                        $threeDaysBefore = $scheduledDate->copy()->subDays(3);
                                        $today = \Carbon\Carbon::today();
                                    @endphp

                                    @if ($today->greaterThanOrEqualTo($threeDaysBefore) && $today->lessThanOrEqualTo($scheduledDate))
                                        <button type="button" class="btn btn-sm btn-primary resched" data-toggle="modal"
                                            data-target="#rescheduleModal" data-id="{{ $schedule->id }}"
                                            data-service="{{ $schedule->service->name }}">Re-schedule</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Reschedule Modal -->
    <div class="modal fade" id="rescheduleModal" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rescheduleModalLabel">Re-schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rescheduleForm" action="{{ route('reschedule') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="schedule_id" id="scheduleId">
                        <input type="hidden" name="new_date_id" id="new_date_id">
                        <div class="form-group">
                            <label for="service_name">Service</label>
                            <input readonly type="text" name="service_name" id="service_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="date_to_change">Select Avaiable Date</label>
                            <input type="date" name="date_to_change" id="date_to_change" class="form-control">
                            <div class="feedback"></div>
                        </div>

                        <div class="form-group d-none" id="startTimeDataform">
                            <label for="startTimeData">Start Time</label>
                            <input type="text" name="startTimeData" id="startTimeData" class="form-control validate">
                            <div class="invalid-feedback">Choose a Start Time</div>
                        </div>
                        <div class="form-group d-none" id="endTimeDataform">
                            <label for="endTimeData">End Time</label>
                            <input type="text" name="endTimeData" id="endTimeData" class="form-control validate">
                            <div class="invalid-feedback">Choose a End Time</div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {

            var today = new Date();
            var day = ("0" + today.getDate()).slice(-2);
            var month = ("0" + (today.getMonth() + 1)).slice(-2);
            var year = today.getFullYear();
            var formattedDate = year + "-" + month + "-" + day;

            $("#date_to_change").attr("min", formattedDate);
            $(document).on('click', '.resched', function() {
                var schedID = $(this).data('id')
                var service = $(this).data('service')
                $('#service_name').val(service)
                $('#scheduleId').val(schedID)
            })

            $('#date_to_change').on('change', function() {
                var selectedDate = $(this).val()
                $.ajax({
                    url: '{{ route('check-dates') }}',
                    type: 'GET',
                    data: {
                        date: selectedDate
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.data === '') {
                            $("#startTimeDataform").addClass('d-none');
                            $('#endTimeDataform').addClass('d-none');

                            $('#date_to_change').removeClass('is-valid').addClass('is-invalid');

                            $('.feedback').html(
                                    '<div><p>Date is not available to the Schedule.</p></div>')
                                .removeClass('text-success')
                                .addClass('text-danger');
                        } else {
                            $("#startTimeDataform").removeClass('d-none');
                            $('#endTimeDataform').removeClass('d-none');

                            $('#date_to_change').removeClass('is-invalid').addClass('is-valid');

                            $('.feedback').html(
                                    '<div><p>This Date is eligible for re-scheduling.</p></div>'
                                )
                                .removeClass('text-danger')
                                .addClass('text-success');
                        }

                        let scheduleStartTime = response.data[0].start_time;
                        let scheduleEndTime = response.data[0].end_time;
                        $('#new_date_id').val(response.data[0].id)
                        if (!$('#startTimeData').data('flatpickr')) {
                            $('#startTimeData').flatpickr({
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: "H:i",
                                time_24hr: false,
                                minTime: scheduleStartTime,
                                maxTime: scheduleEndTime,
                            });
                        }

                        if (!$('#endTimeData').data('flatpickr')) {
                            $('#endTimeData').flatpickr({
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: "H:i",
                                time_24hr: false,
                                minTime: scheduleStartTime,
                                maxTime: scheduleEndTime,
                            });
                        }
                    }
                })
            })

            $(document).on('submit', '#rescheduleForm', function(event) {
                event.preventDefault();

                let isValid = true;
                $('.validate').each(function() {
                    if ($(this).val() === "") {
                        $(this).addClass('is-invalid');
                        $(this).removeClass('is-valid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                    }
                });

                if (isValid) {
                    this.submit();
                }
            });
        });
    </script>
@endsection
