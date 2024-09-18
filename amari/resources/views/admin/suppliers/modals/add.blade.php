<div class="modal fade" id="addsupplier" tabindex="-1" role="dialog" aria-labelledby="addsupplierLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="row g-3" method="post" action="{{route('admin.suppliers.store')}}">
            @csrf
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">TIN</label>
    <input type="text" class="form-control" required name="tin" id="tin">
  </div>
  <div class="col-md-4">
  <img src="{{asset('/images/loader.gif')}}" style="width:60px;height:60px;display:none;" id="loader">
  <a type="button" class="btn btn-secondary" onclick="checktin()" id="getbtn">
  
  Get Info
</a>
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Name</label>
    <input type="text" class="form-control" name="name" required id="name">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Phone</label>
    <input type="text" class="form-control" name="phone" required id="phone">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Email</label>
    <input type="text" class="form-control"required id="email" name="email">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Address</label>
    <input type="text" class="form-control" required id="address" name="address">
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send message</button>
        </form>
      </div>
    </div>
  </div>
</div>