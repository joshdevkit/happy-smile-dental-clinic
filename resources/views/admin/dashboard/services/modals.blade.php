<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="addServiceForm" action="{{ route('services.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceModalLabel">Add Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="serviceName">Service Name</label>
                        <input type="text" class="form-control" id="serviceName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="form-group">
                        <label for="servicePrice">Service Price</label>
                        <input type="number" class="form-control" id="servicePrice" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="servicePrice">Reservation Fee</label>
                        <input type="number" class="form-control" id="reserve_fee" name="reserve_fee" required>
                    </div>
                    <div class="form-group">
                        <label for="serviceDuration">Duration (minutes)</label>
                        <input type="text" class="form-control" id="serviceDuration" name="duration" required>
                    </div>
                    <div class="form-group">
                        <label for="availability">Availability</label>
                        <select class="form-control" id="availability" name="availability" required>
                            <option value="available">Available</option>
                            <option value="not available">Not Available</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="classification">Clasification</label><br>
                        <input type="checkbox" name="classification" id="classification" value="1"> For Registered?
                        <br>
                        <input type="checkbox" name="classification" id="classification" value="0"> For
                        Unregistered?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Add Service</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editServiceForm">
                    @method('PUT')
                    <input type="hidden" name="serviceId" id="serviceId">
                    <div class="form-group">
                        <label for="editServiceName">Service Name</label>
                        <input type="text" class="form-control" id="editServiceName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editServiceDescription">Description</label>
                        <textarea name="description" id="editServiceDescription" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editServicePrice">Service Price</label>
                        <input type="number" class="form-control" id="editServicePrice" name="price" required>
                    </div>

                    <div class="form-group">
                        <label for="editReserveFee">Reserve Fee</label>
                        <input type="number" class="form-control" id="editReserveFee" name="editReserveFee"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="editServiceDuration">Duration</label>
                        <input type="text" class="form-control" id="editServiceDuration" name="duration"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="editAvailability">Availability</label>
                        <select class="form-control" id="editAvailability" name="availability" required>
                            <option value="available">Available</option>
                            <option value="not available">Not Available</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Classification</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="forRegistered" name="classification"
                                value="1">
                            <label class="form-check-label" for="forRegistered">For Registered</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="forUnregistered"
                                name="classification" value="0">
                            <label class="form-check-label" for="forUnregistered">For Unregistered</label>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Update Service</button>
            </div>
            </form>

        </div>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteServiceModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteServiceModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this service? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteServiceForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
