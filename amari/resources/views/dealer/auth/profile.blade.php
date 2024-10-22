@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="container mt-5">
        <!-- Edit Profile Section -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5>Edit Profile</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('update.user.dealer')}}">
                    @csrf
                    <input type="hidden" value="{{$user->id}}" name="userid">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dealerusername" class="form-label">User Name</label>
                            <input type="text" value="{{$user->username}}" class="form-control" name="dealerusername" id="dealerusername">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dealeruserphone" class="form-label">Phone Number</label>
                            <input type="text" value="{{$user->phone}}" class="form-control" name="dealeruserphone" id="dealeruserphone">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="dealerusertype" class="form-label">User Type</label>
                            <select class="form-control" name="dealerusertype" id="dealerusertype">
                                <option selected disabled>Select user type</option>
                                <option value="admin" {{ $user->type == "admin" ? "selected" : '' }}>Admin</option>
                                <option value="sales" {{ $user->type == "sales" ? "selected" : '' }}>Sales</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="target" class="form-label">User Target Type</label>
                            <select class="form-control" name="target" id="target">
                                <option selected disabled>Select user target type</option>
                                <option value="month" {{ $user->targettype == "month" ? "selected" : '' }}>Monthly</option>
                                <option value="sku" {{ $user->targettype == "sku" ? "selected" : '' }}>SKU</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="dealeruservan" class="form-label">User Van</label>
                            <select class="form-control" name="dealeruservan" id="dealeruservan">
                                <option selected disabled>Select Van</option>
                                @foreach ($vans as $van)
                                <option value="{{$van->id}}" {{ $user->van_id == $van->id ? "selected" : '' }}>{{$van->name}} {{$van->reg_id}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dealeruserstatus" class="form-label">User Status</label>
                            <select class="form-control" name="dealeruserstatus" id="dealeruserstatus">
                                <option selected disabled>Select user status</option>
                                <option value="1" {{ $user->status == "1" ? "selected" : '' }}>Active</option>
                                <option value="0" {{ $user->status == "0" ? "selected" : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="roles" class="form-label">Role(s)</label>
                            <select class="form-control" name="roles[]" multiple>
                                @foreach ($roles as $role)
                                <option value="{{$role->id}}" {{ (in_array($role->id, old('roles', [])) || $user->dealerroles->contains($role->id)) ? 'selected' : '' }}>{{$role->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="branch_id" class="form-label">Branch</label>
                            <select class="form-control" name="branch_id" id="branch_id">
                                @foreach ($branches as $branch)
                                <option value="{{$branch->id}}" {{ $user->branch_id == $branch->id ? 'selected' : '' }}>{{$branch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- Change Password Section -->
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-white">
                <h5>Change Password</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('user.edit.changepassword')}}">
                    @csrf

                    <div class="mb-3">
                        <label for="old_password" class="form-label">Old Password</label>
                        <input type="password" class="form-control" name="old_password" id="old_password" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="new_password_confirmation" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning mt-3">Change Password</button>
                </form>
            </div>
        </div>
    </div>

</div>

@endSection
