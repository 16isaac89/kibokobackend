<!-- Modal -->
<div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="addproductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addproductModalLabel">Product Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('admin.products.store')}}">
        @csrf
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

    {{-- <div class="col-4">
    <select class="form-control form-control-lg" style="width:200px" required name="unit">
          <option value="">Select product unit </option>
          @foreach($units as $unit)
          <option value="{{$unit->shortname}}">{{$unit->name}}</option>
        @endforeach
        </select>
    </div> --}}

    <div class="col-4">
      <input type="text" name="categorycode" required class="form-control" placeholder="Product Efris Category Code ">
    </div>
  </div>



  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
