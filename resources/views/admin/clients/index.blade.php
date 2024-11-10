@extends('admin.app')

@section('header')
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
    <div class="container-fluid px-3">
        <div class="card">
            <div class="card-body">
                <table class="table" id="dataTable">
                    <thead class="bg-black text-white">
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Cellphone #</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->first_name . ' ' . $client->middle_name . ' ' . $client->last_name . ' ' . $client->suffix }}
                                </td>
                                <td>{{ $client->age }}</td>
                                <td>{{ ucfirst($client->gender) }}</td>
                                <td>{{ $client->address }}</td>
                                <td>{{ $client->cellphone_no }}</td>
                                <td>
                                    <a href="{{ route('clients.show', $client) }}" class="btn btn-primary btn-sm">Record</a>
                                    <a href="{{ route('client-info', $client) }}" class="btn btn-success btn-sm">More
                                        Info</a>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="confirmArchive({{ $client->id }})">Archive</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function confirmArchive(clientId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Once archived, this client will be moved to the archived section.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, archive it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `clients/${clientId}/archive`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Success!',
                                    'Client has been archived.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message ||
                                    'Unable to archive client. Please try again.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            Swal.fire(
                                'Error!',
                                'Something went wrong. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
