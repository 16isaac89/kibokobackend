<!-- Modal -->
<div class="modal fade" id="dealertarget" tabindex="-1" role="dialog" aria-labelledby="dealertargetModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dealertargetModalLabel">Add Dealer Target</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('admin.dealer.target')}}" enctype="multipart/form-data" >
        @csrf
  <div class="row" style="margin:10px;">
    <div class="col-6">
        <label>Money</label>
      <input type="text" name="money" class="form-control" placeholder="Dealer target money">
    </div>
    <div class="col-6">
    <label>Target Month</label>
      <input type="text" name="date" id="date" class="form-control datetime" placeholder="Month">
    </div>
  </div>
  <input type="hidden" name="targetdealer" id="targetdealer" class="form-control" placeholder="Month">
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>