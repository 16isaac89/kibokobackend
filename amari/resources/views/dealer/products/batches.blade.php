@extends('layouts.dealer')
@section('content')
<div class="card">
    <div class="card-header">
       <b style="color:black;font-size:20px;font-weight:bold;">{{$product->product->name}} Batches</b>
       @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
    </div>

<table  style="width:100%;">

</table>

    <input type="hidden" name="productid" value="{{$product->id}}">
	@csrf
	<TABLE id="dataTable"  style="width:100%;">
        <thead>
            <tr>
                <td style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Stock</span></td>
                <td style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Selling Price</span></td>
                <th style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Sold</span></th>
                <th style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Batch</span></th>
                <th style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Received at</span></th>
                <th style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Expiry</span></th>
                <th style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Cost</span></th>
                <th style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Action</span></th>
                </tr>
        </thead>
        <tbody>

    @foreach($product->stocks as $stock)
		<TR>
			<TD style="width:150px">
            <INPUT type="number" style="width:180px" id="{{ 'amount'.$stock->id }}" value="{{$stock->amount}}" class="form-control productunit"/>
        </TD>
            <TD style="width:150px"><INPUT type="text" id="{{ 'sellingprice'.$stock->id }}" style="width:180px" value="{{$stock->sellingprice}}"  name="selling[]" class="form-control productunit" /></TD>
            <TD style="width:150px"><INPUT type="text" style="width:180px" value="{{$stock->sold}}"  readonly class="form-control productunit"/></TD>
            <TD style="width:150px"><INPUT type="text" id="{{ 'batch'.$stock->id }}"   style="width:180px" value="{{$stock->batch}}" name="price[]" class="form-control productprice"/></TD>
            <TD style="width:150px"><INPUT type="text" id="{{ 'receivedate'.$stock->id }}" style="width:180px" value="{{$stock->receivedate}}"   class="form-control date"/></TD>
            <TD style="width:150px"><INPUT type="text" id="{{ 'expirydate'.$stock->id }}" style="width:180px" value="{{$stock->expirydate}}"   class="form-control date"/></TD>
            <TD style="width:150px"><INPUT type="number" id="{{ 'cost'.$stock->id }}" style="width:180px" value="{{$stock->cost}}"    class="form-control producttotal"/></TD>
            <TD style="width:150px">
            <button type="button" class="btn btn-success" data-id="{{ $stock->id }}" onclick="edititem(this)">EDIT</button>
            {{-- @can('delete_batch')

            @endcan --}}
        </TD>
		</TR>

        @endforeach
    </tbody>
	</TABLE>

</form>


        </div>


        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    function edititem(d){
let id = d.getAttribute("data-id");
let sellingprice = document.getElementById('sellingprice'+id).value
let batch = document.getElementById('batch'+id).value
let receivedate = document.getElementById('receivedate'+id).value
let expirydate = document.getElementById('expirydate'+id).value
let cost = document.getElementById('cost'+id).value
let amount = document.getElementById('amount'+id).value
$("#activityindicator").modal('show')
let route = "{{ route('dealer.edit.batch') }}";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    _token:token,
                    id,sellingprice,batch,receivedate,expirydate,cost,amount

                },
                success: function(response) {
                    let status = response.status
                    if(status === '1' || status === 1){
                        $("#activityindicator").modal('hide')
                        alert('Batch has been edited successfuly')
                        window.location.reload();
                    }else if(status === '0' || status === 0){
                        $("#activityindicator").modal('hide')
                        window.location.reload();
                    }
                },
                error: function(xhr) {
                    $("#activityindicator").modal('hide')
                    console.log(xhr)
                    //Do Something to handle error
                }});

    }
</script>
<script>
    $(document).ready(function () {
    $('.date').datetimepicker({
      format: 'YYYY-MM-DD',
      locale: 'en',
      icons: {
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
      }
    })
})
</script>



@endsection
