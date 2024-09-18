@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">

      <div class="table-wrapper">
        <form method="POST" action="{{ route("dealerbrands.update", [$dealerbrand->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Brand Name</label>
                <input type="text" required name="name" value="{{ $dealerbrand->name }}" class="form-control" id="name" aria-describedby="emailHelp" >
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection

