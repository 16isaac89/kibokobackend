@extends('layouts.admin')
@section('styles')
<style>
nav {
  margin:0 auto;
  width:100%;
  height:auto;
  display:inline-block;
  background:#37bc9b;
}

nav ul {
  margin:0;padding:0;
  list-style-type:none;
  float:left;
  display:inline-block;
}

nav ul li {
  position:relative;
  margin:0 20px 0 0;
  float:left;
  display:inline-block;
}

li > a:after { content: ' »'; } /* Change this in order to change the Dropdown symbol */

li > a:only-child:after { content: ''; }

nav ul li a {
  padding:20px;
  display:inline-block;
  color:white;
  text-decoration:none;
}

nav ul li a:hover {
  opacity:0.5;
}

nav ul li ul {
  display:none;
  position:absolute;
  left:0;
  background:#37bc9b;
  float:left;
}

nav ul li ul li {
  width:100%;
  border-bottom:1px solid rgba(255,255,255,.3);
}

nav ul li:hover ul {
  display:block;
}
    </style>
@endsection
@section('content')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
        @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
            <a class="btn btn-success" href="{{ route('admin.purchases.create') }}">
                {{ trans('global.add') }} Purchase
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
    
        <b style="color:black;font-size:25px;">Purchase orders</b>

    <form method="post" action = "{{route('admin.purchase.search')}}">
            @csrf
    <div class="row">
   
     <div class="col-3">
        <label class=" col-form-label">Select Supplier:</label>
        <select required class="form-control" id="exampleFormControlSelect1" name="supplier">
            @foreach($suppliers as $supplier)
      <option value="{{$supplier->id}}">{{$supplier->name}}</option>
        @endforeach
    </select>
            </div>
           
            <div class="col-2">
            <label class=" col-form-label">From Date:</label>
                    <input required type="text" name="fromdate" class="form-control date" placeholder="Purchase Date" >
            </div>
            <div class="col-2">
            <label class=" col-form-label">To Date:</label>
                    <input required type="text" name="todate" class="form-control date" placeholder="Purchase Date" >
            </div>
            <div class="col-2">
            <label class=" col-form-label">Purchase Status:</label>
            <select class="form-control" required id="exampleFormControlSelect1" name="status">
                <option value="ordered">Ordered</option>
                <option value="pending">Pending</option>
                <option value="received">Received</option>
                </select>
            </div>
            <div class="col-2">
            <label class=" col-form-label"></label>
            <button type="submit" class="btn btn-primary">SEARCH</button>
            </div>

</div>   
</form>    
    </div> 
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Ref
                        </th>
                        <th>
                            Supplier
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Total
                        </th>
                        <th>
                            Item Count
                        </th>
                        <th>
                            Added by
                        </th>
                        <th>
                           Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                        <tr data-entry-id="{{ $purchase->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $purchase->date ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->reference ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->supplier->name ?? '' }}
                            </td>
                           <td>
                           {{ $purchase->status ?? '' }}
                          </td>
                          <td>
                           {{ $purchase->total ?? '' }}
                          </td>
                          <td>
                           {{ $purchase->item_count ?? '' }}
                          </td>
                          <td>
                           {{ $purchase->user->username ?? '' }}
                          </td>
                          <td>
  <a class="btn btn-success" href="{{route('admin.purchase.edit',['id'=>$purchase->id])}}">Edit</a>
	<a class="btn btn-success" href="{{route('admin.purchase.receiveview',['id'=>$purchase->id])}}">Rec</a>
  @if($purchase->status === 'received')
  <a class="btn btn-success" href="{{route('admin.purchase.returnview',['id'=>$purchase->id])}}">Ret</a>
  @endif

                          </td>
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