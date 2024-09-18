@extends('layouts.dealer')
@section('content')
@include('dealer.dispatch.modals.reqitems')
<div class="card">
    <div class="card-header">
       Stock Requests
    </div>

    <div class="card-body">
		<div class="col" style="margin-top:10px;align-items:center;">
        <form method="post" action="{{route('dealer.searchstock.requests')}}">
            @csrf
            <div class="row" style="margin:10px;">

            <div class="col-4">
			{{-- <label class="mr-sm-2" for="inlineFormCustomSelect">Van</label> --}}
			<select class="custom-select mr-sm-2" name="van">
			  <option selected>Choose van.</option>
			  @foreach ($vans as $van)
			  <option value="{{$van->id}}">{{$van->name}} {{$van->reg_id}}</option>
			  @endforeach
			</select>
</div>
<div class="col-4">
<select class="custom-select mr-sm-2" aria-label="Default select example" name="status">
  <option selected>Select Status</option>
  <option value="1">Pending</option>
  <option value="2">Approved</option>
  <option value="3">Rejected</option>
</select>  
</div>
<div class="col-4">
            <button type="submit" class="btn btn-success">Search</button>
</div>
</div>
</form>
		  </div>
          <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-dispatch" id="datatable-dispatch">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                       
                        <th>
                            Date
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                           Van
                        </th>
                        <th>
                            Initiator
                        </th>
                        <th>
                            Type
                        </th>
                        <th>
                            View
                        </th>
                    </tr>
                </thead>
                <tbody>
                   
                 @foreach($records as $record)
                    <tr>
                    <th scope="row">1</th>
                    <td>{{$record->created_at}}</td>
                    <td>
                   @if($record->status === 1)
                   <span class="badge badge-pill badge-primary">Pending</span>
                   @elseif($record->status === 2)
                   <span class="badge badge-pill badge-success">Approved</span>
                   @elseif($record->status === 3)
                   <span class="badge badge-pill badge-danger">Rejected</span>
                   @endif
                    <td>
                        {{$record->van->name}}
                    </td>
                    <td>
                    {{$record->saler->phone}}
</td>
<td>
@if($record->requesttype === 1)
<span class="badge badge-pill badge-success">NEW</span>
@elseif($record->requesttype === 2)
<span class="badge badge-pill badge-primary">TOP UP</span>
@elseif($record->requesttype === 3)
<span class="badge badge-pill badge-info">CUSTOMER</span>
@endif
</td>
<td>
<!-- <a data-id="{{$record->id}}" data-items="{{$record->items}}" data-status="{{$record->status}}" data-toggle="modal" data-target="#requestitems">
                    <i class="fa fa-clone fa-2x"  aria-hidden="true"></i>
                        </a> -->
                        <a href="{{route('dealer.approve.requests',['stockrequest'=>$record->id])}}">
                    <i class="fa fa-clone fa-2x"  aria-hidden="true"></i>
                        </a>
</td>
                    </tr>
                  @endforeach 
                   
                   
                </tbody>
            </table>
            </div>
        </div>        
        </div>
    </div>
</div>



@endsection
@section('scripts')
<script>
       $('#requestitems').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  document.getElementById('dispatchid').value = id
  document.getElementById('rejectid').value = id
  var items = button.data('items') // Extract info from data-* attributes
  var status = button.data('status')
  if(status === 1){
    document.getElementById('submitapproval').style.display = "block"
    document.getElementById('submitreject').style.display = "block"
  }else{
    document.getElementById('submitapproval').style.display = "none"
    document.getElementById('submitreject').style.display = "none"
  }
  document.getElementById('reqsitems').innerHTML = ""
            items.forEach((item)=>{
                var tr = '<tr>'+
                '<td style="width:100px;"><b><span style="font-weight:bold;font-family: Poppins;">'+item.product.name+'</span></b></td>'+
               '<td><input type="hidden" name="product[]" value="'+item.product.id +'"placeholder="'+item.product.name+'" required class="form-control product" ></td>'+
               '<td style="width:100px;" ><b><span>'+item.reqqty+'</span></b></td>'+
               '<td style="width:100px;">'+
               '<select class="custom-select">'+
                '<option selected>Open this select menu</option>'+
                '</select>'
               +'</td>'+
               '<td ><input style="width:100px;" type="text" name="quantity[]" required class="form-control"></td>'+
          '</tr>';
  $('#reqsitems').append(tr);
            })
})
    </script>
    
@endsection