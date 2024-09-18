@extends('layouts.dealer')
@section('styles')
<style>
td.details-control {
    background: url('/images/logo/plus.png') no-repeat center center;
    cursor: pointer;
}
tr.details td.details-control {
    background: url('/images/logo/minus.png') no-repeat center center;
}
</style>
@endsection
@section('content')
@include('dealer.efrisdocs.modals.document')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">
      <div class="row">
      <form class="row g-3" method="post" action="{{route('dealer.creditnote.search')}}">
  @csrf
  <div class="row mb-5">
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Receipt Number</label>
    <input type="text" placeholder="Receipt number." class="form-control" name="sale">
  </div>
  <div class="col-6 mt-4">
    <button type="submit" class="btn btn-primary">Search</button>
  </div>
</div>
</form>
<!-- <button id="btn-show-all-children col-4" style="width:100px;border-radius:25px;margin:10px;" type="button">Expand All</button>
<button id="btn-hide-all-children col-4" style="width:100px;border-radius:25px;margin:10px;" type="button">Collapse All</button> -->
</div>
      <div class="table-wrapper">
        <table id="sales"  class="table display responsive nowrap">
          <thead>
            <tr>

              <th class="wd-15p text-center">Reference</th>
              <th class="wd-15p text-center">Date</th>
              <!-- <th class="wd-15p text-center">Total Before</th>
              <th class="wd-20p text-center">Total After</th> -->
              <th class="wd-20p text-center">Customer</th>
              {{-- <th class="wd-20p text-center">Status</th> --}}
              <th class="wd-20p text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($sales as $sale)
            <tr>
            <td>{{$sale->reference}}</td>
              <td>{{$sale->created_at}}</td>
              <!-- <td>{{$sale->beforetotal ?? ''}}</td>
              <td>{{$sale->aftertotal ?? ''}}</td> -->
              <td>{{$sale->sale->customer->name ?? ''}}</td>
               <td>
                @if($sale->status == '101' || $sale->status == '102' || $sale->status == '103' || $sale->status == '104')
                <a href="{{route('dealer.creditnote.details',['note'=>$sale->id])}}" class="btn btn-primary">
                    Details
                </a>
                @endif
                {{-- @if($sale->status === '0')
                <a data-id="{{$sale->id}}" href="{{route('dealer.creditnote.cancel',['note'=>$sale->id])}}" class="btn btn-primary" data-toggle="modal" data-target="#cancelnote">
                    Pending
                </a>
                @elseif($sale->status === '1')
                <a class="btn btn-warning">
                    Cancelled
                </a>
                @elseif($sale->status === '2')
                <a class="btn btn-success" data-toggle="modal" data-target="#cancelnote">
                    Approved
                </a>
                @endif --}}
              </td>
              <td>
                @if($sale->cr_inv_no)
                <a data-id="{{$sale->id}}" href="{{route('dealer.creditnote.cancel',['note'=>$sale->id])}}" class="btn btn-warning" data-toggle="modal" data-target="#cancelnote">
                    Cancel
                </a>
                @endif
                <a data-id="{{$sale->id}}" href="{{route('dealer.creditnote.status',['note'=>$sale->id])}}" class="btn btn-primary">
                    Check
                </a>
              </td>
            </tr>
        @endforeach
          </tbody>
        </table>
      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection
@section('scripts')
<script>
 $('#cancelnote').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
 document.getElementById('noteid').value = id
})

function reasoncodechanged(sel)
{
    if(sel.value === '103'){
        document.getElementById('statement').style.display = "block"
    }else{
        document.getElementById('statement').style.display = "none"
    }
}
      </script>



@endsection
