@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">

      <div class="table-wrapper">
        <form method="POST" action="{{ route("dealersuppliers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">TIN</label>
                <input type="text" class="form-control" required name="tin" id="tin">
              </div>
              <div class="col-md-4">
              <img src="{{asset('/images/loader.gif')}}" style="width:60px;height:60px;display:none;" id="loader">
              <a type="button" class="btn btn-secondary" onclick="checktin()" id="getbtn">

              Get Info
            </a>
              </div>
              <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" required id="name">
              </div>
              <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" required id="phone">
              </div>
              <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Email</label>
                <input type="text" class="form-control"required id="email" name="email">
              </div>
              <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Address</label>
                <input type="text" class="form-control" required id="address" name="address">
              </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send message</button>
        </form>
      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection

