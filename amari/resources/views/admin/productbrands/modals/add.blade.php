<!-- Modal -->
<div class="modal fade" id="addbrand" tabindex="-1" role="dialog" aria-labelledby="addbrandModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addbrandModalLabel">Add Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('admin.brands.store')}}">
        @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Brand Name</label>
    <input type="text" required name="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter brand Name">
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