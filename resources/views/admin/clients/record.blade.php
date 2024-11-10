@extends('admin.app')

@section('header')
    <style>
        .bg-gray-100 {
            background-color: #F7F9FA !important;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">About Clients</li>
                        <li class="breadcrumb-item">About Appointment</li>
                        <li class="breadcrumb-item">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid mt-3 py-4">
        <div class="col-md-4 d-flex justify-content-between">
            <input disabled type="text"
                value="{{ $clientsRecord->first()->user->first_name . ' ' . $clientsRecord->first()->user->middle_name . ' ' . $clientsRecord->first()->user->last_name }}"
                class="form-control mr-3">
            <input disabled type="text" value="{{ $totalRecord }}" class="form-control">
        </div>
        <table class="table" id="dataTable">
            <thead class="bg-black text-white">
                <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Appointment Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientsRecord as $record)
                    <tr>
                        <td>{{ $record->id }}</td>
                        <td>{{ $record->service->name }}</td>
                        <td>{{ date('F d, Y', strtotime($record->schedule->date_added)) . ' ' . date('h:i A', strtotime($record->start_time)) . ' - ' . date('h:i A', strtotime($record->end_time)) }}
                        </td>
                        <td>
                            <button type="button" data-toggle="modal" data-target="#invoiceModal"
                                data-id="{{ $record->id }}"
                                data-url="{{ route('client.transaction', ['id' => $record->id]) }}"
                                class="btn btn-primary btn-sm btn-invoice">Invoice</button>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('admin.clients.invoice-modal')

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.btn-invoice').on('click', function() {
                let url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        console.log(data);
                        $('#invoiceModal .transaction-id').text(data.transaction_id);
                        $('#invoiceModal .client-name').text(data.client_name);
                        $('#invoiceModal .service').text(data.service);
                        $('#invoiceModal .appointment-date').text(data.appointment_date);
                        $('#invoiceModal .clinic-name').text(data.clinic_name);
                        $('#invoiceModal .payment-method').text(data.payment_method);
                        $('#invoiceModal .amount').text(data.amount);
                        $('#invoiceModal .status').text(data.status);
                        // $('#invoiceModal .remarks').val(data.remarks);
                    },
                });
            });
        });
    </script>
    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            var modalBody = document.getElementById('printable').cloneNode(true);

            var printWindow = window.open('', '', 'height=1200,width=1200');

            var customStyles = `
            <style>
            body {
                font-family: Arial, sans-serif; /* Use the same font as Bootstrap */
                margin: 20px;
                padding: 0;
            }
            .bg-gray-100 {
                background-color: #F7F9FA !important;
                padding: 20px; /* Add padding */
                border-radius: 0.5rem; /* Same rounded corners */
            }
            .text-center {
                text-align: center;
            }
            .font-weight-bold {
                font-weight: bold;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 1rem;
            }
            .table-borderless td {
                border: none; /* Remove borders for a cleaner look */
                padding: 8px; /* Add some padding */
            }
            .form-group {
                margin-bottom: 1rem;
            }
            label {
                display: block;
                margin-bottom: 0.5rem;
            }
            textarea {
                width: 100%;
                padding: 8px;
                border: 1px solid #ced4da; /* Similar border to Bootstrap */
                border-radius: 0.25rem; /* Rounded corners for textarea */
                resize: vertical;
            }
        </style>
            `;

            printWindow.document.write('<html><head><title>Print Invoice</title>' + customStyles + '</head><body>');

            printWindow.document.write(modalBody.outerHTML);
            printWindow.document.write('</body></html>');

            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    </script>
@endsection
