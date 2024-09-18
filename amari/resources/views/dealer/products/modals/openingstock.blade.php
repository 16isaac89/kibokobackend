<div class="modal fade" id="openingstock" tabindex="-1" role="dialog" aria-labelledby="addpriceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-title">Add Opening Stock</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('dealer.openingstock.product')}}">
                @csrf
                <input type="hidden" class="product-id" name="product_id" id="product-id"  >
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Opening Stock INV Number</label>
                    <input type="text"  class="form-control" name="invnumber"  placeholder="Enter opening stock invoice number">
                  </div>
                <div class="row">
                    <div class="form-group col-6">
                  <label for="exampleInputEmail1">Opening Stock</label>
                  <input type="number" required class="form-control" name="amount"  placeholder="Enter opening stock">
                </div>
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Selling Price</label>
                    <input type="number" required class="form-control" name="sellingprice"  placeholder="Enter opening stock sellingprice">
                  </div>
                </div>


                  <div class="row">
                    <div class="form-group col-6">
                    <label for="exampleInputEmail1">Opening Stock Cost</label>
                    <input type="number" required class="form-control" name="cost"  placeholder="Enter opening stock cost">
                  </div>
                  <div class="form-group col-6">
                    <label for="exampleInputEmail1">Opening Stock Comment</label>
                    <textarea class="form-control" name="comment" rows="7"></textarea>
                  </div>
                  </div>

                  <div class="row">
                  <div class="form-group col-6">
                    <label for="exampleInputEmail1">Receive date</label>
                    <input type="text" class="form-control date" name="receive_date"  >
                  </div>
                  <div class="form-group col-6">
                    <label for="exampleInputEmail1">Stock Expiry Date</label>
                    <input type="text" required class="form-control date" name="expiry_date" >
                  </div>
                </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>
