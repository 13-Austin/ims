<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Magsaysay - Resident Directory</title>
    <!-- Using Bootstrap for immediate clean styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>📋 Resident Directory - Brgy. Magsaysay</h2>
                    <a href="{{ route('residents.create') }}" class="btn btn-primary">+ Add Resident</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Purok / Sitio</th>
                                    <th>Gender</th>
                                    <th>Civil Status</th>
                                    <th>Contact Number</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($residents as $resident)
                                    <tr>
                                        <td>{{ $resident->last_name }}, {{ $resident->first_name }} {{ $resident->middle_name }}</td>
                                        <td>{{ $resident->purok_sitio }}</td>
                                        <td>{{ $resident->gender }}</td>
                                        <td>{{ $resident->civil_status }}</td>
                                        <td>{{ $resident->contact_number ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('residents.show', $resident->id) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('residents.edit', $resident->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('residents.destroy', $resident->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this resident?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No residents recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>