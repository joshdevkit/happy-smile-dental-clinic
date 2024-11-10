@extends('client.app')

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
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div id="calendar"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="flex-grow-1">
                        <h6 class="modal-title">Information</h6>
                        <h6 class="modal-title" id="scheduleModalLabel"></h6>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="scheduledUsersList"></div>
                    <div id="userScheduleStatus"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="addScheduleButton">Add
                        Schedule
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="currentUserscheduleModal" tabindex="-1" role="dialog"
        aria-labelledby="currentUserscheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="flex-grow-1">
                        <h6 class="modal-title">Information</h6>
                        <h6 class="modal-title" id="currentUserscheduleModalLabel"></h6>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="serviceSelect">Service:</label>
                        <input type="text" disabled id="selectedService" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="serviceSelect">Patient Name</label>
                        <input type="text" disabled id="patient_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="serviceSelect">Service Price:</label>
                        <input type="text" disabled id="servicePrice" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a id="viewAppointmentButton" class="btn btn-primary d-none"
                        href="{{ route('my-appointment') }}">View</a>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="submitForm" action="{{ route('current-schedules.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="selectedSchedID" id="selectedSchedID">
                        <div class="form-group">
                            <label for="serviceSelect">Patient Name</label>
                            <input type="text" disabled
                                value="{{ Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="date_added">Date</label>
                            <input readonly type="text" name="date_added" id="date_added"
                                class="form-control validate">
                        </div>
                        <div class="form-group">
                            <label for="serviceSelect">Choose Service</label>
                            <select class="form-control validate" id="serviceSelect" name="service_id">
                                <option value="">Select a service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" data-duration="{{ $service->duration }}">
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="startTimeData">Start Time</label>
                            <input type="text" name="startTimeData" id="startTimeData" class="form-control validate">
                        </div>
                        <div class="form-group">
                            <label for="endTimeData">End Time</label>
                            <input type="text" name="endTimeData" id="endTimeData" class="form-control validate">
                        </div>
                        <div class="form-group">
                            <label for="servicePrice">Service Price</label>
                            <input readonly type="text" name="servicePriceselected" id="servicePriceselected"
                                class="form-control ">
                        </div>
                        <div class="form-group">
                            <label for="serviceReserveFee">Reservation Fee</label>
                            <input readonly type="text" name="serviceReserveFee" id="serviceReserveFee"
                                class="form-control ">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        var scheds = [];
        var events = [];
        var currentUserId = {{ Auth::user()->id }};

        $(function() {
            $.ajax({
                url: '{{ route('users.schedules') }}',
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    scheds = data;
                    scheds.forEach(function(row) {
                        var startTime = new Date(row.start);
                        var endTime = new Date(row.end);
                        var title = `${formatTime(startTime)} - ${formatTime(endTime)}`;
                        var SpecifiedDate = row.date_dedicated;

                        events.push({
                            id: row.id,
                            title: title,
                            start: row.start,
                            end: row.end,
                            headerTitle: row.headerTitle,
                            className: 'hover-pointer'
                        });
                    });
                    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                        headerToolbar: {
                            left: 'prev,next today',
                            right: 'dayGridMonth,dayGridWeek,list',
                            center: 'title',
                        },
                        selectable: true,
                        themeSystem: 'bootstrap',
                        events: events,
                        editable: false,
                        validRange: {
                            start: new Date().toISOString().split('T')[
                                0]
                        },
                        eventClick: function(info) {
                            var eventId = info.event.id;
                            var headerTitle = info.event.extendedProps
                                .headerTitle;
                            var start = info.event.extendedProps.start
                            var end = info.event.extendedProps.end
                            $.ajax({
                                url: '{{ route('current-schedules.index') }}?id=' +
                                    eventId,
                                method: 'GET',
                                success: function(scheduledUsers) {
                                    console.log(scheduledUsers);
                                    $('#scheduleModal').modal('show');
                                    $('#scheduleModalLabel').html('<h6>' +
                                        headerTitle + '</h6>');
                                    $('#scheduledUsersList').empty();
                                    $('#userScheduleStatus').empty();
                                    $('#startTimeData').val(start);
                                    $('#endTimeData').val(end);

                                    $('#addScheduleButton').data('schedule-id',
                                        eventId);
                                    console.log(scheduledUsers);

                                    if (scheduledUsers.length === 0) {
                                        $('#scheduledUsersList').append(
                                            '<div class="text-center">No Schedule available for this Date</div>'
                                        );
                                    } else {
                                        scheduledUsers.forEach(function(
                                            schedule) {
                                            const currentDate =
                                                new Date().toISOString()
                                                .split('T')[0];
                                            const startTime = new Date(
                                                `${currentDate}T${schedule.start_time}`
                                            );
                                            const endTime = new Date(
                                                `${currentDate}T${schedule.end_time}`
                                            );
                                            let listItem = `
                                            <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2 shadow-sm">
                                                <div>
                                                    <span>${formatTime(startTime)} to ${formatTime(endTime)}</span>
                                                </div>`;
                                            if (schedule.user_id ===
                                                currentUserId) {
                                                listItem +=
                                                    `<span class="badge badge-success schedul_span">Your Schedule</span>`;
                                            }

                                            listItem += `
                                            <button type="button" data-id="${schedule.id}" class="btn btn-info btn-sm show_data">Show</button>
                                        </div>`;
                                            $('#scheduledUsersList')
                                                .append(listItem);
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error(
                                        'Error fetching scheduled users:',
                                        error);
                                }
                            });
                        }
                    });

                    calendar.render();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching schedules:', error);
                }
            });
        });

        function formatTime(date) {
            return date.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
        }



        $(document).ready(function() {
            $(document).on('click', '.show_data', function() {
                var SchedId = $(this).data('id')
                $('#scheduleModal').modal('hide')
                $.ajax({
                    url: '{{ route('current-schedules.show', '') }}/' +
                        SchedId,
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(currentUserSchedule) {
                        console.log(currentUserSchedule);
                        const userId = currentUserSchedule.user_id;
                        const currentUserId = {{ Auth::id() }};
                        if (userId === currentUserId) {
                            $('#viewAppointmentButton').removeClass('d-none')
                        } else {
                            $('#viewAppointmentButton').addClass('d-none');
                        }
                        $('#currentUserscheduleModal').modal('show');

                        const startTime = currentUserSchedule.schedule.start_time;
                        const endTime = currentUserSchedule.schedule.end_time;

                        $('#currentUserscheduleModalLabel').html("<h6>" + currentUserSchedule
                            .schedule.date_added + " " +
                            startTime + " to " + endTime + "</h6>");
                        $('#selectedService').val(currentUserSchedule.service.name)
                        $('#servicePrice').val(currentUserSchedule.service.price)
                        $('#patient_name').val(currentUserSchedule.user.full_name)
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching current user schedule:', error);
                    }
                });
            })
        })


        $('#addScheduleButton').click(function() {
            $('#scheduleModal').modal('hide');
            $('#serviceModal').modal('show');

            const scheduleId = $(this).data('schedule-id');
            $('#selectedSchedID').val(scheduleId)
            $.ajax({
                url: '{{ route('sched-data') }}',
                method: 'GET',
                data: {
                    id: scheduleId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    $('#date_added').val(response.date_added);
                    let scheduleStartTime = response.start_time;
                    let scheduleEndTime = response.end_time;

                    $('#startTimeData').flatpickr({
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        time_24hr: false,
                        minTime: scheduleStartTime,
                        maxTime: scheduleEndTime,
                    });

                    $('#endTimeData').flatpickr({
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        time_24hr: false,
                        minTime: scheduleStartTime,
                        maxTime: scheduleEndTime,
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching schedule data:", error);
                }
            });
        });

        $('#serviceSelect').on('change', function() {
            var selectedService = $(this).val();

            $.ajax({
                url: '{{ route('service-data') }}',
                method: 'GET',
                data: {
                    id: selectedService
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    $('#servicePriceselected').val(response.price);
                    $('#serviceReserveFee').val(response.reserve_fee);
                    $('#serviceSelect').find(`option[value='${selectedService}']`).data('duration',
                        response.duration);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching service data:", error);
                }
            });
        });

        $('#submitForm').submit(function(e) {
            e.preventDefault();
            let formIsValid = true;
            $('.validate').each(function() {
                if ($(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                    formIsValid = false;
                    setTimeout(() => {
                        $(this).removeClass('is-invalid');
                    }, 1500);
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            if (formIsValid) {
                this.submit();
            }
        })
    </script>
@endsection
