<div class="modal fade" id="addunit" tabindex="-1" role="dialog" aria-labelledby="addsupplierLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Units</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="row g-3" method="post" method="{{route('admin.productunits.store')}}">
            @csrf
 
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Name</label>
    <input type="text" class="form-control" name="name" required id="name">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Short Name</label>
    <input type="text" class="form-control" name="shortname" required id="shortname">
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send message</button>
        </form>
      </div>
    </div>
  </div>
</div>