@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">
      <a type="button" class="btn btn-primary mb-2" href="{{ route('dealercategories.create') }}">
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
  @foreach($categories as $category)
    <tr>
        <td>{{$category->id?? ''}}</td>
              <td>{{$category->name?? ''}}</td>
              <td>
                <a href="{{ route('dealercategories.edit',$category->id) }}" class="btn btn-success">
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
