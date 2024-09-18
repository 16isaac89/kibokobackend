<div class="modal fade" id="editlocation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="row g-3" method="post" action="{{route('admin.locations.edit')}}">
        @csrf
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Name</label>
    <input type="text" name="locationname" id="locationname" class="form-control" >
  </div>
  <input type="hidden" name="locationid" id="locationid" class="form-control" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>