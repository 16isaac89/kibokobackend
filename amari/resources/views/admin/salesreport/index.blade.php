@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    
        <b style="color:black;font-size:25px;">Sales Report</b>

    <form class="row g-3" method="post" action="{{route('admin.adminsearch.salesreport')}}">
          @csrf
  <div class="col-4">
    <label for="inputAddress2" class="form-label">From date</label>
    <input type="text" class="form-control date" name="fromdate">
  </div>
  <div class="col-4">
    <label for="inputAddress2" class="form-label">To date</label>
    <input type="text" class="form-control date"  name="todate" >
  </div>


  <div class="col-4">
  <button id="search-button" type="submit" class="btn btn-primary">
    <i class="fa fa-search"></i>
  	</button>
  </div>
</form>
    </div>

    <div class="card-body">

        <div class="table-responsive">
          @foreach($results as $result)
            <table class=" table table-bordered table-striped table-hover datatable datatable-{{$result->id}}">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            VAN/SHOP
                        </th>
                        <th>
                            TOTAL CASH/DAY BOOK
                        </th>
                        <th>
                            Cash Received
                        </th>
                        <th>
                            Profit
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($result->summarydaybook as $item)
                  <tr>
                    <td></td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$result->name}}</td>
                    <td>{{$item->expected}}</td>
                    <td>{{$item->received}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
            @endforeach
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
  let results = @json($results);
  results.forEach(item =>{
    let table = $(`.datatable-${item.id}:not(.ajaxTable)`).DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  })

  
})

</script>
@endsection