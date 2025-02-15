@extends('layouts.dealer')

@section('content')
@include('dealer.dispatch.modals.reqitems')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Stock Request Approval</h5>
    </div>

    <form method="POST" action="{{ route('dealer.postapprove.requests') }}">
        @csrf
        <input type="hidden" name="dispatchid" value="{{ $dispatchid }}">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped datatable" id="datatable-requests">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th scope="col" style="width: 200px;">Item Description</th>
                            <th scope="col">Quantity Requested</th>
                            <th scope="col">Quantity to Give</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                        <tr>
                            <td></td>
                            <td>
                                {{ $record->product->name ?? '' }}
                                <input type="hidden" name="stockrequestproducts[]" value="{{ $record->id }}">
                            </td>
                            <td>{{ $record->reqqty ?? '' }}</td>
                            <td>
                                @if($record->appqty && $stockreqs->status == 2)
                                <input type="number" readonly required name="quantity[]" value="{{ $record->appqty ?? '' }}" class="form-control" min="1" required>
                                @else
                                <input type="number" required name="quantity[]"  class="form-control" min="1" required>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                @switch($stockreqs->status)
                    @case(2)
                        <a href="{{ route('dealer.request.setasdelivered', $dispatchid) }}" class="btn btn-success">
                            Set As Delivered
                        </a>
                        @break

                    @case(4)
                        <span class="badge badge-success">Delivered</span>
                        @break

                    @case(3)
                        <span class="badge badge-warning">Rejected</span>
                        @break

                    @default
                        <button type="submit" class="btn btn-primary">Save</button>
                @endswitch
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#datatable-requests').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'colvis', 'excel', 'print', 'copy', 'pdf', 'csv'
            ],
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                search: '',
            }
        });
    });
</script>
@endsection
