<!-- Modal -->
<div class="modal fade" id="documents" tabindex="-1" role="dialog" aria-labelledby="documentsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="documentsModalLabel">Apply For Credit Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="{{route('dealer.sales.notesform')}}">
        @csrf
        <input type="hidden" id="sale" name="sale">
  <div class="form-group row">
    <div class="col-sm-10">
    <select class="form-control" name="note">
    <option value="0">Choose Reason for credit note</option>
    <option value="1">Debit Note</option>
    <option value="2">Credit Note</option>
    </select>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
      <input type="text" class="form-control" id="reason" name="reason" placeholder="Password">
    </div>
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