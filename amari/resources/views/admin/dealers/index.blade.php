@extends('layouts.admin')
@section('content')
@include('admin.dealers.modals.add')
@include('admin.dealers.modals.edit')
@include('admin.dealers.modals.user')
@include('admin.dealers.modals.target')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" data-toggle="modal" data-target="#adddealer">
                {{ trans('global.add') }} Dealer
            </a>
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
            <table class=" table table-bordered table-striped table-hover datatable datatable-dealers">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.role.fields.id') }}
                        </th>
                        <th>
                            Trade Name
                        </th>
                        <th>
                           TIN
                        </th>
                        <th>
                            Address
                        </th>
                        <th>
                           Phone
                        </th>
                        <th>
                            Status
                        </th>

                        <th>
                            Efris Enabled
                        </th>
                        <th>
                            Sub Type
                        </th>
                        <th>
                            Start Date
                        </th>
                        <th>
                            End Date
                        </th>
                        <th>
                            B'ss Type
                        </th>
                        <th>
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($dealers as $dealer)
                        <tr data-entry-id="{{ $dealer->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $dealer->id ?? '' }}
                            </td>
                            <td>
                                {{ $dealer->tradename ?? '' }}
                            </td>
                             <td>
                                {{ $dealer->tin ?? '' }}
                            </td>
                             <td>
                                {{ $dealer->address ?? '' }}
                            </td>
                             <td>
                                {{ $dealer->phonenumber ?? '' }}
                            </td>
                             <td>
                                @if($dealer->status === 1)
                                <span class="badge badge-primary">Active</span>
                                @else
                                <span class="badge badge-warning">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if($dealer->dealerefris === 1)
                                <span class="badge badge-primary">Active</span>
                                @else
                                <span class="badge badge-warning">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $dealer->sub_type === 1 ?'Monthly':'Yearly' }}</td>
                            <td> {{ $dealer->end_date ?? '' }}</td>

                            <td>
                                {{ $dealer->start_date ?? '' }}
                           </td>
                           <td>
                            @if($dealer->type_of_business == 1)
                            <span class="badge badge-success">Shop</span>
                            @else
                            <span class="badge badge-warning">Distributor</span>
                            @endif
                        </td>
                            <td>
                                @can('dealer_edit')
                                    <a data-id="{{$dealer->id}}" data-start="{{$dealer->start_date}}"
                                        data-end="{{$dealer->end_date}}"
                                        data-email="{{$dealer->email}}"
                                        data-sub_type = "{{$dealer->sub_type}}"
                                        data-efris="{{$dealer->efris}}" data-tradename="{{$dealer->tradename}}" data-tin="{{$dealer->tin}}" data-address="{{$dealer->address}}" data-phone="{{$dealer->phonenumber}}" data-status="{{$dealer->status}}" class="btn btn-xs btn-info" data-toggle="modal" data-target="#editdealer">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('dealer_edit')
                                    <a data-id="{{$dealer->id}}"  class="btn btn-xs btn-success" data-toggle="modal" data-target="#dealeruser">
                                        Add user
                                    </a>
                                @endcan
                                {{-- @can('dealer_edit')
                                    <a data-id="{{$dealer->id}}" class="btn btn-xs btn-secondary" data-toggle="modal" data-target="#dealertarget">
                                        Add Target
                                    </a>
                                @endcan --}}
                                <a href="{{route('admin.dealers.show',$dealer->id)}}" class="btn btn-xs btn-secondary">
                                   View
                                </a>
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
  let table = $('.datatable-products:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
<script>
$('#editdealer').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal

  var id = button.data('id');
  var name = button.data('tradename');
  var tin = button.data('tin');
  var address = button.data('address');
  var phone = button.data('phone');
  var status = button.data('status');
  var efris = button.data('efris');
  var email = button.data('email');
  var sub_type = button.data('sub_type');
  var startdate = button.data('startdate');
  var enddate = button.data('enddate');

  document.getElementById('dealerid').value = id;
  document.getElementById('dealername').value = name;
  document.getElementById('dealertin').value = tin;
  document.getElementById('dealeraddress').value = address;
  document.getElementById('dealerphone').value = phone;
  document.getElementById('dealerstatus').value = status;
  document.getElementById('dealerefris').value = efris;
  document.getElementById('email').value = email;
  document.getElementById('sub_type').value = sub_type;
  document.getElementById('startdate').value = startdate;
  document.getElementById('enddate').value = enddate;
})
</script>

<script>
$('#dealeruser').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id');
  document.getElementById('iddealer').value = id;
})
</script>
<script>
$('#dealertarget').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id');
  document.getElementById('targetdealer').value = id;
})
</script>
@endsection
