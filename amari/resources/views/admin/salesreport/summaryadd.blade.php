@extends('layouts.admin')
@section('content')

<div class="card">
@if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
    <div class="card-body">
        <div class="table-responsive">
        <form class="row g-3" method="post" action="{{route('admin.post.summary')}}">
          @csrf
  <div class="col-md-6">
  <label for="inputState" class="form-label">Van</label>
    <select  class="form-control" name="vanid" id="vanid" required>
      <option value="">Choose van</option>
      @foreach ($vans as $van)
			  <option value="{{$van->id}}">{{$van->name}} {{$van->reg_id}}</option>
			  @endforeach
    </select>
  </div>
  <div class="col-6">
    <label for="inputAddress" class="form-label">Date</label>
    <input type="text" readonly class="form-control" required id="summarydate" name="summarydate" >
  </div>
  <div class="col-4">
    <label for="inputAddress" class="form-label">Expected</label>
    <input type="text" readonly class="form-control" id="expected" required name="expected" >
  </div>
  <div class="col-4">
    <label for="inputAddress2" class="form-label">Received</label>
    <input type="text" class="form-control" required id="received" name="received">
  </div>
  <div class="col-4">
    <label for="inputAddress2" class="form-label">Difference</label>
    <input type="text" class="form-control" required id="difference" name="difference" >
  </div>

  <input type="hidden" id="dispatchid" name="dispatchid">
  <div class="col-md-12">
  <div class="form-group">
  <label for="exampleFormControlTextarea3">Comment</label>
  <textarea class="form-control" id="comment" required rows="7" name="comment"></textarea>
</div>
</div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>


        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('role_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.roles.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
<script>
  document.getElementById('vanid').addEventListener('change', function() {
  let van = this.value
  //alert(this.value)
  $.ajax({
                url: '{{ route('admin.get.vandispatch') }}',
                    type: 'POST',
                    data: {
                    "_token": "{{ csrf_token() }}",
                    van:van,
                     },
                    success: function (response) {
                       let dispatch = response.dispatch
                       if(dispatch){
                       document.getElementById('expected').value = dispatch.total
                       document.getElementById('dispatchid').value = dispatch.id 
                       document.getElementById('summarydate').value = dispatch.created_at
                       }else{
                        alert('No dispatch exists for this van today.')
                       }
                     },
                    error: function (jqXHR, textStatus, errorThrown) {

                    console.log(textStatus, errorThrown,jqXHR);
                    }
                })
});

$("#received").on("change keyup paste click", function(){
  let expected = document.getElementById('expected').value 
  let received = document.getElementById('received').value 
  document.getElementById('difference').value = expected-received

})
  </script>

<script>
    $("#expected").on('keydown paste focus mousedown', function(e){
        if(e.keyCode != 9) // ignore tab
            e.preventDefault();
    });
</script>
<script>
    $("#summarydate").on('keydown paste focus mousedown', function(e){
        if(e.keyCode != 9) // ignore tab
            e.preventDefault();
    });
</script>
@endsection