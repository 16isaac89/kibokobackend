@extends('layouts.admin')
@section('content')
<div class="card">
<div class="card-header">
        <b style="color:black;font-size:25px;">Day Book</b>
</div>
    <div class="card-header">
    <form class="row g-3" method="post" action="{{route('admin.search.daybook')}}">
          @csrf
  <div class="col-3">
    <label for="inputState" class="form-label">Van</label>
    <select  class="form-control" name="vanid" id="vanid">
      <option selected>Choose van</option>
      @foreach ($vans as $van)
			  <option value="{{$van->id}}">{{$van->name}} {{$van->reg_id}}</option>
			  @endforeach
    </select>
  </div>
  <div class="col-3">
    <label for="inputAddress2" class="form-label">From date</label>
    <input type="text" class="form-control date"  name="fromdate" >
  </div>
  <div class="col-3">
    <label for="inputAddress2" class="form-label">To date</label>
    <input type="text" class="form-control date"  name="todate" >
  </div>


  <div class="col-3">
  <label for="inputAddress2" class="form-label"></label>
  <button id="search-button" type="submit" class="btn btn-primary">
    <i class="fa fa-search"></i>
  	</button>
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
                            Item
                        </th>
                        <th>
                            Quantity
                        </th>
                       
                        <th>
                            SP/VAT
                        </th>
                        <th>
                            CP/VAT
                        </th>
                        <th>
                            Supp/VAT(18%)
                        </th>
                        <th>
                            Total Cost
                        </th>
                        <th>
                           Total Sales/VAT
                        </th>
                        <!-- <th>
                           HOS/VAT
                        </th> -->
                        <th>
                            URA VAT
                        </th>
                        <!-- <th>
                            Profit
                        </th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                    <td></td>
                    <td>{{$result->name ?? ''}}</td>
                    <td>{{$result->quantity ?? ''}}</td>
                    <td>
                      <!-- {{$result->product->price ?? ''}} -->
                      @if(isset($result->product->stocks))
                      @foreach($result->product->stocks as $stock)
                      <b>{{$stock->batch ?? ''}} (Price:{{$stock->sellingprice ?? ''}})</b>
                      @endforeach
                      @endif
                    </td>
                    <td>
                      <!-- {{$result->product->price ?? ''}} -->
                      @if(isset($result->product->stocks))
                      @foreach($result->product->stocks as $stock)
                      <b>{{$stock->batch ?? ''}} (Cost:{{$stock->sellingprice ?? ''}})</b>
                      @endforeach
                      @endif
                    </td>
                    <!-- <td>{{$result->product->cost ?? ''}}</td> -->
                    <td>{{$result->product->suppvat ?? ''}}</td>
                    <td>{{$result->product->cost ?? ''}}</td>
                    <td>{{$result->total}}</td>
                    <td>{{$result->total*0.18}}</td>
                    {{-- <td>{{$result->hosanavat-$result->product->suppvat}}</td> --}}
                    {{--<td>{{($result->total-$result->hosanavat)-(($result->product->cost*$result->quantity)-$result->product->suppvat)}}</td> --}}
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
@can('role_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.roles.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

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
@endsection