<div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="adduserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adduserModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('dealer.user.store')}}">
            @csrf
            <div class="form-row mt-2">
              <div class="col">
                <select class="form-control form-control-lg" name="type">
                    <option selected>Select user type</option>
                    <option value="admin">Admin</option>
                    <option value = 'sales'>Sales</option>
                  </select>
              </div>
              <div class="col">
                <select class="form-control form-control-lg" name="target">
                    <option selected>Select user target type</option>
                    <option value="month">Monthly</option>
                    <option value = 'sku'>SKU</option>
                  </select>
              </div>
              <div class="col">
                <input type="text" class="form-control" name="username" placeholder="User Name">
              </div>
            </div>

            <div class="form-row mt-2">
                <div class="col">
                  <input type="text" class="form-control" name="phone" placeholder="Phone Number">
                </div>
                <div class="col">
                  <input type="text" class="form-control" name="password" placeholder="Password">
                </div>
              </div>

              <div class="form-row mt-2">
                <div class="col">
                    <select class="form-control form-control-lg" name="van">
                        <option selected>Select Van</option>
                        @foreach ($vans as $van)
                        <option value="{{$van->id}}">{{$van->name}} {{$van->reg_id}}</option>
                        @endforeach
                      </select>
                </div>
                <div class="col">
                    <select class="form-control form-control-lg" name="status">
                        <option selected>Select user status</option>
                        <option value="1">Active</option>
                        <option value = '0'>Inactive</option>
                      </select>
                </div>
              </div>
              <div class="form-row mt-2">
              <div class="col mt-3">
                <select class="form-control select2" data-placeholder="Choose user roles ignore if sales person" name="roles[]" multiple>
                    @foreach ($roles as $role)
                    <option value="{{$role->id}}">{{$role->title}}</option>
                    @endforeach
                </select>
              </div><!-- col-4 -->
              <div class="col mt-3">
                <select class="form-control select2" data-placeholder="Choose branch" name="branch_id">
                    @foreach ($branches as $branch)
                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                    @endforeach
                </select>
              </div><!-- col-4 -->
              </div>
              <button type="submit" class="btn btn-success">SAVE</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
