@extends('layouts.dealer')
@section('styles')
<style>
td.details-control {
    background: url('/images/logo/plus.png') no-repeat center center;
    cursor: pointer;
}
tr.details td.details-control {
    background: url('/images/logo/minus.png') no-repeat center center;
}
</style>
@endsection
@section('content')
<div class="am-pagebody">
  @include('dealer.sales.modals.document')


<div class="card pd-20 pd-sm-40">
    <form method="post" action="{{route('dealer.search.sales')}}">
        @csrf
    <div class="row">

    <div class="col-2 wd-100">
                <select class="form-control select2" data-placeholder="Choose sale status" name="search">
                  <option label="Choose one"></option>
                  <option value="2">All</option>
                  <option value="1">Receipt</option>
                  <option value="0">Invoice</option>
                </select>
              </div><!-- col-4 -->
    <div class="col-2 wd-100">
            <div class="input-group">
              <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
              <input type="text" class="form-control fc-datepicker" name="date1" placeholder="MM/DD/YYYY">
            </div>
          </div><!-- wd-200 -->
          <div class="col-2 wd-100">
            <div class="input-group">
              <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
              <input type="text" class="form-control fc-datepicker" name="date2" placeholder="MM/DD/YYYY">
            </div>
          </div><!-- wd-200 -->

          <div class="col-2 wd-100">
            <div class="input-group">
            <button type="submit" class="btn btn-primary btn-icon mg-r-5 mg-b-10"><div><i class="fa fa-send"></i></div></button>
            </div>
          </div><!-- wd-200 -->
</div>
</div>
</form>


    <div class="card pd-20 pd-sm-40">
      <div class="row">
<!-- <button id="btn-show-all-children col-4" style="width:100px;border-radius:25px;margin:10px;" type="button">Expand All</button>
<button id="btn-hide-all-children col-4" style="width:100px;border-radius:25px;margin:10px;" type="button">Collapse All</button> -->
</div>
      <div class="table-wrapper">
        <table id="sales"  class="table display responsive nowrap">
          <thead>
            <tr>
            <th class="wd-15p"></th>
              <th class="wd-15p">ID</th>
              <th class="wd-15p">Date</th>
              <th class="wd-15p">Sales Rep</th>
              <th class="wd-20p">Customer</th>
              <th class="wd-20p">Route</th>
              <th class="wd-20p">Amount</th>
              <th class="wd-20p">Type</th>
              <th class="wd-20p">Debit/Credit Note</th>
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
              <td>
                @if($sale->type == 1)
                <span class="badge badge-success">Receipt</span>
                @else
                <span class="badge badge-warning">Invoice</span>
                @endif
              </td>
             <td>
@if(Auth::guard('dealer')->user()->dealer->efris === 1)
<a class="btn btn-success" href="{{route('dealer.sales.creditview',['sale'=>$sale->id])}}">
  Credit Note
</a>
@endif
<a class="btn btn-secondary" href="{{route('dealer.sales.receiptview',$sale->id)}}">
  Print
</a>
{{-- <a class="btn btn-primary" href="{{route('dealer.sales.debitview',['sale'=>$sale->id])}}">
  Debit Note
</a> --}}
<!-- <a class="btn btn-success" href="{{route('dealer.note.status')}}">
Status
</a> -->

</td>
            </tr>
        @endforeach
          </tbody>
        </table>
      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection
@section('scripts')
<script>
  (function() {
    var table = $('#sales').DataTable({
      dom: 'Bfrtip',
    buttons: [
        'colvis',
        'excel',
        'print',
        'copy', 'pdf','csv'
    ],
    });

})();
      </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        (function() {
            'use strict';

$('#customers').DataTable({
  responsive: true,
  language: {
    searchPlaceholder: 'Search...',
    sSearch: '',
    lengthMenu: '_MENU_ items/page',
  }
});

$('.fc-datepicker').datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'en',
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })



        })();
    </script>


<script>
      $('#documents').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id')
  document.getElementById('sale').value = id


})

      </script>

@endsection
