@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">

      <div class="table-wrapper">
        <form method="POST" action="{{ route("dealerbranches.store") }}">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Branch Name</label>
                <input type="text" required name="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter branch Name">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Branch Address</label>
                <input type="text" required name="address" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter branch Address">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Branch Phone</label>
                <input type="text" required name="phone" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter branch phone number">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection

