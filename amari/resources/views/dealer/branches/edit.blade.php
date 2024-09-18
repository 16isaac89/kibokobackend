@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">

      <div class="table-wrapper">
        <form method="POST" action="{{ route("dealerbranches.update", [$dealerbranch->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Branch Name</label>
                <input type="text" required name="name" class="form-control" id="name" value="{{ $dealerbranch->name }}">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Branch Address</label>
                <input type="text" required name="address" class="form-control" id="name" value="{{ $dealerbranch->address }}">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Branch Phone</label>
                <input type="text" required name="phone" class="form-control" id="name" value="{{ $dealerbranch->phone }}">
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection

