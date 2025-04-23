<!-- Modal -->
<div class="modal fade" id="dealeruser" tabindex="-1" role="dialog" aria-labelledby="dealeruserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dealeruserModalLabel">Edit Dealer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form method="post" action="{{route('admin.dealer.user')}}">
        @csrf
  <div class="row" style="margin:10px;">
    <div class="col-6">
      <input type="text" name="username" id="username" class="form-control" placeholder="User name">
    </div>
    <div class="col-6">
      <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone number">
    </div>
  </div>
  <div class="row" style="margin:10px;">
    <div class="col-6">
      <input type="text" name="password" id="password" class="form-control" placeholder="Password">
    </div>
    <div class="col-6">
        <Label>Set active/inactive</label>
      <select class="form-control form-control-lg" required id="userstatus" name="userstatus">

      <option required value="">Active</option>
        <option value="1">Yes</option>
       <option value="0">No</option>
      </select>
    </div>
    <div class="col-6">
        <label>Division</label>
        <select required class="form-control select2" id="product_divisions[]" multiple name="product_divisions[]">
        @foreach($divisions as $division)
          <option value="{{ $division->id }}">{{ $division->name }}</option>
        @endforeach
        </select>
      </div>
  </div>
  <input type="hidden" id="iddealer" name="iddealer">


  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
