<div class="modal fade" id="followUpModal" tabindex="-1" aria-labelledby="followUpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="followUpModalLabel">Followup</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('follow-ups.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="patient_name">Patient Name</label>
                        <input type="hidden" name="record_id" id="record_id" class="form-control">
                        <input readonly type="text" name="patient_name" id="patient_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="form-control">
                        <div class="feedback"></div>
                        <p class="link"></p>
                    </div>

                    <div class="row">
                        <div class="col-md-6" id="startTimeDataform">
                            <label for="start_time">Start Time</label>
                            <input type="text" name="start_time" id="start_time" class="form-control validate">
                            <div class="invalid-feedback">Seleted time has been occupied on the date selected</div>
                        </div>
                        <div class="col-md-6" id="endTimeDataform">
                            <label for="end_time">End Time</label>
                            <input type="text" name="end_time" id="end_time" class="form-control validate">
                            <div class="invalid-feedback">Choose a End Time</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="service_id">Service</label>
                        <select name="service_id" id="service_id" class="form-select form-control">
                            <option value="">Service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                    {{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_price">Service Price</label>
                        <input readonly type="text" name="service_price" id="service_price" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control"></textarea>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('#service_id').on('change', function() {
            let price = $(this).find(':selected').data('price') ||
                '';
            $('#service_price').val(price);
        });
        const today = new Date().toISOString().split('T')[0];
        $('#date').attr('min', today);
        flatpickr("#start_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            minTime: "10:00",
            maxTime: "12:00",
            onChange: function(selectedDates, dateStr) {
                if (dateStr) {
                    const startTime = flatpickr.parseDate(dateStr, "H:i");
                    const endTimeMin = flatpickr.formatDate(new Date(startTime.getTime() + 60 * 60 *
                        1000), "H:i");
                    endTimePicker.set('minTime', endTimeMin);
                }
            }
        });

        const endTimePicker = flatpickr("#end_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            minTime: "13:00",
            maxTime: "17:00",
        });


        $('#date').on('change', function() {
            var selectedDate = $(this).val()
            $.ajax({
                url: '{{ route('admin.check-dates') }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    date: selectedDate
                },
                dataType: 'json',
                success: function(response) {
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
                        $('#submitBtn').prop('disabled', false)
                    }
                }
            })
        })
        $('#start_time').on('input', function() {
            var selectedDate = $('#date').val()
            var selectedStartTime = $(this).val()
            $.ajax({
                url: '{{ route('admin.start_time_check') }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    start_time: selectedStartTime,
                    date: selectedDate
                },
                dataType: 'json',
                success: function(response) {
                    if (response.exist) {
                        $('#start_time').addClass('is-invalid')
                        $('#submitBtn').prop('disabled', true)
                    } else {
                        $('#start_time').addClass('is-valid')
                        $('#start_time').removeClass('is-invalid')
                        $('#submitBtn').prop('disabled', false)

                    }

                }
            })
        })

    })
</script>
