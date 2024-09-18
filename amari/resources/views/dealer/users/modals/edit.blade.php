<div class="modal fade" id="edituserdetails" tabindex="-1" role="dialog" aria-labelledby="adduserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="adduserModalLabel">Edit User Info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" method="{{url('/dealer/users/update')}}">
              @csrf
              <div class="form-row mt-2">
                <div class="col">
                  <select class="form-control form-control-lg" id="dealerusertype" name="dealerusertype">
                      <option selected>Select user type</option>
                      <option value="admin">Admin</option>
                      <option value = 'sales'>Sales</option>
                    </select>
                </div>
                <div class="col">
                  <input type="text" class="form-control" id="dealerusername" name="dealerusername" >
                </div>
              </div>
  
              <div class="form-row mt-2">
                  <div class="col">
                    <input type="text" class="form-control" id="dealeruserphone" name="dealeruserphone" >
                  </div>
                 
                </div>
                <input type="hidden" id="dealeruserid" id="dealeruserid" name="dealeruserid">
                <div class="form-row mt-2">
                  <div class="col">
                      <select class="form-control form-control-lg" id="dealeruservan" name="dealeruservan">
                          <option selected>Select Van</option>
                          @foreach ($vans as $van)
                          <option value="{{$van->id}}">{{$van->name}} {{$van->reg_id}}</option> 
                          @endforeach
                        </select>
                  </div>
                  <div class="col">
                      <select class="form-control form-control-lg" id="dealeruserstatus" name="dealeruserstatus">
                          <option selected>Select user status</option>
                          <option value="1">Yes</option>
                          <option value = '0'>No</option>
                        </select>
                  </div>
                </div>
          
               
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>