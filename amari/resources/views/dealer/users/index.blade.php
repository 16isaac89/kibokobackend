@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
@include('dealer.users.modals.add',['vans'=>$vans])
@include('dealer.users.modals.edit',['vans'=>$vans])
@include('dealer.users.modals.targethistory')
@include('dealer.users.modals.target')
    <div class="card pd-20 pd-sm-40">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#adduser">
        ADD
      </button>
      <div class="table-wrapper">

      <table class="table table-striped" id="users">
  <thead>
    <tr>
    <th  style="text-align: center;">User Name</th>
              <th  style="text-align: center;">Status</th>
              <th  style="text-align: center;">Van</th>
              <th  style="text-align: center;">Phone</th>
              <th  style="text-align: center;">Type</th>
              {{-- <th  style="text-align: center;">Target Type</th> --}}
              <th  style="text-align: center;">Target</th>
              <th  style="text-align: center;">Action</th>
    </tr>
  </thead>
  <tbody>
  @foreach($users as $user)
    <tr>
    <td>{{$user->username}}</td>
              <td>
                @if ($user->status === 1)
                <span class="badge badge-success">Active</span>
                 @else   
                 <span class="badge badge-warning">Inactive</span>
                @endif
              </td>
              <td>{{$user->van->name ?? ''}}</td>
              <td>{{$user->phone}}</td>
              <td>{{$user->type}}</td>
              {{-- <td>{{$user->targettype}}</td> --}}

              <td>
               {{-- @if ($user->targettype === "month")
                @if($user->target) --}}
                <b>{{$user->target->money ?? ''}}</b>
                {{-- @else
                <b>Not Set</b>
                @endif
                @else
                @if($user->skutarget)
                <b>{{$user->skutarget->items->sum('total')}}</b>
                @else
                <b>Not set</b>
                @endif
                @endif  --}}
              </td>
             
              <td>
               
                <a type="button" href="{{route('salertargets.create',['user'=>$user->id])}}"  class="btn btn-primary">
                  Target
</a>
                
                <a class="btn btn-warning m-1" href="{{route('update.user.form',['user'=>$user->id])}}">
                  Edit
                </button>
                <a class="btn btn-success"  href="{{route('update.dealer.userpwd',['userid'=>$user->id])}}" type="button"   class="btn btn-primary">
                 Reset
                </a>

                <a class="btn btn-warning"  href="{{route('user.assign.details',['userid'=>$user->id])}}">
                 Route Details
                </a>
                 <a  type="button" class="btn btn-success" data-toggle="modal" data-target="#targethistory" data-name="{{$user->username}}" data-id="{{$user->id}}" data-whatever="@getbootstrap">
                  <span style="color:white;">Target History</span>
                </a> 
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
    $('.month').datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'en',
    sideBySide: true,
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
   (function() {
    $('#users').DataTable({
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
        },
   
      });
})();
    </script>
    <script>
      $('#edituserdetails').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') 
  var username = button.data('username')
  var van = button.data('van')
  var status = button.data('status')
  var type = button.data('type')
  var phone = button.data('phone')

  document.getElementById('dealerusertype').value = type
  document.getElementById('dealerusername').value = username
  document.getElementById('dealeruserphone').value = phone
  document.getElementById('dealeruserid').value = id
  document.getElementById('dealeruservan').value =  van
  document.getElementById('dealeruserstatus').value = status 
 
})
$('#targetuser').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id')
  document.getElementById('userid').value = id
})
      </script>
      <script>
        $('#targethistory').on('shown.bs.modal', function (event) {
          var button = $(event.relatedTarget) 
          var id = button.data('id') 
          var name = button.data('name') 
          
          document.getElementById('dealeruser').value = id
          document.getElementById('username').innerHTML = name
        })
        </script>

@endsection