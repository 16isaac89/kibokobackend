@extends('layouts.admin')
@section('content')
@include('admin.stockmovements.modals.viewitems')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success">
                Stock Request
            </a>
        </div>
    </div>
@endcan
<div class="card">
     <div class="card-header">
     
        <b style="color:black;font-size:25px;">Stock Requests report</b>

     <form method="post" class="row" action="{{route('admin.stock.searchrequest')}}">
                    @csrf
                    <div class="col-3">
                    <select class="form-control" name="van">
                        <option selected readonly>Select Van</option>
                        @foreach($vans as $van)
                        <option value="{{$van->id}}">{{$van->name}}</option>
                        @endforeach
                        </select>
                        </div>

                    <div class="col-3">
                    <input type="text" name="fromdate" class="form-control date" placeholder="Search" >
                    </div>
                    <div class="col-3">
                    <input type="text" name="todate" class="form-control date" placeholder="Search" >
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-success" id="search-btn">Search</button>
                    </div>
</form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            Van
                        </th>
                        <th>
                            Requested
                        </th>
                        <th>
                           Approved
                        </th>
                        <!-- <th>
                            Date
                        </th>
                        <th>
                            &nbsp;
                        </th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockrequests as $request)
                        <tr data-entry-id="{{ $request->id }}">
                            <td>

                            </td>
                            <td>
                        {{$request->id}}
                            </td>
                            <td>
                            {{$request->van->name}}
                            </td>
                            <td>
                            {{$request->reqqty}}
                            </td>
                            <td>
                            {{$request->appqty}}
                            </td>
                            <!-- <td>
                                @if($request->status === 1)
                                <span class="badge badge-warning">Pending</span>
                                @elseif($request->status === 2)
                                <span class="badge badge-success">Approved</span>
                                @elseif($request->status === 3)
                                <span class="badge badge-danger">Denied</span>
                                @endif
                                </td>
                            <td>
                            {{$request->created_at}}
                            </td>
                            <td>
                            <a class="btn btn-primary" onclick="viewitems(this)" data-records="{{$request->items}}" data-toggle="modal" data-target="#requestsproducts">View</a>
                            </td> -->
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
<script>
    $(document).ready(function () {
    $('#requestitems').DataTable();
});

</script>
   <script>
            function viewitems(d){
                let records = d.getAttribute("data-records")
            let array = JSON.parse(records);
            var container = document.getElementById("tBody");

    array.forEach(function(item) {
      const tr = container.insertRow();
      tr.innerHTML = `<td></td><td>${item.product.name}</td><td>${item.reqqty}</td><td>${item.appqty}</td>`;
    })
           
            }
    </script>
@endsection