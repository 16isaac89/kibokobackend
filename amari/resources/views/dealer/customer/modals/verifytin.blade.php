<div class="modal fade" id="verifytinModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Verify CUSTOMER TIN</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


                    <div class="form-control">
                      <input type="text" class="form-control" placeholder="TIN" id="customer_tin">
                    </div>


                    <div id="infoDiv">
                        <h2>Taxpayer Information</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody id="infoTableBody">
                                <!-- Populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="verifytin()">Check</button>
        </div>
      </div>
    </div>
  </div>
