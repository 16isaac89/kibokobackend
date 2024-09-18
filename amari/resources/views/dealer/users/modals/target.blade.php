<div class="modal fade" id="targetuser" tabindex="-1" role="dialog" aria-labelledby="adduserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="adduserModalLabel">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{route('salertargets.store')}}">
              @csrf
              <div class="form-row mt-2">
                <div class="col">
                    <input type="text" class="form-control" id="month" name="month" placeholder="Month">
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" name="money" placeholder="Amount">
                  </div>
                 
                </div>
                <input type="hidden" id="userid" name="userid">
                <button type="submit" class="btn btn-primary mt-2">Save</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>