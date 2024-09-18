@extends('layouts.dealer')
@section('content')
      <div class="am-pagebody">
        <div class="card pd-20 pd-sm-40 mg-t-50">
            <h6 class="card-body-title">Edit {{$dealerrole->title}} Role</h6>


            <form method="POST" action="{{ route("dealerroles.update", [$dealerrole->id]) }}">
                @method('PUT')
                @csrf
            <div class="row mg-t-20">
                <div class="col-lg-6">
                    <input class="form-control" value="{{$dealerrole->title}}" name="title" placeholder="Role name" type="text">
                  </div><!-- col -->
                  <input class="form-control" name="dealer_id" type="hidden" value="{{\Auth::guard('dealer')->user()->dealer_id}}">
              <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                <select class="form-control select2" data-placeholder="Choose permissions" name="permissions[]" multiple>
                    @foreach ($permissions as $permission)
                    <option value="{{$permission->id}}" {{ (in_array($permission->id, old('permissions', [])) || $dealerrole->dealerpermissions->contains($permission->id)) ? 'selected' : '' }}>{{$permission->title}}</option>
                    @endforeach

                </select>
              </div><!-- col-4 -->

            </div><!-- row -->
            <button class="btn btn-success" type="submit">SAVE</button>
        </form>

          </div><!-- card -->


      </div><!-- am-pagebody -->
    @endsection
    @section('scripts')

    @endsection
