@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
      Create Route
    </div>

    @if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif

    <div class="card-body">
        <form method="POST" action="{{ route("admin.routes.store") }}">
            @csrf
            <div class="form-group">
                <label for="exampleFormControlSelect1">Select SubD</label>
                <select class="form-control select2" id="dealer" name="dealer">
                    @foreach($dealers as $dealer)
                    <option value="{{ $dealer->id }}">{{ $dealer->tradename }}</option>
                    @endforeach
                </select>
              </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Route Name</label>
              <input type="text" class="form-control" required id="name" name="name" aria-describedby="emailHelp" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Route Code</label>
                <input type="text" class="form-control" required id="code" name="code" aria-describedby="emailHelp" placeholder="Enter unique route code ">
              </div>


            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
</div>



@endsection
