@extends('layouts.admin')
@section('content')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success">
                Van {{$van->name}} count
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
    <form class="row g-3" method="post" action="{{route('admin.vans.dispatched')}}">
        @csrf
  <div class="col-md-4">
    <label for="inputEmail4" class="form-label">From Date:</label>
    <input type="text" name="fromdate" class="form-control datetime" id="inputEmail4">
  </div>
  <input type="hidden" class="form-control" name="van" value="{{$van->id}}" id="inputEmail4">
  <div class="col-md-4">
    <label for="inputEmail4" class="form-label">To Date</label>
    <input type="text" name="todate" class="form-control datetime" id="inputEmail4">
  </div>
  <div class="col-4">
    <button type="submit" class="btn btn-primary">Search</button>
  </div>
</form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
       @if(count($dispatches)>0)  
       <div class="col-md-4">
    <label for="inputEmail4" class="form-label">Count Date</label>
    <input type="text" name="countdate" class="form-control datetime" id="inputEmail4">
  </div> 
        <table style="margin:10px;width:100%;">
	<tr>
		<td style="background-color:grey;text-align:center;width:150px;">Name</td>
		<td style="background-color:grey;text-align:center;width:150px;">Dispatched</td>
		<th style="background-color:grey;text-align:center;width:150px;">Sold</th>
		<th style="background-color:grey;text-align:center;width:150px;">Difference</th>
		<th style="background-color:grey;text-align:center;width:150px;">Count</th>
		</tr>
</table>
<form method="post" action="{{route('admin.save.count')}}">
	@csrf
	<TABLE id="dataTable"  style="width:100%;">
    @foreach($dispatches as $dispatch)
		<TR>		
            <TD style="text-align:center;width:150px;">
            <INPUT type="hidden" value="{{$van->id}}" name="van"/>
            <INPUT type="hidden" value="{{$dispatch->id}}" name="dispatches[]" value="{{$dispatch->id}}"/>
            <INPUT type="text" readonly value="{{$dispatch->name}}" class="form-control productunit"/>
        </TD>
            <TD style="text-align:center;width:150px;"><INPUT type="text"  value="{{$dispatch->dispatchedquantity}}" readonly name="price[]" class="form-control productprice"/></TD>
            <TD style="text-align:center;width:150px;"><INPUT type="text" value="{{$dispatch->sold}}" readonly  class="form-control producttotal"/></TD>
            <TD style="text-align:center;width:150px;"><INPUT type="text" readonly value="{{$dispatch->dispatchedquantity-$dispatch->sold}}" name="unit[]" class="form-control productunit"/></TD>
            <TD style="text-align:center;width:150px;"><INPUT type="number" required max="{{$dispatch->dispatchedquantity}}" min="0"   name="counts[]" class="form-control"/></TD>
		</TR>
    @endforeach
	</TABLE>
	<button style="margin:10px;" class="btn btn-primary">Save</button>
        @endif
        </div>
    </div>
</div>
</form>


@endsection
@section('scripts')
@parent

@endsection