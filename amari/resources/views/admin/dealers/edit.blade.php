@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
       Dealers List
    </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.edit.dealer',[$dealer->id]) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="dealerid" name="dealerid">

                    <div class="form-row mb-4">
                        <div class="col-md-6">
                            <input type="text" value="{{ $dealer->tradename }}" name="dealername" id="dealername" class="form-control" placeholder="Dealer Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" value="{{ $dealer->tin }}"  name="dealertin" id="dealertin" class="form-control"
                            placeholder="Dealer TIN">
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-6">
                            <input type="text" value="{{ $dealer->address }}" name="dealeraddress" id="dealeraddress"
                            class="form-control" placeholder="Dealer Address">
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" id="dealerstatus" name="dealerstatus" required>
                                <option value="">Select Status</option>
                                <option {{ $dealer->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                <option {{ $dealer->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-6">
                            <select class="form-control" id="dealerefris" name="dealerefris" required>
                                <option value="">Efris Option</option>
                                <option {{ $dealer->efris == 1 ? 'selected' : '' }} value="1">Yes</option>
                                <option {{ $dealer->efris == 0 ? 'selected' : '' }} value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" value="{{ $dealer->phonenumber }}" name="dealerphonenumber"
                             id="dealerphone" class="form-control" placeholder="Phone Number" >
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-6">
                            <input type="email" value="{{ $dealer->email }}" name="email" class="form-control" id="email" placeholder="Store Email Address" required>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" id="dealerefris" name="supervisor" required>
                                <option value="">Supervisor</option>
                                @foreach($users as $user)
                                    <option {{ $user->id == $dealer->supervisor_id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->username }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="product_divisions">Select Product Divisions</label>
                        <select id="product_divisions" name="product_divisions[]" class="form-control select2" multiple>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                        {{ in_array($division->id, old('product_divisions', $dealer->productDivisions->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                </form>
            </div>
</div>


@endsection
