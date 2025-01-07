@extends('layouts.dealer')
@section('content')
<div class="card">
    <div class="card-header">
       <b style="color:black;font-size:20px;font-weight:bold;">{{$product->product->name}} Stock</b>
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
	<TABLE id="dataTable" class="table table-responsive" style="width:100%;">
        <thead>
            <tr>
                <td >Current Stock</td>
                <td>Adjust(Remove)</td>
                <td>Remarks</td>
                <td>Reason</td>
                <th>Adjust</th>
                </tr>
        </thead>
        <tbody>

    {{-- @foreach($product->stocks as $stock) --}}
		<TR>
			<TD >
            <INPUT type="number" id="{{ 'amount'.$product->id }}" value="{{$product->stock}}" class="form-control productunit"/>
        </TD>
            <TD >
                <INPUT  type = "number"
                maxlength = "6" id="{{ 'sellingprice'.$product->id }}"
                min="1" max="{{$product->stock}}"
                    name="selling[]" class="form-control productunit" /></TD>

                <TD >
                    <textarea class="form-control" id="{{ 'remarks'.$product->id }}" rows="7"></textarea>
                    </TD>
                    <TD >
                        <select id="{{ 'reason'.$product->id }}" class="form-control" id="exampleFormControlSelect1">
                            <option value="101">Expired Goods</option>
                            <option value="102">Damaged Goods</option>
                            <option value="103">Personal Uses</option>
                            <option value="105">Raw Material(s)</option>
                            <option value="104">Others</option>
                          </select>
                        </TD>
                <TD >
            <button type="button" class="btn btn-success" data-id="{{ $product->id }}" onclick="edititem(this)">EDIT</button>
        </TD>
		</TR>

        {{-- @endforeach --}}
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
let amount = document.getElementById('sellingprice'+id).value
let remarks = document.getElementById('remarks'+id).value
let reason = document.getElementById('reason'+id).value
let product = '{{ $product->id }}'
// console.log(id,amount,product)
// return
$("#activityindicator").modal('show')
let route = "{{ route('dealer.edit.batch') }}";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    _token:token,
                    id,amount,product,remarks,reason

                },
                success: function(response) {
                    console.log(response)
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
