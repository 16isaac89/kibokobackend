@extends('layouts.admin')
@section('content')
@can('permission_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" >
            Sales Report
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
       
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <table id="sales"  class="table display responsive nowrap sales">
          <thead>
            <tr>
                <th></th>
              <th class="wd-15p">ID</th>
              <th class="wd-15p">Date</th>
              <th class="wd-15p">Sales Rep</th>
              <th class="wd-20p">Customer</th>
              <th class="wd-20p">Route</th>
              <th class="wd-20p">Amount</th>
              <th class="wd-20p">Punch in</th>
              <th class="wd-20p">Punch out</th>
              <th class="wd-20p">Customer No</th>
              <th class="wd-20p">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($sales as $sale)
            <tr>  
                <td></td>
            <td>{{$sale->id}}</td>
              <td>{{$sale->created_at}}</td>
              <td>{{$sale->user->username ?? ''}}</td>
              <td>{{$sale->customer->name ?? ''}}</td>
              <td>{{$sale->route->name ?? ''}}</td>
              <td>{{$sale->total ?? ''}}</td>

              <td>{{$sale->user->username ?? ''}}</td>
              <td>{{$sale->customer->name ?? ''}}</td>
              <td>{{$sale->route->name ?? ''}}</td>
              <td>action</td>
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
 $(document).ready(function () {
    $('#sales').DataTable({
        pagingType: 'full_numbers',
    });
});
      </script>
@endsection