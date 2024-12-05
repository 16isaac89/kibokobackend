@extends('layouts.dealer')

@section('content')
<div class="container">
    <h2>Assigned Plans</h2>
    <table id="reproutes-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Route Name</th>
                <th>User</th>
                <th>Day</th>
                <th>Week</th>
                {{-- <th>Actions</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($reproutes as $reproute)
            <tr>
                <td>{{ $reproute->name }} ({{ $reproute->list->count() }})</td>
                <td>{{ $reproute->dealeruser->username ?? 'N/A' }}</td>
                <td>{{ $reproute->day }}</td>
                <td>{{ $reproute->week }}</td>
                {{-- <td>
                    <button class="btn btn-primary btn-sm expand-btn" data-id="{{ $reproute->id }}">Expand</button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $reproute->id }}">Delete</button>
                </td> --}}
            </tr>
            {{-- <tr class="list-row" id="list-{{ $reproute->id }}" style="display: none;">
                <td colspan="5">
                    <ul>
                        @foreach ($reproute->list as $customer)
                        <li>{{ $customer->name }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr> --}}
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    // Initialize DataTable
    $('#reproutes-table').DataTable();

    // Expand/Collapse button functionality
    $('.expand-btn').on('click', function () {
        const id = $(this).data('id');
        const listRow = $(`#list-${id}`);
        listRow.toggle();
    });

    // Delete button functionality
    $('.delete-btn').on('click', function () {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this RepRoute?')) {
            $.ajax({
                url: '/reproutes/' + id, // Adjust this route based on your Laravel routes
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    alert(response.message);
                    location.reload();
                },
                error: function (xhr) {
                    alert('Error deleting the RepRoute. Please try again.');
                },
            });
        }
    });
});
</script>
@endsection
