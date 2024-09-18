@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">
      <a type="button" class="btn btn-primary mb-2" href="{{ route('dealerbrands.create') }}">
        ADD
      </a>
      <div class="table-wrapper">

      <table class="table table-striped" id="suppliers">
  <thead>
    <tr>
    <th  style="text-align: center;">ID</th>
    <th  style="text-align: center;">Title</th>
    <th  style="text-align: center;">Action</th>
    </tr>
  </thead>
  <tbody>
  @foreach($brands as $brand)
    <tr>
        <td>{{$brand->id?? ''}}</td>
              <td>{{$brand->name?? ''}}</td>
              <td>
                <a href="{{ route('dealerbrands.edit',$brand->id) }}" class="btn btn-success">
                    Edit
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
    $('#suppliers').DataTable({
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
@endsection
