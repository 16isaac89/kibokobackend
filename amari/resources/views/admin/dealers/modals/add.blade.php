<!-- Modal -->
<div class="modal fade" id="adddealer" tabindex="-1" role="dialog" aria-labelledby="addproductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addproductModalLabel">Add Dealer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('admin.dealers.store')}}" enctype="multipart/form-data" >
        @csrf
  <div class="row" style="margin:10px;">
    <div class="col-6">
      <input type="text" name="name" class="form-control" placeholder="Dealer Name">
    </div>
    <div class="col-6">
      <input type="text" name="tin" class="form-control" placeholder="Dealer TIN">
    </div>
  </div>
  <div class="row" style="margin:10px;">
    <div class="col-6">
      <input type="text" name="address" class="form-control" placeholder="Dealer Address">
    </div>
    <div class="col-6">
      <select class="form-control" name="status">
      <option>Active</option>
        <option value="1">Yes</option>
       <option value="0">No</option>
      </select>
    </div>
  </div>
  <div class="row">
  <div class="col-6">
      <select class="form-control" name="efris">
      <option>Efris Active</option>
        <option value="1">Yes</option>
       <option value="0">No</option>
      </select>
    </div>
    <div class="col-6">
      <input type="text" name="phonenumber" class="form-control" placeholder="Phone Number">
    </div>
  </div>

  <div class="row" style="margin:10px;">
    <div class="col-6">
      <input type="text" name="deviceno" class="form-control" placeholder="Device no">
    </div>
    <div class="col-6">
      <input type="file" name="privatekey" class="form-control" placeholder="Dealer TIN">
    </div>
  </div>

  <div class="row" style="margin:10px;">
    <div class="col-6">
      <input type="text" name="keypwd" class="form-control" placeholder="Key Password">
    </div>
    <div class="col-6">
      <input type="text" name="branch" class="form-control" placeholder="Branch e.g HQ">
    </div>
  </div>

  <div class="row" style="margin:10px;">
  <div class="col-6">
      <input type="text" name="email" class="form-control" placeholder="e.g Store email address">
    </div>
    <div class="col-6">
        <select class="form-control" name="sub_type">
            <option>Subscription Type</option>
              <option value="1">Monthly</option>
             <option value="2">Yearly</option>
            </select>
      </div>
</div>
<div class="row">
<div class="col-6">
  <select class="form-control" name="business_type">
      <option>Select Type of Business</option>
        <option value="1">Shop</option>
       <option value="2">Distributor</option>
      </select>
</div>
</div>
<div class="row" style="margin:10px;">
    <div class="col-6">
        <input type="text" name="startdate" class="form-control date" placeholder="Start Date">
      </div>
      <div class="col-6">
        <input type="text" name="enddate" class="form-control date" placeholder="End Date">
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
