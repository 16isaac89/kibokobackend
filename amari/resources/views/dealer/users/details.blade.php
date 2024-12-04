@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">
        <div class="table-wrapper">
            <b>Routes</b>
          <table class="table">
      <thead>
        <tr>
          <th scope="col">Route</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach($routes as $route)
        <tr>
          <th scope="row">{{$route->name}}</th>
          <td>
          <a href='{{route("user.delete.assignroute",["reproute"=>$route->id])}}' class="btn btn-danger">Remove</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

          </div><!-- table-wrapper -->
      <div class="table-wrapper">
        <b>Customers</b>
        <form method="POST" action="{{ route('user.delete.plans') }}">
            @csrf
      <table class="table">
  <thead>
    <tr>
        <th scope="col"><input type="checkbox" id="selectAll"></th>
      <th scope="col">Customer</th>
      <th scope="col">Route</th>
      <th scope="col">Week</th>
      <th scope="col">Day</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($routeplans as $routeplan)
    <tr>
        <td>
            <input type="checkbox" name="routeplan_ids[]" value="{{ $routeplan->id }}" class="selectItem">
          </td>
      <th scope="row">{{$routeplan->name}}</th>
      <th scope="row">{{$routeplan->routename}}</th>
      <td>{{$routeplan->week}}</td>
      <td>{{$routeplan->day}}</td>
      <td><a href='{{route("user.delete.plan",["routeplan"=>$routeplan->id])}}' class="btn btn-danger">Remove</a></td>
    </tr>
@endforeach
  </tbody>
</table>
<button type="submit" class="btn btn-danger">Delete Selected</button>
</form>

      </div><!-- table-wrapper -->




    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection
@section('scripts')
    <script>
  document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.selectItem');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
  });
</script>

@endsection
