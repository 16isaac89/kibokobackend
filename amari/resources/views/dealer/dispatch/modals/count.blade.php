<div class="modal fade" id="stockcount" tabindex="-1" role="dialog" aria-labelledby="stockcountModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="stockcountModalCenterTitle">Items</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('dealer.save.stockcount')}}">
            @csrf
            <table class="table" width="350px">
            <thead>
              <tr>
                <th scope="col" style="text-align:center;width: 100px;">ITEM</th>
                <th scope="col" style="text-align:center;width: 100px;">STOCK</th>
                <th scope="col" style="text-align:center;width: 100px;">SOLD</th>
                <th scope="col" style="text-align:center;width: 100px;">Dispatched</th>
                <!-- <th scope="col" style="text-align:center;width: 100px;">COUNT</th> -->
              </tr>
            </thead>
              </table>
      <TABLE id="dataTable" width="350px">
		
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