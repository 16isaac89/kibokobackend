<div class="modal fade" id="addcustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
      <div class="form-row">
    <div class="form-group col-4">
      <label for="inputState">Registered</label>
      <select  class="form-control" id="efrisstatus">
        <option >Choose...</option>
        <option value="1">Registered</option>
        <option value="2">Unregistered</option>
      </select>
    </div>
    <div class="form-group col-4">
      <label for="inputZip">TIN</label>
      <input type="text" class="form-control" id="tin">
    </div>
    <div class="form-group col-3 mt-3">
    <label for="inputZip"></label>
    <img src="{{asset('/images/loader.gif')}}" style="width:60px;height:60px;display:none;" id="loader">
  <a type="button" class="btn btn-warning" onclick="checkregistration()" id="getbtn">
  
  Get Info
</a>
</div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Name</label>
      <input type="email" class="form-control" id="name" placeholder="Name or Business name">
    </div>
    <div class="form-group col-md-6 ">
      <label for="inputPassword4">Phone</label>
      <input type="text" class="form-control" id="phone" placeholder="Phone number">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress2">Address:</label>
    <input type="text" class="form-control" id="address" placeholder="Apartment, studio, or floor">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Email:</label>
    <input type="text" class="form-control" id="email" placeholder="Email Address">
  </div>
  <div class="form-group">
    <label for="inputAddress">Buyer Type</label>
    <select  class="form-control" id="buyertype" required>
    <option value="0">Business/Gov</option>
    <option value="1">Individual</option>
      </select>
  </div>
  <div class="form-group">
    <label for="inputAddress">Route</label>
    <select  class="form-control" id="route" required>
        @foreach($routes as $route)
        <option value="{{$route->id}}">{{$route->name}}</option>
        @endforeach
      </select>
  </div>
  <div class="form-group">
    <label for="inputAddress">Customer Category</label>
    <select  class="form-control" id="category" required>
        <option selected value="">Choose customer category ...</option>
        @foreach($categories as $route)
        <option value="{{$route->id}}">{{$route->name}}</option>
        @endforeach
      </select>
  </div>
  
  
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="addcustomer()" class="btn btn-primary" id="savecustomer">Save changes</button>
        <img src="{{asset('images/loader.gif')}}" id="savingcustomer" style="width:50px;height:50px;border-radius:25;display:none;">
      </div>
    </div>
  </div>
</div>