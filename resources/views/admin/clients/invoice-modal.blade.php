<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Transaction Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="printable" class="modal-body bg-gray-100 rounded-lg">
                <div class="form-group text-center py-4">
                    <h6 class="mb-3">Amount: <span class="amount">PHP 30,000</span></h6>
                    <h6>
                        Payment Status:
                        <span class="rounded-lg px-3 py-1 status"></span>
                    </h6>
                </div>
                <hr>
                <table class="table table-borderless mb-5">
                    <tbody>
                        <tr>
                            <td class="text-left">Transaction ID</td>
                            <td class="text-right font-weight-bold transaction-id">INV-123456</td>
                        </tr>
                        <tr>
                            <td class="text-left">Client Name</td>
                            <td class="text-right font-weight-bold client-name">John Doe</td>
                        </tr>
                        <tr>
                            <td class="text-left">Service</td>
                            <td class="text-right font-weight-bold service">Teeth Whitening</td>
                        </tr>
                        <tr>
                            <td class="text-left">Appointment Date</td>
                            <td class="text-right font-weight-bold appointment-date">2024-11-10</td>
                        </tr>
                        <tr>
                            <td class="text-left">Clinic Name</td>
                            <td class="text-right font-weight-bold clinic-name">Smile Clinic</td>
                        </tr>
                        <tr>
                            <td class="text-left">Payment Method</td>
                            <td class="text-right font-weight-bold payment-method">Credit Card</td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea disabled class="form-control remarks" rows="5">Thanks</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="printButton">Print</button>
            </div>

        </div>
    </div>
</div>
