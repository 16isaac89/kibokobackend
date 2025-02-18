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
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="productName">Product Name</label>
                            <input type="text" name="name" id="productName" class="form-control" required placeholder="Enter Product Name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="productCode">Product Code</label>
                            <input type="text" name="code" id="productCode" class="form-control" required placeholder="Enter Product Code">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="productCategory">Product Category</label>
                            <select class="form-control" name="productcategory" id="productCategory" required>
                                <option value="" disabled selected>Select Product Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->code }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="brandName">Product Brand</label>
                            <select class="form-control" name="brandname" id="brandName" required>
                                <option value="" disabled selected>Select Product Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->code }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="categoryCode">Efris Category Code</label>
                            <input type="text" name="categorycode" id="categoryCode" class="form-control" required placeholder="Enter Efris Category Code">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="division">Division</label>
                            <select class="form-control" name="division" id="division" required>
                                <option value="" disabled selected>Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="group">Group</label>
                            <input type="text" name="group" id="group" class="form-control" required placeholder="Enter Group">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="unit">Unit</label>
                            <input type="text" name="unit" value="PP" id="unit" class="form-control" required placeholder="Enter Product Unit">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tax_id">Product Tax</label>
                            <select class="form-control" name="tax_id" id="tax_id" required>
                                <option value="" disabled selected>Select Product Tax</option>
                                @foreach($taxes as $tax)
                                    <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <label for="unit" class="form-label">Tax Amount:</label>
                            <input type="text" id="unit" name="unit" class="form-control"
                            required placeholder="eg 0,18">
                        </div>
                        <div class="col-md-6">
                            <label for="unit" class="form-label">Selling Price:</label>
                            <input type="text" id="price" name="price" class="form-control"
                            required placeholder="eg 0,18">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
