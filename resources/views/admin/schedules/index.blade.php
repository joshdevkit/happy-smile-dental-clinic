@extends('admin.app')

@section('header')
    <style>
        .active_list {
            color: green !important;

        }

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
                        <li class="breadcrumb-item"><a>Dashboard</a></li>
                        <li class="breadcrumb-item ">About Clients</li>
                        <li class="breadcrumb-item active_list">About Appointment</li>
                        <li class="breadcrumb-item">Profile</li>
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
                <button type="button" data-toggle="modal" data-target="#exampleModal"
                    class="btn btn-success float-right">Create
                    Schedule</button>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="calendar"></div>


            </div>
        </div>
        <div class="card mt-5">
            <div class="card-header">
                <h4>All Appointments</h4>
            </div>
            <div class="card-body">
                <table class="table" id="dataTable">
                    <thead class="bg-black text-white">
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Service</th>
                            <th>Start Date/Time</th>
                            <th>End Date/Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $data)
                            @foreach ($data->record as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>
                                        @if ($row->user_id)
                                            {{ $row->user->first_name }} {{ $row->user->middle_name }}
                                            {{ $row->user->last_name }} {{ $row->user->suffix ?? '' }}
                                        @elseif (!$row->user_id && $row->is_guest)
                                            {{ $row->guest_name }}
                                        @else
                                            {{ $row->walk_in_name }}
                                        @endif
                                    </td>

                                    <td>{{ $row->service->name ?? 'N/A' }}</td>
                                    <td>{{ date('F d, Y', strtotime($data->date_added)) }}
                                        {{ date('h:i A', strtotime($row->start_time)) }}
                                    </td>
                                    <td>
                                        {{ date('F d, Y', strtotime($data->date_added)) }}
                                        {{ date('h:i A', strtotime($row->end_time)) }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary resched" data-toggle="modal"
                                            data-target="#rescheduleModal" data-id="{{ $row->id }}"
                                            data-service="{{ $row->service->name }}">Re-schedule</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- resched modal -->

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
                <form id="rescheduleForm" action="{{ route('admin.reschedule') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="schedule_id" id="scheduleId">
                        <input type="hidden" name="new_date_id" id="new_date_id">
                        <div class="form-group">
                            <label for="resched_service_name">Service</label>
                            <input readonly type="text" name="resched_service_name" id="resched_service_name"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="resched_date_to_change">Select Avaiable Date</label>
                            <input type="date" name="resched_date_to_change" id="resched_date_to_change"
                                class="form-control">
                            <div class="feedback"></div>
                            <p class="link"></p>
                        </div>

                        <div class="form-group d-none" id="startTimeDataform">
                            <label for="reschedstartTimeData">Start Time</label>
                            <input type="text" name="reschedstartTimeData" id="reschedstartTimeData"
                                class="form-control validate">
                            <div class="invalid-feedback">Choose a Start Time</div>
                        </div>
                        <div class="form-group d-none" id="endTimeDataform">
                            <label for="reschedendTimeData">End Time</label>
                            <input type="text" name="reschedendTimeData" id="reschedendTimeData"
                                class="form-control validate">
                            <div class="invalid-feedback">Choose a End Time</div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submitBtn">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- schedule modal -->

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
                        Walk-in
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- current schedule on selected date on calendar -->

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

    <!-- adding walkin modal -->

    <div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="flex-grow-1">
                        <h4 class="modal-title text-center">Create Walk-in</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="submitForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_added">Date</label>
                                    <input readonly type="text" name="date_added" id="date_added"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Registered Client? </label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="forRegistered"
                                            name="classification" value="1">
                                        <label class="form-check-label" for="forRegistered">Registered</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="forUnregistered"
                                            name="classification" value="0">
                                        <label class="form-check-label" for="forUnregistered">Unregistered</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="serviceSelect">Choose Service</label>
                                    <select class="form-control" id="serviceSelect" name="service_id">
                                        <option value="">Select a service</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adminstartTimeData">Start Time</label>
                                    <input type="text" name="adminstartTimeData" id="adminstartTimeData"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="adminendTimeData">End Time</label>
                                    <input type="text" name="adminendTimeData" id="adminendTimeData"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="clientEmail">Email</label>
                                    <input type="email" name="clientEmail" id="clientEmail" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="clientName">Name</label>
                                    <input readonly type="text" name="clientName" id="clientName"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="service_Price">Servcie Price</label>
                                    <input disabled type="text" name="service_Price" id="service_Price"
                                        class="form-control">
                                </div>
                                <input type="hidden" name="selectedSchedID" id="selectedSchedID">
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="submitBtnWalkin">Appoint</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin.schedules.modals.create')
    <script>
        var scheds = [];
        var events = [];
        $(function() {
            $.ajax({
                url: '{{ route('admin.schedules') }}',
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

                        events.push({
                            id: row.id,
                            title: title,
                            start: row
                                .start,
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
                                url: '{{ route('admin-current-schedules.index') }}?id=' +
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
                                    // $('#selectedSchedID').val(eventId)
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


        $(document).ready(function() {
            $(document).on('click', '.show_data', function() {
                var SchedId = $(this).data('id')
                $('#scheduleModal').modal('hide')
                $.ajax({
                    url: '{{ route('admin.fetch', '') }}/' +
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

            $('#addScheduleButton').click(function() {
                $('#scheduleModal').modal('hide');
                $('#serviceModal').modal('show');
                const scheduleId = $(this).data('schedule-id');
                $('#selectedSchedID').val(scheduleId)
                $.ajax({
                    url: '{{ route('admin-sched-data') }}',
                    method: 'GET',
                    data: {
                        id: scheduleId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);

                        $('#date_added').val(response.date_added);
                        let scheduleStartTime = response.start_time;
                        let scheduleEndTime = response.end_time;

                        $('#adminstartTimeData').flatpickr({
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                            time_24hr: false,
                            minTime: scheduleStartTime,
                            maxTime: scheduleEndTime,
                        });

                        $('#adminendTimeData').flatpickr({
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
            })

            //function to retrieve services na naka base if registered or not

            $('input[name="classification"]').on('change', function() {
                var classification = $(this).val();
                if (classification === '0') {
                    $('#clientName').removeAttr('readonly')
                    $('#clientName').closest('.form-group').show();
                    $('#clientEmail').closest('.form-group').hide();
                } else {
                    $('#clientName').closest('.form-group').show();
                    $('#clientEmail').closest('.form-group').show();
                }

                $.ajax({
                    url: '{{ route('fetch-admin-services') }}',
                    type: 'GET',
                    data: {
                        classification: classification
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        $('#serviceSelect').empty().append(
                            '<option value="">Select a service</option>');

                        $.each(response.services, function(index, service) {
                            $('#serviceSelect').append(
                                `<option value="${service.id}" data-price="${service.price}">${service.name}</option>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.error('Error fetching services:', xhr);
                    }
                });
            });

            $('#clientEmail').on('change', function() {
                var clientEmail = $(this).val()
                $.ajax({
                    url: '{{ route('fetch-user-data') }}',
                    type: 'GET',
                    data: {
                        email: clientEmail
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        $('#clientName').val(response.user_fullname)
                    }
                })
            })

            $('#serviceSelect').on('change', function() {
                const selectedPrice = $('#serviceSelect option:selected').data('price');
                $('#service_Price').val(selectedPrice ? selectedPrice :
                    '');
            });


            $('#submitForm').submit(function(e) {
                e.preventDefault();
                $('.form-group .text-danger').remove();

                $.ajax({
                    url: '{{ route('admin-walkin') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#serviceModal').modal('hide');
                            }
                        });
                    },

                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;

                            for (const field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    const errorMessages = errors[field];
                                    const errorList = errorMessages.map(error =>
                                        `<div class="text-danger">${error}</div>`).join('');
                                    $(`[name="${field}"]`).closest('.form-group').append(
                                        errorList);
                                }
                            }
                        }
                    }
                });
            });

            $(document).on('click', '.resched', function() {
                var today = new Date();
                var day = ("0" + today.getDate()).slice(-2);
                var month = ("0" + (today.getMonth() + 1)).slice(-2);
                var year = today.getFullYear();
                var formattedDate = year + "-" + month + "-" + day;

                $("#resched_date_to_change").attr("min", formattedDate);
                var schedId = $(this).data('id')
                $('#resched_service_name').val($(this).data('service'))
                $('#scheduleId').val(schedId)
                $('#resched_date_to_change').on('change', function() {
                    var selectedDate = $(this).val()
                    $.ajax({
                        url: '{{ route('admin.check-dates') }}',
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
                            if (response.data.length === 0) {
                                $("#startTimeDataform").addClass('d-none');
                                $('#endTimeDataform').addClass('d-none');
                                $('#resched_date_to_change').removeClass('is-valid')
                                    .addClass(
                                        'is-invalid');
                                $('.feedback').html(
                                        '<div><p>Date is not available. Please choose another date.</p></div>'
                                    )
                                    .removeClass('text-success')
                                    .addClass('text-danger');
                                $('#submitBtn').prop('disabled', true)

                            } else {
                                $('.link').addClass('d-none')
                                $("#startTimeDataform").removeClass('d-none');
                                $('#endTimeDataform').removeClass('d-none');
                                $('#resched_date_to_change').removeClass('is-invalid')
                                    .addClass(
                                        'is-valid');

                                $('.feedback').html(
                                        '<div><p>This Date is eligible for re-scheduling.</p></div>'
                                    )
                                    .removeClass('text-danger')
                                    .addClass('text-success');
                            }
                            let scheduleStartTime = response.data[0].start_time;
                            let scheduleEndTime = response.data[0].end_time;
                            $('#new_date_id').val(response.data[0].id)
                            if (!$('#reschedstartTimeData').data('flatpickr')) {
                                $('#reschedstartTimeData').flatpickr({
                                    enableTime: true,
                                    noCalendar: true,
                                    dateFormat: "H:i",
                                    time_24hr: false,
                                    minTime: scheduleStartTime,
                                    maxTime: scheduleEndTime,
                                });
                            }

                            if (!$('#reschedendTimeData').data('flatpickr')) {
                                $('#reschedendTimeData').flatpickr({
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
            })

        });
    </script>
@endsection
