<!-- Modal -->
<div class="modal fade" id="editproduct" tabindex="-1" role="dialog" aria-labelledby="editproductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editproductModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('admin.product.edit')}}">
        @csrf
   <div class="row" style="margin:10px;">
    <div class="col-6">
      <label>Product Name:</label>
      <input type="text" id="productname" name="productname" class="form-control" >
    </div>
    <div class="col-6">
    <label>Product Code:</label>
      <input type="text" id="productcode" name="productcode" class="form-control" >
    </div>
  </div>
  <input type="hidden" name="productid" id="productid">
  <div class="row" style="margin:10px;">

    <div class="col-6">
    <label>Product Brand:</label>
      <select class="form-control form-control-lg" id="productbrandname" name="productbrandname">
      <option>Select product Brand</option>
      @foreach($brands as $brand)
        <option  value="{{$brand->id}}">{{$brand->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="row">
  <div class="col-6">
  <label>Product Unit:</label>
      <input type="text" id="productunit" name="productunit" class="form-control">
    </div>
    <div class="col-6">
    <label>Product Price:</label>
      <input type="text" id="productprice" name="productprice" class="form-control">
    </div>
  </div>




  <button type="submit" style="margin:10px;" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
