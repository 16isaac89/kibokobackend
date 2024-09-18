@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">
      <a type="button" class="btn btn-primary mb-2" href="{{ route('dealersuppliers.create') }}">
        ADD
      </a>
      <div class="table-wrapper">

      <table class="table table-striped" id="suppliers">
  <thead>
    <tr>
              <th  style="text-align: center;">Title</th>
              <th  style="text-align: center;">Tin</th>
              <th  style="text-align: center;">Address</th>
              <th  style="text-align: center;">Phone</th>
              <th  style="text-align: center;">Email</th>
              <th  style="text-align: center;">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($suppliers as $supplier)
    <tr>
              <td style="text-align: center;width:60px;">{{$supplier->name ?? ''}}</td>
              <td style="text-align: center;width:60px;">{{$supplier->tin ?? ''}}</td>
              <td style="text-align: center;width:60px;">{{$supplier->address ?? ''}}</td>
              <td style="text-align: center;width:60px;">{{$supplier->phone ?? ''}}</td>
              <td style="text-align: center;width:60px;">{{$supplier->email ?? ''}}</td>

              <td>
                <a href="{{ route('dealersuppliers.edit',$supplier->id) }}" class="btn btn-success">
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
