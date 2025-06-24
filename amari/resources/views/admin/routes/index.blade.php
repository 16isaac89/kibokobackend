@extends('layouts.admin')
@section('content')

@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success"  href="{{ route('admin.routes.create') }}">
                {{ trans('global.add') }} Route
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Route', 'route' => 'admin.routes.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
       Dealers List
    </div>

    @if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-routes">
                <thead>
                    <tr>
                        <th width="10">

                        </th>

                        <th>
                           Name
                        </th>
                        <th>
                           Sub Dealer
                        </th>
                        {{-- <th>
                            Code
                         </th> --}}
                        <th>
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($routes as $route)
                        <tr data-entry-id="{{ $route->id }}">
                            <td>

                            </td>

                             <td>
                                {{ $route->name ?? '' }}
                            </td>
                             <td>
                                {{ $route->dealer->tradename ?? '' }}
                            </td>
                            {{-- <td>
                                {{ $route->code ?? '' }}
                            </td> --}}


                            <td>
                                @can('routes_edit')
                                    <a class="btn btn-xs btn-success" href="{{route('admin.routes.edit',$route->id)}}">
                                        Edit
                                    </a>
                                @endcan


                                {{-- <a href="{{route('admin.routes.show',$route->id)}}" class="btn btn-xs btn-secondary">
                                   View
                                </a> --}}
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
  let table = $('.datatable-routes:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>

@endsection
