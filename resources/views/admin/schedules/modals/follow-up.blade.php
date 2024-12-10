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
                    </div>

                    <div class="row">
                        <div class="col-md-6" id="startTimeDataform">
                            <label for="start_time">Start Time</label>
                            <input type="text" name="start_time" id="start_time" class="form-control validate">
                            <div class="invalid-feedback">Choose a Start Time</div>
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
                    <button type="submit" class="btn btn-success">Submit</button>
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

    })
</script>
