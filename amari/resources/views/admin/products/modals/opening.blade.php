<!-- Modal -->
<div class="modal fade" id="openingstock" tabindex="-1" role="dialog" aria-labelledby="addproductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addproductModalLabel">Add Stock for <b id="opname"><b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('admin.openingstock.product')}}">
        @csrf
    <div class="col-6">
      <input type="number" required name="openingstock" required class="form-control" placeholder="Opening stock">
    </div>
<input type="hidden" id="openingstockid" name="stockid">

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 
      </div>
    </div>
  </div>
</div>