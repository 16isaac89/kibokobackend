<div class="modal fade" id="editcategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="row g-3" method="post" action="{{route('admin.productcategory.edit')}}">
        @csrf
  <div class="col-md-12">
    <label for="inputEmail4" class="form-label">Category Name</label>
    <input type="text" class="form-control" id="catname" name="catname">
    <input type="hidden" class="form-control" id="catid" name="catid">
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