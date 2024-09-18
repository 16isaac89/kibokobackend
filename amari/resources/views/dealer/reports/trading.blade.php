@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">

    <div class="card pd-20 pd-sm-40">
      <div class="table-wrapper">
        <table id="routes"  class="table display responsive nowrap">
          <thead>
            <tr>
              <th class="wd-15p">sales rep</th>
              <th class="wd-15p">Date</th>
              <th class="wd-20p">sales</th>
            </tr>
          </thead>
          <tbody>
            @foreach($sales as $sale)
            <tr>
              <td>{{$sale->username}}</td>
              <td>{{$sale->created_at}}</td>
              <td>{{$sale->sales->sum('total')}}</td>
            </tr>
        @endforeach
          </tbody>
          <tfoot>
        <tr>
            <th>Total</th>
            <th></th>
            <th ></th>
         </tr>
    </tfoot>
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

       "footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 2;
				while(j < nb_cols){
					var pageTotal = api
                .column( j, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return Number(a) + Number(b);
                }, 0 );
          // Update footer
          $( api.column( j ).footer() ).html(pageTotal);
					j++;
				} 
			}
		
  
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

@endsection