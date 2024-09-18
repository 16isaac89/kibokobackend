<div class="modal fade" id="stockrefill" tabindex="-1" role="dialog" aria-labelledby="stockrefillModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="stockcountModalCenterTitle">Stock Refill</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('dealer.save.stockrefill')}}">
          <input type="hidden" id="dispatchvanid" name="dispatchvanid">
            @csrf
            <input type="hidden" name="dispatch_id" id="dispatch_id">
      <TABLE id="datarefill" width="350px" style="margin:10px;">
		
	</TABLE>
    

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>