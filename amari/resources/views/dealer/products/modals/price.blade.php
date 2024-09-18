<div class="modal fade" id="addprice" tabindex="-1" role="dialog" aria-labelledby="addpriceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addpriceModalLabel">Add Selling Price</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('update.dealer.product')}}">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Selling Price</label>
                  <input type="number" class="form-control" name="price"  placeholder="Enter selling price">
                 
                </div>
             <input type="hidden" id="product" name="product">
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>