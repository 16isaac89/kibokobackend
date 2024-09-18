<!-- Modal -->
<div class="modal fade" id="editroute" tabindex="-1" role="dialog" aria-labelledby="editrouteModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editrouteModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('dealer.route.edit')}}">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Route Name</label>
                  <input type="text" class="form-control" id="routename" name="routename">
                  <input type="hidden" class="form-control" id="routeid" name="routeid">
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