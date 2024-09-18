<!-- Modal -->
<div class="modal fade" id="editdealer" tabindex="-1" role="dialog" aria-labelledby="editproductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editproductModalLabel">Edit Dealer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form method="post" action="{{route('admin.edit.dealer')}}">
        @csrf
  <div class="row" style="margin:10px;">
    <div class="col-6">
      <input type="text" name="dealername" id="dealername" class="form-control" >
    </div>
    <div class="col-6">
      <input type="text" name="dealertin" id="dealertin" class="form-control">
    </div>
  </div>
  <div class="row" style="margin:10px;">
    <div class="col-6">
      <input type="text" name="dealeraddress" id="dealeraddress" class="form-control" >
    </div>
    <div class="col-6">
      <select class="form-control form-control-lg" id="dealerstatus" name="dealerstatus">
      <option>Active</option>
        <option value="1">Yes</option>
       <option value="0">No</option>
      </select>
    </div>
  </div>
  <input type="hidden" id="dealerid" name="dealerid">
  <div class="row">
  <div class="col-6">
      <select class="form-control form-control-lg" id="dealerefris" name="dealerefris">
      <option>Efris</option>
        <option value="1">Yes</option>
       <option value="0">No</option>
      </select>
    </div>
    <div class="col-6">
      <input type="text" name="dealerphonenumber" id="dealerphone" class="form-control">
    </div>
  </div>

  <div class="row" style="margin:10px;">
    <div class="col-6">
        <input type="text" name="email" class="form-control" id="email" placeholder="e.g Store email address">
      </div>
      <div class="col-6">
          <select class="form-control" name="sub_type" id="sub_type">
              <option>Subscription Type</option>
                <option value="1">Monthly</option>
               <option value="2">Yearly</option>
              </select>
        </div>
  </div>
  <div class="row" style="margin:10px;">
      <div class="col-6">
          <input type="text" name="startdate" id="startdate" class="form-control date" placeholder="Start Date">
        </div>
        <div class="col-6">
          <input type="text" name="enddate" id="enddate" class="form-control date" placeholder="End Date">
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
