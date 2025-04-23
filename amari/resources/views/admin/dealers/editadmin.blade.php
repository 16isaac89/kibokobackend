@extends('layouts.admin')
@section('content')


<div class="card">
    <div class="card-header">
      Update User
    </div>



    <div class="card-body">
        <form method="post" action="{{route('admin.dealer.updateuser',$user->id)}}">
            @csrf
            @method('PUT')
      <div class="row" style="margin:10px;">
        <div class="col-6">
          <input type="text" name="username" id="username" value="{{ $user->username }}" class="form-control" placeholder="User name">
        </div>
        <div class="col-6">
          <input type="text" name="phone" id="phone" value="{{ $user->phone }}" class="form-control" placeholder="Phone number">
        </div>
      </div>
      <div class="row" style="margin:10px;">

        <div class="col-6">
            <Label>Set active/inactive</label>
          <select class="form-control form-control-lg" required id="userstatus" name="userstatus">

          <option required value="">Active</option>
            <option value="1" {{ $user->status == 1 || $user->status == "1" ? 'selected' : '' }}>Yes</option>
           <option value="0" {{ $user->status == 1 || $user->status == "1" ? 'selected' : '' }}>No</option>
          </select>
        </div>
        <div class="col-6">
            <label>Division</label>
            <select required class="form-control select2" id="product_divisions[]" multiple name="product_divisions[]">
            @foreach($divisions as $division)
            <option value="{{ $division->id }}" {{ in_array($division->id, $assigned_divisions) ? 'selected' : '' }}>
                {{ $division->name }}
            </option>
            @endforeach
            </select>
          </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
</div>



@endsection
@section('scripts')

@endsection
