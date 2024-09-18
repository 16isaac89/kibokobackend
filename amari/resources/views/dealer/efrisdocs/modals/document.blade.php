<div class="modal fade" id="cancelnote" tabindex="-1" role="dialog" aria-labelledby="cancelnoteCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelnoteCenterTitle">Cancel Credit Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action = "{{route('dealer.creditnote.cancel')}}">
            @csrf
            <input type="hidden" name="noteid" id="noteid">
      <select class="form-control" aria-label="Default select example" name="reasonCode" id="reasoncode"  onchange="reasoncodechanged(this);">
  <option selected value="" required="required">Reason</option>
  <option value="101">Buyer refused to accept the invoice due to incorrect invoice/receipt</option>
  <option value="102">Not delivered due to incorrect invoice/receipt</option>
  <option value="103">Other reasons</option>
</select>

<div class="form-group" style="margin-top:10px;" id="statement">
  <label for="exampleFormControlTextarea3" class="required">Reason Details</label>
  <textarea class="form-control" name="reason" rows="7"></textarea>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
</form>
      </div>
    </div>
  </div>
</div>
