@extends('layouts.dealer')

@section('content')
    @include('dealer.dispatch.modals.reqitems')

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Stock Requests</h5>
        </div>

        <div class="card-body">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-12">
                    <form method="post" action="{{ route('dealer.searchstock.requests') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <select class="custom-select" aria-label="Select Status" name="status">
                                    <option selected>Select Status</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Approved</option>
                                    <option value="3">Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <button type="submit" class="btn btn-success w-100">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Requests Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-requests" id="datatable-requests">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Initiator</th>
                            <th>Type</th>
                            <th>Customer</th>
                            <th>Route</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $record)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $record->created_at }}</td>
                                <td>
                                    @if ($record->status === 1)
                                        <span class="badge badge-pill badge-primary">Pending</span>
                                    @elseif($record->status === 2)
                                        <span class="badge badge-pill badge-success">Approved</span>
                                    @elseif($record->status === 3)
                                        <span class="badge badge-pill badge-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $record->saler->username }}</td>
                                <td>
                                    @if ($record->requesttype === 1)
                                        <span class="badge badge-pill badge-success">NEW</span>
                                    @elseif($record->requesttype === 2)
                                        <span class="badge badge-pill badge-primary">TOP UP</span>
                                    @elseif($record->requesttype === 3)
                                        <span class="badge badge-pill badge-info">CUSTOMER</span>
                                    @endif
                                </td>
                                <td><b>{{ $record->customer->name }}</b></td>
                                <td><b>{{ $record->customer->route->name }}</b></td>
                                <td>
                                    <a href="{{ route('dealer.approve.requests', ['stockrequest' => $record->id]) }}">
                                        <i class="fa fa-clone fa-2x" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Modal handling script -->
    <script>
        $('#requestitems').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var items = button.data('items');
            var status = button.data('status');

            document.getElementById('dispatchid').value = id;
            document.getElementById('rejectid').value = id;

            if (status === 1) {
                document.getElementById('submitapproval').style.display = "block";
                document.getElementById('submitreject').style.display = "block";
            } else {
                document.getElementById('submitapproval').style.display = "none";
                document.getElementById('submitreject').style.display = "none";
            }

            document.getElementById('reqsitems').innerHTML = "";
            items.forEach((item) => {
                var tr = '<tr>' +
                    '<td style="width:100px;"><b><span style="font-weight:bold;font-family: Poppins;">' + item.product.name + '</span></b></td>' +
                    '<td><input type="hidden" name="product[]" value="' + item.product.id + '" class="form-control product" required></td>' +
                    '<td style="width:100px;"><b>' + item.reqqty + '</b></td>' +
                    '<td><select class="custom-select"><option selected>Open this select menu</option></select></td>' +
                    '<td><input style="width:100px;" type="text" name="quantity[]" required class="form-control"></td>' +
                    '</tr>';
                $('#reqsitems').append(tr);
            });
        });
    </script>

    <!-- DataTables Initialization -->
    <script>
        (function() {
            $('#datatable-requests').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'colvis',
                    'excel',
                    'print',
                    'copy',
                    'pdf',
                    'csv'
                ],
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
            });
        })();
    </script>
@endsection
