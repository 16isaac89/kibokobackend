@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">

      <div class="table-wrapper">
        <form method="POST" action="{{ route("products.store") }}">
            @csrf

        <div class="modal-body">

    <div class="row" style="margin:10px;">
      <div class="col-6">
        <input type="text" name="name" required class="form-control" placeholder="Product Name">
      </div>
      <div class="col-6">
        <input type="text" name="code" required class="form-control" placeholder="Product Code">
      </div>
    </div>
    <div class="row" style="margin:10px;">
      <div class="col-6">
      <select class="form-control form-control-lg" required name="productcategory">
        <option value="">Select product Category</option>
        @foreach($categories as $category)
          <option value="{{$category->id}}">{{$category->name}}</option>
          @endforeach
        </select>
        <!-- <input type="numeric" name="stock" class="form-control" placeholder="Product Stock"> -->
      </div>
      <div class="col-6">
        <select class="form-control form-control-lg" required name="brandname">
        <option>Select product Brand</option>
        @foreach($brands as $brand)
          <option value="{{$brand->id}}">{{$brand->name}}</option>
          @endforeach
        </select>
      </div>
    </div>


  <div class="row" style="margin:10px;">

      <div class="col-4">
        <select class="form-control form-control-lg" required name="supplier">
        <option>Select product supplier</option>
        @foreach($suppliers as $supplier)
          <option value="{{$supplier->id}}">{{$supplier->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-4">
        <select class="form-control form-control-lg" required name="branch_id">
        <option>Select branch</option>
        @foreach($branches as $branch)
          <option value="{{$branch->id}}">{{$branch->name}}</option>
          @endforeach
        </select>
      </div>

      <div class="col-4">
      <select class="form-control form-control-lg" style="width:200px" required name="unit">
            <option value="">Select product unit </option>
            @foreach($units as $unit)
            <option value="{{$unit->shortname}}">{{$unit->name}}</option>
          @endforeach
          </select>
      </div>


    </div>
    <div class="col-4">
        <select class="form-control form-control-lg" style="width:200px" required name="tax">
              <option value="">Select applicable tax </option>
              @foreach($taxes as $tax)
              <option value="{{$tax->id}}">{{$tax->name}}</option>
            @endforeach
            </select>
        </div>

    <div class="row" style="margin:10px;">

    <div class="col-4">
        <input type="text" name="price" required class="form-control" placeholder="Start price. ">
      </div>
      <div class="col-4">
        <input type="text" name="productcode" required class="form-control" placeholder="Product branch code. ">
      </div>
  </div>


@if(\Auth::guard('dealer')->user()->dealer->efris === 1)
  <div class="col-6">
    <label>EFRIS Product Category Code </label>
    <input type="text" name="categorycode"  {{\Auth::guard('dealer')->user()->dealer->efris === 1 ? 'required':'' }} name="categorycode" required class="form-control" placeholder="Product Efris Category Code ">
  </div>
  </div>
@endif
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

