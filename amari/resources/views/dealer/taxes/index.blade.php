@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">
      <a type="button" class="btn btn-primary mb-2" href="{{ route('dealertaxes.create') }}">
        ADD
      </a>
      <div class="table-wrapper">

      <table class="table table-striped" id="suppliers">
  <thead>
    <tr>
              <th  style="text-align: center;">Name</th>
              <th  style="text-align: center;">Value</th>
              <th  style="text-align: center;">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($taxes as $tax)
    <tr>
              <td style="text-align: center;width:60px;">{{$tax->name ?? ''}}</td>
              <td style="text-align: center;width:60px;">{{$tax->value ?? ''}}</td>
              <td>
                <a href="{{ route('dealertaxes.edit',$tax->id) }}" class="btn btn-success">
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
