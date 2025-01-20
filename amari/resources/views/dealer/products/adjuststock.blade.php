@extends('layouts.dealer')
@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $product->product->name }} Stock</h5>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <input type="hidden" name="productid" value="{{ $product->id }}">
        @csrf

        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Current Stock</th>
                        <th>Adjust (Remove)</th>
                        <th>Remarks</th>
                        <th>Reason</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($product->stocks as $stock) --}}
                    <tr>
                        <td>
                            <input type="number" id="{{ 'amount'.$product->id }}" value="{{ $product->stock }}" class="form-control productunit" readonly>
                        </td>
                        <td>
                            <input type="number"
                                   id="{{ 'sellingprice'.$product->id }}"
                                   name="selling[]"
                                   class="form-control productunit"
                                   min="1"
                                   max="{{ $product->stock }}"
                                   placeholder="Enter quantity">
                        </td>
                        <td>
                            <textarea class="form-control"
                                      id="{{ 'remarks'.$product->id }}"
                                      rows="3"
                                      placeholder="Enter remarks"></textarea>
                        </td>
                        <td>
                            <select id="{{ 'reason'.$product->id }}" required class="form-control">
                                <option value="">Select Reason .....</option>
                                <option value="101">Expired Goods</option>
                                <option value="102">Damaged Goods</option>
                                <option value="103">Personal Use</option>
                                <option value="105">Raw Material(s)</option>
                                <option value="104">Others</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success" data-id="{{ $product->id }}" onclick="edititem(this)">
                                Edit
                            </button>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
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
if(amount === '' || remarks === '' || reason === ''){
    alert('All fields are required')
    return
}else{
$("#activityindicator").modal('show')
let route = "{{ route('dealer.adjust.batch') }}";
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
