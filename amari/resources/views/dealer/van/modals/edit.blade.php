<!-- Modal -->
<div class="modal fade" id="editvan" tabindex="-1" role="dialog" aria-labelledby="editvanModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editvanModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('dealer.van.edit')}}">
              @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Van Name</label>
                  <input type="text" class="form-control" id="vanname" name="vanename">
                  <input type="hidden" class="form-control" id="vanid" name="vanid">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Van Regd</label>
                  <input type="text" class="form-control" id="vanreg" name="vanreg">
                </div>
              </div>
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