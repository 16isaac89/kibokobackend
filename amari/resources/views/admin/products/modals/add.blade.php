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
          <form method="post" action="{{ route('admin.products.store') }}">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="productName">Product Name</label>
                <input type="text" name="name" id="productName" required class="form-control" placeholder="Enter Product Name">
              </div>
              <div class="form-group col-md-6">
                <label for="productCode">Product Code</label>
                <input type="text" name="code" id="productCode" required class="form-control" placeholder="Enter Product Code">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="productCategory">Product Category</label>
                <select class="form-control" required name="productcategory" id="productCategory">
                  <option value="">Select Product Category</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->code }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="brandName">Product Brand</label>
                <select class="form-control" required name="brandname" id="brandName">
                  <option value="">Select Product Brand</option>
                  @foreach($brands as $brand)
                    <option value="{{ $brand->code }}">{{ $brand->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="categoryCode">Product Efris Category Code</label>
                <input type="text" name="categorycode" id="categoryCode" required class="form-control" placeholder="Enter Efris Category Code">
              </div>
              <div class="form-group col-md-4">
                <label for="division">Division</label>
                <input type="text" name="division" id="division" required class="form-control" placeholder="Enter Division">
              </div>
              <div class="form-group col-md-4">
                <label for="group">Group</label>
                <input type="text" name="group" id="group" required class="form-control" placeholder="Enter Group">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="unit">Unit</label>
                <input type="text" name="unit" id="unit" required class="form-control" placeholder="Enter Product Unit">
              </div>
            </div>

            <div class="form-group col-md-6">
                <label for="brandName">Product Tax</label>
                <select class="form-control" required name="tax_id" id="brandName">
                  <option value="">Select Product Tax</option>
                  @foreach($taxes as $tax)
                    <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                  @endforeach
                </select>
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
