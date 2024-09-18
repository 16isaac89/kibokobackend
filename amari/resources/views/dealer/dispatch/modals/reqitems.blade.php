<div class="modal fade" id="requestitems" tabindex="-1" role="dialog" aria-labelledby="requestitemsModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="requestitemsModalCenterTitle">Requested Items</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('dealer.storestock.requests')}}">
          <input type="hidden" id="dispatchid" name="dispatchid">
            @csrf
            <input type="hidden" name="dispatch_id" id="dispatch_id">
            <table class="table" width="350px">
  <thead>
    <tr>
      <th scope="col" style="width:100px;">Item Desc</th>
      <th scope="col" style="width:100px;">Qty Red</th>
      <th scope="col" style="width:100px;">Batch</th>
      <th scope="col" style="width:100px;">Give</th>
    </tr>
  </thead>
</table>
      <TABLE id="reqsitems" width="350px" style="margin:10px;">
		
	</TABLE>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <button type="submit" id="submitapproval" class="btn btn-primary">Approve and Dispatch</button>
        </form>
        <form method="post" action="{{route('dealer.reject.storestock')}}">
            @csrf
            <input type="hidden" id="rejectid" name="rejectid">
        <button type="submit" id="submitreject" class="btn btn-danger">Reject</button>
</form>
      </div>
    </div>
  </div>
</div>