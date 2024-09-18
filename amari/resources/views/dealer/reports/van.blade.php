@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
  @include('dealer.reports.modals.vansales')
@include('dealer.route.modals.add')
    <div class="card pd-20 pd-sm-40">
      <div class="card-header">
        <div class="mb-6">
          <input type="hidden" value="{{$month}}" id="routemonth">
          <input type="hidden" value="{{$year}}" id="routeyear">
        <form class="form-inline " method="get" action="{{route('dealer.searchvanreport')}}">
          {{-- @csrf --}}
          <input class="form-control mr-sm-2 month" type="search" placeholder="Month" name="month" aria-label="Search">
          <input class="form-control mr-sm-2 year" type="search" placeholder="Year" name="year" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        </div>
      </div>
      <div class="card-body">
        <h5 class="card-title">Van Wise Report</h5>
      <div class="table-wrapper">
        <table id="routes"  class="table display responsive nowrap">
          <thead>
            <tr>
              <th class="wd-15p">Van</th>
              <th class="wd-20p">Planned Sales</th>
              <th class="wd-20p">Actual Sales</th>
              <th class="wd-20p">Planned Coverage</th>
              <th class="wd-20p">Actual Cov</th>
              <th class="wd-20p">Action</th>
              
            </tr>
          </thead>
          <tbody>
           
            @foreach($sales as $sale)
            @if(count($sale->sales)>0)
            <tr>
              <td>{{$sale->name}}</td>
             <td>{{$sale->target->sum('money')}}</td>
              <td>{{$sale->sales->sum('total')}}</td>
              <td>{{count($sale->routeplan)}}</td>
              <td>{{count($sale->sales)}}</td>
              <td>
                <button class="btn btn-primary" data-toggle="modal" data-target="#vansales" data-id="{{$sale->id}}" data-name="{{$sale->name}}">
                  View
                </button>
               </td>
            </tr>
            @endif
        @endforeach
       
          </tbody>
          <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
             </tr>
        </tfoot>
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
   $('#routes').DataTable({
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
       footerCallback: function( tfoot, data, start, end, display ) {
        var api = this.api();
        $(tfoot).find('th').eq(0).html( "Total" );
        $(api.column(1).footer()).html(
            api.column(1).data().reduce(function ( a, b ) {
                return parseFloat(a) + parseFloat(b);
            }, 0)
        );
        $(api.column(2).footer()).html(
            api.column(2).data().reduce(function ( a, b ) {
                return parseFloat(a) + parseFloat(b);
            }, 0)
        );
        $(api.column(3).footer()).html(
            api.column(3).data().reduce(function ( a, b ) {
                return parseFloat(a) + parseFloat(b);
            }, 0)
        );
        $(api.column(4).footer()).html(
            api.column(4).data().reduce(function ( a, b ) {
                return parseFloat(a) + parseFloat(b);
            }, 0)
        );
    },
  
     });
})();
   </script>
     <script>
      (function() {
      $('#editroute').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var name = button.data('name') // Extract info from data-* attributes
  document.getElementById('routename').value = name
  document.getElementById('routeid').value = id
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
})
})();
      </script>
<script>
  $('.month').datetimepicker({
format: 'MM',
locale: 'en',
icons: {
up: 'fas fa-chevron-up',
down: 'fas fa-chevron-down',
previous: 'fas fa-chevron-left',
next: 'fas fa-chevron-right'
}
})

$('.year').datetimepicker({
format: 'YYYY',
locale: 'en',
icons: {
up: 'fas fa-chevron-up',
down: 'fas fa-chevron-down',
previous: 'fas fa-chevron-left',
next: 'fas fa-chevron-right'
}
})
</script>
<script>
  $('#vansales').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    var name = button.data('name')
    var month = document.getElementById('routemonth').value
    var year = document.getElementById('routeyear').value
   
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text(name +' '+ month + '/'+year)
    let route = "{{ route('get.vanorders') }}";
      let token = "{{ csrf_token()}}";
      $.ajax({
          url: route,
          type: 'POST',
          data: {
              _token:token,
              van:id,
              month:month,
              year:year,
          },
          success: function(response) {
            let sales = response.sales
            let table = $('#tableviewstock').DataTable({
              dom: 'Bfrtip',
buttons: [
 
 'excel',
  'pdf','csv'
],
          destroy: true,
          data: sales,
          columns: [
           
            { data: `items`},
              { data: `created_at`},
              { data: 'user.username' },
              { data: 'customer.name' },
              { data: 'route.name' },
              { data: 'total' },
              { data: 'total' }
          ],
          columnDefs:[{targets:1, render:function(data){
return moment(data).format('lll');
}},
{targets:0, render:function(data){
return '';
}},
{
className: 'dt-control',
orderable: false,
targets: 0
}
],
          "pageLength": 10,
      });
let x = "i"
      $('#tableviewstock tbody').on('click', 'td.dt-control',{'param': table},function(event){
let c = event.data.param;
var tr = $(this).closest('tr');
  var row = c.row(tr);

  if (row.child.isShown()) {
      // This row is already open - close it
      row.child.hide();
      tr.removeClass('shown');
  } else {
      // Open this row
      row.child(format(row.data())).show();
      tr.addClass('shown');
  }
});
          },
          error: function(error) {
            console.log(error)
              //Do Something to handle error
          }});
    //modal.find('.modal-body input').val(recipient)
  })
</script>
<script>
function format(d) {
let data = d.items 
let result = ""
let custroute = ''
var div = document.createElement('div')
var div2 = document.createElement('div')
data.forEach((item)=>{
var p2 = document.createElement("p");
p2.style.cssText = 'text-align:left;color:black;';
p2.innerHTML = 'Product: '+item.name+' '+'Quantity: '+item.quantity+' '+'Price: '+item.sellingprice+' '+'Total: '+item.total;
div2.appendChild(p2)
div.appendChild(div2)
})
return div
}
</script>

@endsection