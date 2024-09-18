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

    <div class="card pd-10 pd-sm-40">
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
@if (\Session::has('error'))
    <div class="alert alert-warning">
        <ul>
            <li>{!! \Session::get('error') !!}</li>
        </ul>
    </div>
@endif
      <div class="row">
</div>
      <div class="table-wrapper">



      <div class="container rounded bg-white  mb-2">
    <div class="row">
        <div class="col-md-12 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Receipt/Invoice Items</h4>
                </div>

                <table class="table table-responsive" >
	<tr>
		<td style="background-color:orange;text-align:center;width:250px;">Item Name</td>
		<td style="background-color:orange;text-align:center;width:250px;">Quantity</td>
		<th style="background-color:orange;text-align:center;width:250px;">Deduct</th>

		</tr>
        <form method="post" action="{{route('dealer.sales.notesform')}}">
            @csrf
            <input type="hidden" value="{{$sale->id}}" name="saleid">
</table>

                <TABLE class="table table-responsive" id="dataTable">
                @foreach($sale->items as $item)
		<TR>
        <TD><INPUT type="hidden" name="product[]" value="{{$item->id}}"/>
        <span class="form-control productunit" style="font-size: 25px;">{{$item->name}}</span>
    </TD>
            <TD><INPUT type="number" style="width:250px" readonly value="{{$item->quantity}}" class="form-control productunit"/></TD>
            <TD><INPUT type="number" style="width:250px" value="0" max="{{$item->quantity}}" name="unit[]" class="form-control productunit"/></TD>
		</TR>
        @endforeach
	</TABLE>
            </div>
        </div>




    </div>

    <div class="row m-2">

                <div class="col-6">
                    <label class="labels" style="font-size: 15px;font-weight:900;color:black;">Reason</label>
                    <select required class="form-control" name="reasoncode">
                    <option selected>Select reason for credit note.</option>
                    <option value="101">Return of products due to expiry or damage</option>
                    <option value="102">Cancellation of the purchase.</option>
                    <option value="103">Invoice amount wrongly stated due to miscalculation of price, tax, or discounts.</option>
                    <option value="104">
                    Partial or complete waive
off of the product sale after
the invoice is generated and
sent to customer.
                    </option>
                    <option value="105">Others</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="labels" style="font-size: 15px;font-weight:900;color:black;">Additional Details</label>
                    <textarea class="form-control" name="reasontext" id="exampleFormControlTextarea3" rows="7"></textarea>
                </div>

        </div>
</div>
<div class="mt-5 text-center"><button type="submit" class="btn btn-warning profile-button" type="button">Save Credit Note</button></div>
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
