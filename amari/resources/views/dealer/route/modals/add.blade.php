<div class="modal fade" id="addroute" tabindex="-1" role="dialog" aria-labelledby="addrouteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addrouteModalLabel">Route Name</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
            <form method="POST" action="{{route('routes.store')}}">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Route Name</label>
                  <input type="text" class="form-control" name="name"  aria-describedby="emailHelp" placeholder="Route Name">
       
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