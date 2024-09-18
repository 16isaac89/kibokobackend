@extends('layouts.dealer')
@section('styles')
<style>
.form-control:focus {
    box-shadow: none;
    border-color: #BA68C8
}

.profile-button {
    background: rgb(99, 39, 120);
    box-shadow: none;
    border: none
}

.profile-button:hover {
    background: #682773
}

.profile-button:focus {
    background: #682773;
    box-shadow: none
}

.profile-button:active {
    background: #682773;
    box-shadow: none
}

.back:hover {
    color: #682773;
    cursor: pointer
}

.labels {
    font-size: 11px
}

.add-experience:hover {
    background: #BA68C8;
    color: #fff;
    cursor: pointer;
    border: solid 1px #BA68C8
}
</style>
@endsection
@section('content')
<div class="am-pagebody">
  @include('dealer.sales.modals.document')

    <div class="card pd-20 pd-sm-40">
    @if (\Session::has('errors'))
    <div class="alert alert-warning">
        <ul>
            <li>{!! \Session::get('errors') !!}</li>
        </ul>
    </div>
@endif
@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
      <div class="row">
</div>
      <div class="table-wrapper">
       


      <div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-12 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Receipt/Invoice Items</h4>
                </div>

                <table class="table-responsive" width="350px" style="margin:10px;width:850px;">
	<tr>
		<td style="background-color:orange;text-align:center;width:250px;">Item Name</td>
		<td style="background-color:orange;text-align:center;width:250px;">Quantity</td>
		<th style="background-color:orange;text-align:center;width:250px;">Add</th>

		</tr>
        <form method="post" action="{{route('dealer.post.debitnote')}}">
            @csrf
            <input type="hidden" value="{{$sale->id}}" name="saleid">
</table>
                
                <TABLE class="table-responsive" id="dataTable" width="350px" style="margin:10px;width:850px;">
                @foreach($sale->items as $item)
		<TR>
        <TD><INPUT type="hidden" name="product[]" value="{{$item->id}}"/>
        <span class="form-control productunit" style="font-size: 25px;">{{$item->name}}</span>
    </TD>
            <TD><INPUT type="number" style="width:250px" readonly value="{{$item->quantity}}" class="form-control productunit"/></TD>
            <TD><INPUT type="number" style="width:250px" value="0"  name="unit[]" class="form-control productunit"/></TD>
		</TR>
        @endforeach
	</TABLE>
            </div>
        </div>
    </div>
<div class="mt-5 text-center"><button type="submit" class="btn btn-warning profile-button" type="button">Save Debit Note</button></div>
</form>
</div>
</div>










      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->
 
@endsection
@section('scripts')
@endsection