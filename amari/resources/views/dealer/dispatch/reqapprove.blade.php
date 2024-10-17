@extends('layouts.dealer')
@section('content')
@include('dealer.dispatch.modals.reqitems')
<div class="card">
    <div class="card-header">
       Stock Request Approve
    </div>
<form method="post" action="{{route('dealer.postapprove.requests')}}">
    @csrf

    <input type="hidden" name="dispatchid" value="{{$dispatchid}}">
    <div class="card-body">
		<div class="col" style="margin-top:10px;">
		  </div>
          <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-requests"
            id="datatable-requests">
                <thead>
                <tr>
                    <th></th>
      <th scope="col" style="width:100px;">Item Desc</th>
      <th >Qty Requested</th>
    </tr>
                </thead>
                <tbody>
                   @foreach($records as $record)
                   <tr>
                    <td></td>
                   <td>{{$record->product->name ?? ''}}<input type="hidden" name="stockrequestproducts[]" value="{{$record->id}}"></td>
                   <td>{{$record->reqqty  ?? ''}}</td>
                   <tr>
                   @endforeach
                </tbody>
            </table>
            @switch($stockreqs->status)
              @case(2)
              <a href="{{ route('dealer.request.setasdelivered', $dispatchid) }}" class="btn btn-success">
                Set As Delivered
              </a>
              @break
              @case (4)
              <span class="badge badge-pill badge-success">Delivered</span>
            @break
              @case(3)
              <span class="badge badge-pill badge-warning">Rejected</span>
            @break
              @default
              <button type="submit" class="btn btn-success" >SAVE</button>
          @endswitch
            </div>
        </div>

        </div>

</form>
    </div>
</div>



@endsection
@section('scripts')
<script>
    (function() {
        $('#datatable-requests').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'colvis',
                'excel',
                'print',
                'copy', 'pdf', 'csv'
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
