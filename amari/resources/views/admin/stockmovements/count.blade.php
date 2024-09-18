@extends('layouts.admin')
@section('content')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <!-- <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.roles.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }}
            </a>
        </div> -->
    </div>
@endcan
<div class="card">
    <div class="card-header">
   
        <form method="post" class="row" action="{{route('admin.stock.searchcount')}}">
                    @csrf
                    <div class="col-6">
                    <input type="text" name="date" class="form-control date" placeholder="Search" >

</div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-success" id="search-btn">Search</button>
                    </div>
</form>
                
    </div>

    <div class="card-body">
    <div class="card-header">
        <b style="color:black;font-size:25px;">Stock Count</b>
</div>
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
                           Location
                        </th>
                        <th>
                           Damages
                        </th>
                        <th>
                           Expired
                        </th>
                        <th>
                            Van
                        </th>
                        <th>
                            Stock
                        </th>
                       
                    </tr>
                </thead>
                <tbody>
                 @foreach($products as $product)
                    <tr>
                    <td></td>
                        <td>{{$product->name}}</td>
                        <td>
                            @foreach($product->locationproducts as $lp)
                            <ul>
                                <li>
                                    {{$lp->location->name}} ({{$lp->quantity}})
                                </li>
                            </ul>
                            @endforeach
                        </td>

                        <td>
                            @foreach($product->damagesexp as $lp)
                            <ul>
                                <li>
                                    {{$lp->where('type','damage')->sum('count')}}
                                </li>
                            </ul>
                            @endforeach
                        </td>
                        <td>
                            @foreach($product->damagesexp as $lp)
                            <ul>
                                <li>
                                {{$lp->where('type','expired')->sum('count')}}
                                </li>
                            </ul>
                            @endforeach
                        </td>
                        <td>
                              @foreach($product->dispatchproducts as $lp)
                            <ul>
                                <li>
                                {{$lp->van->name ?? ''}} ({{$lp->dispatchedquantity}})
                                </li>
                            </ul>
                            @endforeach 
                        </td>
                        <td>{{$product->stock}}</td>
                        
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