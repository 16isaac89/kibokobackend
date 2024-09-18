@extends('layouts.dealer')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success">
            Van {{$van->name}} count
        </a>
    </div>
</div>
<div class="card">
<div class="card-body">
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
   @if(count($dispatches)>0)
   <div class="col-md-4">
<label for="inputEmail4" class="form-label">Count Date</label>
<input type="text" name="countdate" class="form-control datetime" id="inputEmail4">
</div>
    <table style="margin:10px;">

</table>
<form method="post" action="{{route('dealer.vans.savecount')}}">
@csrf
<input value="{{$dispatch}}" name="dispatch" type="hidden">
<input value="{{$van_id}}" name="van_id" type="hidden">
<TABLE id="dataTable" class="table table-responsive">
    <thead>
    <tr>
        <td style="background-color:grey;text-align:center;width:150px;">Name</td>
        <td style="background-color:grey;text-align:center;width:150px;">Dispatched</td>
        <th style="background-color:grey;text-align:center;width:150px;">Sold(QTY)</th>
        <th style="background-color:grey;text-align:center;width:150px;">Sold(Cash)</th>
        <th style="background-color:grey;text-align:center;width:150px;">Difference</th>
        <th style="background-color:grey;text-align:center;width:150px;">Count</th>
        </tr>
    </thead>
<tbody>
@foreach($dispatches as $dispatch)
    <TR>
        <TD style="text-align:center;width:150px;">
        <INPUT type="hidden" value="{{$van->id}}" name="van"/>
        <INPUT type="hidden" value="{{$dispatch->id}}" name="dispatches[]" value="{{$dispatch->id}}"/>
        <INPUT type="text" readonly value="{{$dispatch->name}}" class="form-control productunit w-140 h-80" />
    </TD>
        <TD style="text-align:center;width:150px;"><INPUT type="text"   value="{{$dispatch->dispatchedquantity}}" readonly name="price[]" class="form-control productprice"/></TD>
        <TD style="text-align:center;width:150px;"><INPUT type="text" value="{{$dispatch->sold}}" readonly  class="form-control producttotal"/></TD>
            <TD style="text-align:center;width:150px;"><INPUT type="text" value="{{$dispatch->sold*$dispatch->sellingprice}}" readonly  class="form-control producttotal"/></TD>
        <TD style="text-align:center;width:150px;"><INPUT type="text" readonly value="{{$dispatch->dispatchedquantity-$dispatch->sold}}" name="unit[]" class="form-control productunit"/></TD>
        @if($dispatch->dispatchcount)
        <TD style="text-align:center;width:150px;">{{ $dispatch->dispatchcount->count }}</TD>
        @else
        <TD style="text-align:center;width:150px;"><INPUT type="number" required max="{{$dispatch->dispatchedquantity}}" min="0" max="{{$dispatch->dispatchedquantity-$dispatch->sold}}"   name="counts[]" class="form-control"/></TD>
        @endif
    </TR>
@endforeach
</tbody>
</TABLE>


    @if($dispatchcount > 0)
    Already counted
    @else
    <button style="margin:10px;" class="btn btn-primary">
    Save Count
</button>
    @endif

    @endif

</div>
</div>
</form>

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
})
</script>
@endsection
