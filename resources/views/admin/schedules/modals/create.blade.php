<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="form-control validate" required>
                        <div class="feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="start_time">Start Time</label>
                        <input type="text" name="start_time" id="start_time" class="form-control" required />
                    </div>
                    <div class="form-group mb-3">
                        <label for="end_time">End Time</label>
                        <input type="text" name="end_time" id="end_time" class="form-control" required />
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

        $('#date').on('input', function() {
            var dateSelected = $(this).val();
            $.ajax({
                url: '{{ route('date.validate', '') }}/' + dateSelected,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    $('#date').removeClass('is-valid is-invalid');
                    $('.feedback').removeClass('text-success text-danger').html('');

                    if (response.status === 'not_exists') {
                        $('#date').addClass('is-valid');
                        $('.feedback').addClass('text-success').html(response
                            .message);
                    } else {
                        $('#date').addClass('is-invalid');
                        $('.feedback').addClass('text-danger').html(response
                            .message);
                    }
                }
            });
        });

    });
</script>
