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
                    <h1 class="m-0">Available Schedule</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Available Schedule</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid px-3 mt-5">
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
                <div id="calendar"></div>
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
                        Appointment
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        var scheds = [];
        var events = [];

        $(function() {
            $('#addScheduleButton').click(function() {
                var scheduleId = $(this).data('schedule-id');
                window.location.href = '{{ route('set-appointment', ':id') }}'.replace(':id',
                    scheduleId);
            });
            $(document).on('click', '.show_data', function() {
                var SchedId = $(this).data('id')
                $('#scheduleModal').modal('hide')
                $.ajax({
                    url: '{{ route('guest.fetch', '') }}/' +
                        SchedId,
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(currentUserSchedule) {
                        console.log(currentUserSchedule);
                        $('#currentUserscheduleModal').modal('show');
                        const startTime = currentUserSchedule.schedule.start_time;
                        const endTime = currentUserSchedule.schedule.end_time;

                        $('#currentUserscheduleModalLabel').html("<h6>" + currentUserSchedule
                            .schedule.date_added + " " +
                            startTime + " to " + endTime + "</h6>");
                        $('#selectedService').val(currentUserSchedule.service.name)
                        $('#patient_name').val(currentUserSchedule.user.full_name)
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching current user schedule:', error);
                    }
                });
            })


            $.ajax({
                url: '{{ route('guest.current') }}',
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log(data);
                    scheds = data;
                    scheds.forEach(function(row) {
                        var startTime = new Date(row.start);
                        var endTime = new Date(row.end);
                        var title = `${formatTime(startTime)} - ${formatTime(endTime)}`;
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
                                url: '{{ route('guest-current-schedules') }}?id=' +
                                    eventId,
                                method: 'GET',
                                success: function(scheduledUsers) {
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
    </script>
@endsection
