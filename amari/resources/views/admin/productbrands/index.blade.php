@extends('layouts.admin')
@section('content')
@include('admin.productbrands.modals.add')
@include('admin.productbrands.modals.edit')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" data-toggle="modal" data-target="#addbrand">
                {{ trans('global.add') }} Brand
            </a>
        </div>
    </div>
@endcan
<div class="card">
<div class="card-header">
        <b style="color:black;font-size:25px;">Product Brands</b>
        @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
</div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-brands">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.role.fields.id') }}
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Action
                        </th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $brand)
                        <tr data-entry-id="{{ $brand->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $brand->id ?? '' }}
                            </td>
                            <td>
                                {{ $brand->name ?? '' }}
                            </td>
                            <td>
                                @can('brand_edit')
                                    <a data-id="{{$brand->id}}" data-name="{{$brand->name}}" class="btn btn-xs btn-info" data-toggle="modal" data-target="#editbrand">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('brand_delete')
                                    <a href="{{route('admin.brand.delete',['brand'=>$brand->id])}}" class="btn btn-danger">
                                        Delete
                                    </a>
                                @endcan
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


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-brands:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
<script>
$('#editbrand').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id'); 
  var name = button.data('name'); 
  document.getElementById('brandid').value = id;
  document.getElementById('brandname').value = name;
})
</script>
@endsection