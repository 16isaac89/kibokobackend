<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">ADD CUSTOMER</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('customers.store')}}">
                @csrf
                <div class="row">
                  <div class="col">
                    <input type="text" class="form-control" name="name" placeholder="Name">
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" name="phone" placeholder="Phone">
                  </div>
                </div>
                <div class="row">
                    <div class="col">
                      <input type="text" class="form-control" name="address" placeholder="Address">
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" placeholder="TIN" name="tin">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col">
                        <select id="inputState" class="form-control" name="category">
                            <option selected>Choose category</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option> 
                            @endforeach
                          </select>
                    </div>
                    <div class="col">
                        <select id="inputState" class="form-control" name="route">
                            <option selected>Choose route.</option>
                            @foreach ($routes as $route)
                            <option value="{{$route->id}}">{{$route->name}}</option>
                            @endforeach
                          </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-6">
                  <select id="inputState" class="form-control" name="status">
                    <option selected>Choose status</option>
                    <option value="1">Active</option>
                    <option value="0">InActive</option>
                  </select>
                </div>
                  <div class="col-6">
                    <div class="col">
                      <input type="text" class="form-control" placeholder="Credit Limit" name="credit">
                    </div>
                  </div>
                </div>
                  <button type="submit" class="btn btn-primary">Save changes</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    
        </div>
      </div>
    </div>
  </div>