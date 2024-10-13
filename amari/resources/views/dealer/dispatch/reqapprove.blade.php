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
            <table class=" table table-bordered table-striped table-hover datatable datatable-dispatch" id="datatable-dispatch">
                <thead>
                <tr>
      <th scope="col" style="width:100px;">Item Desc</th>
      <th scope="col" style="width:100px;">Qty Requested</th>
      <th scope="col" style="width:100px;">Batch</th>
      <th scope="col" style="width:100px;">Discount</th>
      @switch($stockreqs->status)
              @case(2)
              <th scope="col" style="width:100px;">Approved Quantity</th>
                  @break
              @case(3)
              <th scope="col" style="width:100px;">Rejected Quantity</th>
                  @break
              @default
              <th scope="col" style="width:100px;">Give</th>
          @endswitch

    </tr>
                </thead>
                <tbody>
                   @foreach($records as $record)
                   <tr>
                   <td>{{$record->product->name ?? ''}}<input type="hidden" name="stockrequestproducts[]" value="{{$record->id}}"></td>
                   <td>{{$record->reqqty  ?? ''}}</td>
                   <td>
                    @if($stockreqs->status === 2 || $stockreqs->status === 3)
                    <td>{{$record->appqty}}</td>
                    @else
                   {{-- <select class="custom-select" name="batches[]" >
                        <option selected value="0">Select batch to dispatch</option>
                        @foreach($record->product->stocks as $stock)
                        <option value="{{$stock->id}}">{{$stock->expirydate}} {{$stock->amount}} {{$stock->sellingprice}}</option>
                        @endforeach
                   </select> --}}
                   @endif
                   </td>
                   <td>
                    <input type="number" name="discounts[]" value="0">
                   </td>
                   <td>
                   @switch($stockreqs->status)
              @case(2)
              <span class="badge badge-pill badge-success">Approved</span>
                  @break
              @case(3)
              <span class="badge badge-pill badge-warning">Rejected</span>
                  @break
              @default
              <input type="number" name="gives[]">
          @endswitch

                  </td>
                   <tr>
                   @endforeach
                </tbody>
            </table>
            @switch($stockreqs->status)
              @case(2)
              <span class="badge badge-pill badge-success">Approved</span>
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


@endsection
