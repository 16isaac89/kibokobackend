@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">
      <a type="button" class="btn btn-primary mb-2" href="{{ route('dealerbranches.create') }}">
        ADD
      </a>
      <div class="table-wrapper">

      <table class="table table-striped" id="branches">
  <thead>
    <tr>
    <th  style="text-align: center;">Name</th>
    <th  style="text-align: center;">Address</th>
    <th  style="text-align: center;">Phone</th>
    <th  style="text-align: center;">Action</th>
    </tr>
  </thead>
  <tbody>
  @foreach($branches as $branch)
    <tr>
              <td>{{$branch->name?? ''}}</td>
              <td>{{$branch->address?? ''}}</td>
              <td>{{$branch->phone?? ''}}</td>
              <td>
                <a href="{{ route('dealerbranches.edit',$branch->id) }}" class="btn btn-success">
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
    $('#branches').DataTable({
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
