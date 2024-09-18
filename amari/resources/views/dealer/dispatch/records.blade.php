@extends('layouts.dealer')
@section('content')
@include('dealer.dispatch.modals.count')
@include('dealer.dispatch.modals.view')
@include('dealer.dispatch.modals.refill')
<div class="card">
    <div class="card-header">
        <form method="post" action="{{route('partner.van.getdispatches')}}">
            @csrf
			<div class="row" style="margin-top:10px;">
			<select class="custom-select mr-sm-2 col-4" name="van">
			  <option selected>Choose van.</option>
			  @foreach ($vans as $van)
			  <option value="{{$van->id}}">{{$van->name}} {{$van->reg_id}}</option>
			  @endforeach
			</select>
            <input type="text" name="dispatchdate" class="form-control col-4 dispatchdate">

            <button type="submit" class="btn btn-success col-4">Search</button>

        </div>
</form>
    </div>

    <div class="card-body">



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
                            Refill
                        </th>
                        <!-- <th>
                           Stock Count
                        </th> -->
                        <th>
                            View
                        </th>
                        <th>
                            Count
                        </th>
                         <th>
                          ADD
                        </th>
                        <th>
                            CLOSE DAY
                          </th>
                    </tr>
                </thead>
                <tbody>

                 @foreach($records as $record)
                    <tr>
                    <th scope="row">1</th>
                    <td>{{$record->created_at}}</td>
                    <td>
                    <a data-id="{{$record->id}}" onclick="stockrefill(this)" data-toggle="modal" data-target="#stockrefill">
                    <i class="fa fa-plus-square-o fa-2x" aria-hidden="true"></i>
                        </a>
                    </td>
                    <!-- <td>
                        <a href="#">
                        <i class="fa fa-truck fa-2x" aria-hidden="true" data-records="{{$record->dispatchproducts}}" data-id="{{$record->id}}" onclick="countstock(this)" data-toggle="modal" data-target="#stockcount"></i>
                        </a>
                    </td> -->
                    <td>
                    <a href="#">
                    <i class="fa fa-eye fa-2x" data-records="{{$record->dispatchproducts}}" data-id="{{$record->id}}" onclick="viewstock(this)"  aria-hidden="true" data-toggle="modal" data-target="#stockview"></i>
                        </a>
                    </td>
                    <td>

                        {{count($record->dispatchproducts)}}

                    </td>
                    <td>
                     <a href="{{route('dealer.view.topup',['dispatch'=>$record->id])}}">
                    <i class="fa fa-clone fa-2x" aria-hidden="true"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{route('dealer.vans.dispatched',$record->id)}}">
                       <i class="fa fa-calculator fa-2x" aria-hidden="true"></i>
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
   (function() {
    $('#datatable-dispatch').DataTable({
        dom: 'Bfrtip',
    buttons: [
        'colvis',
        'excel',
        'print',
        'copy', 'pdf','csv'
    ],
        responsive: true,
        language: {
          searchPlaceholder: 'Search...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        },

      });
})();
    </script>
    <script>
        function countstock(d){
            let id = d.getAttribute("data-id")
            let records = d.getAttribute("data-records")
            let array = JSON.parse(records);
            document.getElementById('dataTable').innerHTML = ""
            array.forEach((item)=>{
                var tr = '<tr>'+
                '<td style="text-align:center;margin:5px;"><b><span style="font-weight:bold;font-family: Poppins;">'+item.name+'</span></b></td>'+
               '<td><input type="hidden" name="product[]" value="'+item.id +'"placeholder="'+item.name+'" required class="form-control product" ></td>'+
               '<td style="text-align:center;" ><b><span>'+item.stock+'</span></b></td>'+
               '<td style="text-align:center;"><b><span>'+item.sold+'</span></b></td>'+
               '<td style="text-align:center;"><b><span>'+item.dispatchedquantity+'</span></b></td>'+
               '<td ><input style="width:100px;" type="text" name="quantity[]" required class="form-control"></td>'+
          '</tr>';
  $('#dataTable').append(tr);
            })
        }
        </script>
        <script>
            function viewstock(d){
                let records = d.getAttribute("data-records")
            let array = JSON.parse(records);
            $('#tableviewstock').DataTable().clear().draw();
            $('#tableviewstock').DataTable({
                "data": array,
                "stateSave": true,
                 "bDestroy": true,
                "columns": [
                { "data": "name" },
                { "data": "dispatchedquantity"},
                { "data": "sold" },
                { "data": "count" },
                { "data": "price" },
                ]
            });
            }
            </script>
<script>
function stockrefill(d){
            let id = d.getAttribute("data-id")

            $.ajax({
                url: '{{ route('dealer.dispatch.refill') }}',
                    type: 'POST',
                    data: {
                    "_token": "{{ csrf_token() }}",
                    id:id,

                     },
                    success: function (response) {
                        let array = response.products
                        document.getElementById('dispatch_id').value = id
                        document.getE
                        document.getElementById('datarefill').innerHTML = ""
                            array.forEach((item)=>{
                                var tr = '<tr>'+
                                '<td><b><span style="font-weight:bold;font-size: 20px;font-family: Poppins;">'+item.name+'</span></b></td>'+
                            '<td><input type="hidden" name="product[]" value="'+item.id +'"placeholder="'+item.name+'" required class="form-control product" ></td>'+
                            '<td><input type="text" name="quantity[]" required class="form-control"></td>'+

                        '</tr>';
                            $('#datarefill').append(tr);
                            })


                     },
                    error: function (jqXHR, textStatus, errorThrown) {

                    console.log(textStatus, errorThrown,jqXHR);
                    }
                })


        }
</script>
<script>
    $('.dispatchdate').datetimepicker({
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
