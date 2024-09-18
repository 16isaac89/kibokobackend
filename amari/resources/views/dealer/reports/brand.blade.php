@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
  @include('dealer.reports.modals.brandsales')
@include('dealer.route.modals.add')
    <div class="card pd-20 pd-sm-40">
      <div class="card-header">
        <div class="mb-6">
          <input type="hidden" value="{{$month}}" id="routemonth">
          <input type="hidden" value="{{$year}}" id="routeyear">
        <form class="form-inline " method="post" action="{{route('dealer.searchbrandreport')}}">
          @csrf
          <input class="form-control mr-sm-2 month" type="search" placeholder="Month" name="month" aria-label="Search">
          <input class="form-control mr-sm-2 year" type="search" placeholder="Year" name="year" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        </div>
      </div>
      <div class="card-body">
        <h5 class="card-title">Brand Wise Report</h5>
      <div class="table-wrapper">
        <table id="routes"  class="table display responsive nowrap">
          <thead>
            <tr>
              <th class="wd-15p">Brand</th>
               <th class="wd-20p">Actual Sales</th> 
               <th class="wd-20p">Actual Cov</th> 
              <th class="wd-20p">Action</th>
              
            </tr>
          </thead>
          <tbody>
           
            @foreach($sales as $sale)
            @if(count($sale->salesproducts)>0)
            <tr>
              <td>{{$sale->name}}</td>
              <td>{{$sale->salesproducts->sum('total')}}</td>
               <td>{{count($sale->salesproducts->groupBy('sale_id'))}}</td> 
              <td>
                <button class="btn btn-primary" data-toggle="modal" data-target="#brandsales" data-id="{{$sale->id}}" data-name="{{$sale->name}}">
                  View
                </button>
               </td>
            </tr>
            @endif
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
  $('#brandsales').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    var name = button.data('name')
    var month = document.getElementById('routemonth').value
    var year = document.getElementById('routeyear').value
   
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text(name +' '+ month + '/'+year)
    let route = "{{ route('get.brandorders') }}";
      let token = "{{ csrf_token()}}";
      $.ajax({
          url: route,
          type: 'POST',
          data: {
              _token:token,
              brand:id,
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
           
            { data: `name`},
              { data: `quantity`},
              { data: 'sellingprice' },
              { data: 'discount' },
              { data: 'total' },
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