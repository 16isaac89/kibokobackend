@extends('layouts.admin')
@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Customers Updated</h5>
    </div>

    <div class="card-body">
        {{-- Date Filter --}}
        <form method="GET" class="mb-3 d-flex align-items-center gap-2 flex-wrap">
            <label for="date" class="mb-0">Select Date:</label>
            <input type="date" name="date" id="date" class="form-control w-auto" value="{{ $date }}">
            <button class="btn btn-primary">Filter</button>
        </form>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered" id="customers-updated-table">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td></td>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No records found for {{ $date }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#customers-updated-table').DataTable({
            "order": [[0, "desc"]],
            "pageLength": 25,
            "lengthMenu": [10, 25, 50, 100],
            responsive: true
        });
    });
</script>
@endsection
