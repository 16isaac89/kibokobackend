@extends('layouts.dealer')

@section('content')


<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Van {{ $van->name }} Stock Count</h5>
    </div>
    <div class="card-body">
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(count($dispatches) > 0)
            <div class="mb-3">
                <label for="countdate" class="form-label fw-bold">Count Date</label>
                <input type="text" name="countdate" class="form-control datetime" id="countdate" placeholder="Select date">
            </div>

            <form method="post" action="{{ route('dealer.vans.savecount') }}">
                @csrf
                <input type="hidden" name="dispatch" value="{{ $dispatch }}">
                <input type="hidden" name="van_id" value="{{ $van_id }}">

                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th width="150px">Name</th>
                                <th width="150px">Dispatched</th>
                                <th width="150px">Sold (QTY)</th>
                                <th width="150px">Sold (Cash)</th>
                                <th width="150px">Difference</th>
                                <th width="150px">Count</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($dispatches as $dispatch)
                                <tr>
                                    <td>
                                        <input type="hidden" name="van" value="{{ $van->id }}">
                                        <input type="hidden" name="dispatches[]" value="{{ $dispatch->id }}">
                                        <input type="text" readonly value="{{ $dispatch->name }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" readonly value="{{ $dispatch->dispatchedquantity }}" name="price[]" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" readonly value="{{ $dispatch->sold }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" readonly value="{{ $dispatch->sold * $dispatch->sellingprice }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" readonly value="{{ $dispatch->dispatchedquantity - $dispatch->sold }}" name="unit[]" class="form-control">
                                    </td>
                                    <td>
                                        @if($dispatch->dispatchcount)
                                            <span class="badge bg-primary">{{ $dispatch->dispatchcount->count }}</span>
                                        @else
                                            <input type="number" required max="{{ $dispatch->dispatchedquantity }}" min="0"
                                                   max="{{ $dispatch->dispatchedquantity - $dispatch->sold }}" name="counts[]" class="form-control">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($dispatchcount > 0)
                    <p class="text-danger fw-bold">Already counted</p>
                @else
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="fas fa-save"></i> Save Count
                    </button>
                @endif
            </form>
        @else
            <div class="alert alert-warning text-center">
                <strong>No dispatch records found.</strong>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD',
        locale: 'en',
        icons: {
            up: 'fas fa-chevron-up',
            down: 'fas fa-chevron-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right'
        }
    });
</script>
@endsection
