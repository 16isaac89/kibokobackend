@extends('layouts.admin')
@section('content')
@include('admin.suppliers.modals.add')
@can('suppliers_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('dealersuppliers.create') }}">
               ADD
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        <b style="color:black;font-size:25px;">Suppliers' List</b>
</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Tin
                        </th>
                        <th>
                           Address
                        </th>
                        <th>
                           Phone
                        </th>
                        <th>
                           Email
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($suppliers as $supplier)
                   <tr>
                    <td></td>
                    <td>{{$supplier->name}}</td>
                    <td>{{$supplier->tin}}</td>
                    <td>{{$supplier->address}}</td>
                    <td>{{$supplier->phone}}</td>
                    <td>{{$supplier->email}}</td>
                    <td>
                        <a href="{{route('admin.suppliers.editview',['supplier'=>$supplier->id])}}" class="btn btn-primary">Edit</a>
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
<script>
    function getsuppinfo(){
        let tin = document.getElementById('tin').value;
        $.ajax({
                url: '{{ route('admin.suppliers.checktin') }}',
                    type: 'POST',
                    data: {
                    "_token": "{{ csrf_token() }}",
                    tin:tin,
                     },
                    success: function (response) {

                        console.log(response)


                        },

                    error: function (jqXHR, textStatus, errorThrown) {

                    console.log(textStatus, errorThrown,jqXHR);
                    }
                })
    }
    </script>
    <script>
        function checktin(){
            document.getElementById('getbtn').style.display = 'none'
            document.getElementById('loader').style.display = 'block'
            let route = "{{ route('admin.suppliers.checktin') }}";
            let token = "{{ csrf_token()}}";
            let tin =document.getElementById('tin').value

            $.ajax({
                url: route,
                type: 'GET',
                data: {
                    _token:token,
                    tin:tin,

                },
                success: function(response) {
                    document.getElementById('getbtn').style.display = 'block'
            document.getElementById('loader').style.display = 'none'
                    let taxpayer = response.taxpayer
                    document.getElementById('name').value = taxpayer.businessName
                    document.getElementById('phone').value = taxpayer.contactNumber
                    document.getElementById('email').value = taxpayer.contactEmail
                    document.getElementById('address').value = taxpayer.address
                   console.log(taxpayer)
                },
                error: function(xhr) {
                    console.log(xhr)
                    document.getElementById('getbtn').style.display = 'block'
            document.getElementById('loader').style.display = 'none'
                    alert(xhr)
                    //Do Something to handle error
                }});

        }
        </script>
@endsection
