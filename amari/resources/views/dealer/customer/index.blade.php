@extends('layouts.dealer')
@section('content')
@include('dealer.customer.modals.add',['categories'=>$categories,'routes'=>$routes])
<div class="am-pagebody">
    <div>
        <h6 class="card-body-title">Customer List</h6>
      </div>
    <div class="card pd-20 pd-sm-40">
        <div class="card-header row">


      <div class="float-right" style="float:right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
        ADD
      </button>
    </div>
    </div>
<div class="card-body">
      <div class="table-wrapper">
        <table id="customers" class="table display responsive nowrap">
          <thead>
            <tr>
              <th class="wd-15p">Name</th>
              <th class="wd-15p">Category</th>
              <th class="wd-20p">Address</th>
              <th class="wd-20p">Phone Number</th>
              <th class="wd-10p">Route</th>
              <th class="wd-10p">Classification</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($customers as $customer)
            <tr>
              <td>{{$customer->name ?? ''}}</td>
              <td>{{$customer->custcategory  ?? ''}}</td>
              <td>{{$customer->address ?? ''}}</td>
              <td>{{$customer->phone ?? ''}}</td>
              <td>{{$customer->route?->name ?? ''}}</td>
              <td>{{$customer->classification ?? ''}}</td>

            </tr>

            @endforeach

          </tbody>
        </table>
      </div><!-- table-wrapper -->
    </div>
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection
@section('scripts')
<script>
   (function() {
    $('#customers').DataTable({
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

@endsection
