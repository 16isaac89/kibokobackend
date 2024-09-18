@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">

      <div class="table-wrapper">
        <form method="POST" action="{{ route("dealertaxes.store") }}">
            @csrf

        <div class="modal-body">

    <div class="row" style="margin:10px;">
      <div class="col-6">
        <input type="text" name="name" required class="form-control" placeholder="Tax Name">
      </div>
      <div class="col-6">
        <input type="number" name="value" required class="form-control" placeholder="Tax Value eg 18">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
        </div>
      </div>
    </div>
  </div>


        </form>
      </div><!-- table-wrapper -->
    </div><!-- card -->


@endsection

