<div class="modal fade" id="targethistory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b id="username"></b> History</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('dealer.users.targetindex')}}">
            @csrf
            <div class="row">
  
    <input type="hidden" name="dealeruser" id="dealeruser" >
 
  <div class="col-6">
    <input type="text" class="form-control month" name="fromdate" placeholder="From Date" id="month">
  </div>
  <div class="col-6">
    <input type="text" class="form-control month" name="todate" placeholder="To Date" id="month2">
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