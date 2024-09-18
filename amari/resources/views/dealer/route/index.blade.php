@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
  @include('dealer.route.modals.edit')
@include('dealer.route.modals.add')
    <div class="card pd-20 pd-sm-40">
     <button class="btn btn-primary" data-toggle="modal" data-target="#addroute" >ADD</button>

      <div class="table-wrapper">
        <table id="routes"  class="table display responsive nowrap">
          <thead>
            <tr>
              <th class="wd-15p">ID</th>
              <th class="wd-15p">Name</th>
              <th class="wd-20p">Created</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($routes as $route)
            <tr>
              <td>{{$route->id}}</td>
              <td>{{$route->name}}</td>
              <td>{{$route->created_at}}</td>
              <td>
                <button type="button" data-id="{{$route->id}}" data-name="{{$route->name}}"  class="btn btn-primary" data-toggle="modal" data-target="#editroute">
                  Edit
                </button>
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

@endsection