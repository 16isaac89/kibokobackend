@extends('layouts.dealer')
@section('content')
{{-- @include('dealer.van.modals.edit') --}}
<div class="am-pagebody">
@include('dealer.van.modals.add')

    <div class="card pd-20 pd-sm-40">
      <button style="margin:20px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#addvan">
        ADD
      </button>

      <div class="table-wrapper">
    
            
        
        <table id="vans" class="table display responsive nowrap">
          <thead>
            <tr>
              <th class="wd-15p">ID</th>
              <th class="wd-15p">Name</th>
              <th class="wd-15p">Registration</th>
              <th class="wd-15p">Add Plan</th>
              <th class="wd-20p">Created</th>
              <th class="wd-20p">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($vans as $van)
            <tr>
              <td>{{$van->id}}</td>
              <td>{{$van->name}}</td>
              <td>{{$van->reg_id}}</td>
              <td><a href="{{route('routeplan.view',['van'=>$van->id])}}" class="btn btn-success">Route Plan</a></td>
              <td>{{$van->created_at}}</td>
              <td>
                <button data-id="{{$van->id}}" data-name="{{$van->name}}" data-reg="{{$van->reg_id}}" style="margin:20px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#editvan">
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


  <div class="modal fade" id="editvan" tabindex="-1" role="dialog" aria-labelledby="editvanModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editvanModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('dealer.van.edit')}}">
              @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Van Name</label>
                  <input type="text" class="form-control" id="vanname" name="vanename">
                  <input type="hidden" class="form-control" id="vanid" name="vanid">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Van Regd</label>
                  <input type="text" class="form-control" id="vanreg" name="vanreg">
                </div>
              </div>
            </div>

                
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        </div>
      </div>
    </div>
  </div>
 
@endsection
@section('scripts')
<script>
   (function() {
    $('#vans').DataTable({
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
      $('#editvan').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var reg = button.data('reg') // Extract info from data-* attributes
  var name = button.data('name') // Extract info from data-* attributes
  document.getElementById('vanname').value = name
  document.getElementById('vanid').value = id
  document.getElementById('vanreg').value = reg
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
})
})();
      </script>

@endsection