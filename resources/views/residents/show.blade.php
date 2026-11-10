<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Details - Brgy. Magsaysay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">👤 Resident Information</h4>
                        <!-- Back button sa taas ng card -->
                        <a href="{{ route('residents.index') }}" class="btn btn-light btn-sm">Back to Directory</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 30%;">Full Name</th>
                                <td>{{ $resident->last_name }}, {{ $resident->first_name }} {{ $resident->middle_name }}</td>
                            </tr>
                            <tr>
                                <th>Birthdate</th>
                                <td>{{ $resident->birthdate }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{ $resident->gender }}</td>
                            </tr>
                            <tr>
                                <th>Civil Status</th>
                                <td>{{ $resident->civil_status }}</td>
                            </tr>
                            <tr>
                                <th>Purok / Sitio</th>
                                <td>{{ $resident->purok_sitio }}</td>
                            </tr>
                            <tr>
                                <th>Employment Status</th>
                                <td>{{ $resident->employment_status ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td>{{ $resident->contact_number ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Voter Status</th>
                                <td>{{ $resident->is_voter ? 'Registered Voter' : 'Not a Voter' }}</td>
                            </tr>
                            <tr>
                                <th>Complete Address</th>
                                <td>{{ $resident->address }}</td>
                            </tr>
                        </table>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('residents.index') }}" class="btn btn-secondary">Back</a>
                            <a href="{{ route('residents.edit', $resident->id) }}" class="btn btn-warning">Edit Resident</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>