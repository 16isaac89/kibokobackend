@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">

    <div class="card pd-20 pd-sm-40">

      <div class="table-wrapper">
      <form method="post" action="{{route('update.user.dealer')}}">
        @csrf
  <div class="row">
    <div class="col m-2">
        <label>User name: </label>
      <input type="text" value="{{$user->username}}" class="form-control" name="dealerusername">
    </div>
    <div class="col m-2">
    <label>Phone number: </label>
      <input type="text" value="{{$user->phone}}" class="form-control" name="dealeruserphone">
    </div>
  </div>
<input type="hidden" value="{{$user->id}}" name="userid">
  <div class="row">
    <div class="col m-2">
    <label>User type: </label>
    <select class="form-control form-control-lg" id="dealerusertype" name="dealerusertype">
                      <option selected>Select user type</option>
                      <option value="admin" {{ $user->type=="admin" ? "selected" : ''}}>Admin</option>
                      <option value = 'sales' {{ $user->type=="sales" ? "selected" : ''}}>Sales</option>
                    </select>
    </div>


    <div class="col">
    <label>User target type: </label>
                <select class="form-control form-control-lg" name="target">
                    <option>Select user target type</option>
                    <option value="month" {{ $user->targettype=="month" ? "selected" : ''}}>Monthly</option>
                      <option value = 'sku' {{ $user->targettype=="sku" ? "selected" : ''}}>SKU</option>
                  </select>
              </div>


    <div class="col m-2">
    <label>User Van: </label>
    <select class="form-control form-control-lg" id="dealeruservan" name="dealeruservan">
                          <option selected>Select Van</option>
                          @foreach ($vans as $van)
                          <option value="{{$van->id}}" {{ $user->van_id == $van->id ? "selected" : ''}}>{{$van->name}} {{$van->reg_id}}</option>
                          @endforeach
                        </select>
    </div>
  </div>


  <div class="row">
    <div class="col m-2">
    <label>User status: </label>
    <select class="form-control form-control-lg" id="dealeruserstatus" name="dealeruserstatus">
                          <option selected>Select user status</option>
                          <option {{ $user->status=="1" ? "selected" : ''}} value="1">Yes</option>
                          <option {{ $user->status=="0" ? "selected" : ''}} value = '0'>No</option>
                        </select>
    </div>
  </div>
  <div class="row">
  <div class="col-lg-6 mg-t-20 mg-lg-t-0  mt-3">
    <label>Role(s): </label>
    <select class="form-control select2" data-placeholder="Choose roles" name="roles[]" multiple>
        @foreach ($roles as $role)
        <option value="{{$role->id}}" {{ (in_array($role->id, old('roles', [])) || $user->dealerroles->contains($role->id)) ? 'selected' : '' }}>{{$role->title}}</option>
        @endforeach
    </select>
  </div><!-- col-4 -->
  <div class="col mt-3">
    <label>Branch: </label>
    <select class="form-control select2" data-placeholder="Choose branch" name="branch_id">
        @foreach ($branches as $branch)
        <option value="{{$branch->id}}"{{ $user->branch_id === $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
        @endforeach
    </select>
  </div><!-- col-4 -->
</div>
  <button type="submit" class="btn btn-primary m-3">Save</button>
</form>

      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection
@section('scripts')

@endsection
