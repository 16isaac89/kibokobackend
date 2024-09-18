@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">
      <a type="button" class="btn btn-primary mb-2" href="{{ route('productunits.create') }}">
        ADD
      </a>
      <div class="table-wrapper">

      <table class="table table-striped" id="suppliers">
  <thead>
    <tr>
              <th  style="text-align: center;">Name</th>
              <th  style="text-align: center;">Short Name</th>
              <th  style="text-align: center;">Allow Decimals</th>
              <th  style="text-align: center;">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($units as $unit)
    <tr>
              <td style="text-align: center;width:60px;">{{$unit->name ?? ''}}</td>
              <td style="text-align: center;width:60px;">{{$unit->short_name ?? ''}}</td>
              <td style="text-align: center;width:60px;">{{$unit->allow_decimal === 1 ?'yes': 'no'}}</td>
              <td>
                <a href="{{ route('productunits.edit',$unit->id) }}" class="btn btn-success">
                    Edit
                </a>
                <form action="{{ route('productunits.destroy', $unit->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
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
