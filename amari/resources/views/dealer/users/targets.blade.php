@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#adduser">
        ADD
      </button>
      <div class="table-wrapper">

      <table class="table table-striped" id="users">
  <thead>
    <tr>
    <th  style="text-align: center;">User Name</th>
              <th  style="text-align: center;">From Date</th>
              <th  style="text-align: center;">To Date</th>
              <th  style="text-align: center;">Amount</th>
    </tr>
  </thead>
  <tbody>
  
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
    $('#month').datetimepicker({
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

@endsection