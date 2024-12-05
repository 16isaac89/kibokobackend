@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card p-4">
        <h4 class="card-title mb-4">Update User</h4>
        <form method="post" action="{{ route('update.user.dealer') }}">
            @csrf
            <input type="hidden" value="{{ $user->id }}" name="userid">

            <!-- Row for Username and Phone -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="dealerusername" class="form-label">User Name</label>
                    <input type="text" id="dealerusername" value="{{ $user->username }}" class="form-control" name="dealerusername" placeholder="Enter username">
                </div>
                <div class="col-md-6">
                    <label for="dealeruserphone" class="form-label">Phone Number</label>
                    <input type="text" id="dealeruserphone" value="{{ $user->phone }}" class="form-control" name="dealeruserphone" placeholder="Enter phone number">
                </div>
            </div>

            <!-- Row for User Type, Target, and Van -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dealerusertype" class="form-label">User Type</label>
                    <select class="form-control form-control-lg" id="dealerusertype" name="dealerusertype">
                        <option selected>Select user type</option>
                        <option value="admin" {{ $user->type == "admin" ? "selected" : '' }}>Admin</option>
                        <option value="sales" {{ $user->type == "sales" ? "selected" : '' }}>Sales</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="target" class="form-label">User Target Type</label>
                    <select class="form-control form-control-lg" name="target">
                        <option>Select user target type</option>
                        <option value="month" {{ $user->targettype == "month" ? "selected" : '' }}>Monthly</option>
                        <option value="sku" {{ $user->targettype == "sku" ? "selected" : '' }}>SKU</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="dealeruservan" class="form-label">User Van</label>
                    <select class="form-control form-control-lg" id="dealeruservan" name="dealeruservan">
                        <option selected>Select Van</option>
                        @foreach ($vans as $van)
                            <option value="{{ $van->id }}" {{ $user->van_id == $van->id ? "selected" : '' }}>
                                {{ $van->name }} {{ $van->reg_id }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row for Status -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="dealeruserstatus" class="form-label">User Status</label>
                    <select class="form-control form-control-lg" id="dealeruserstatus" name="dealeruserstatus">
                        <option selected>Select user status</option>
                        <option value="1" {{ $user->status == "1" ? "selected" : '' }}>Active</option>
                        <option value="0" {{ $user->status == "0" ? "selected" : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Row for Roles and Branch -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="roles" class="form-label">Role(s)</label>
                    <select class="form-control select2" id="roles" data-placeholder="Choose roles" name="roles[]" multiple>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) || $user->dealerroles->contains($role->id) ? 'selected' : '' }}>
                                {{ $role->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="branch_id" class="form-label">Branch</label>
                    <select class="form-control select2" id="branch_id" data-placeholder="Choose branch" name="branch_id">
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
@endsection
