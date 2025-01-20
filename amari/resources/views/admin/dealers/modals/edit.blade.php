<!-- Modal -->
<div class="modal fade" id="editdealer" tabindex="-1" role="dialog" aria-labelledby="editDealerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDealerModalLabel">Edit Dealer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route('admin.edit.dealer') }}">
            @csrf
            <div class="form-row mb-3">
              <div class="col">
                <input type="text" name="dealername" id="dealername" class="form-control" placeholder="Dealer Name" required>
              </div>
              <div class="col">
                <input type="text" name="dealertin" id="dealertin" class="form-control" placeholder="Dealer TIN" required>
              </div>
            </div>
            <div class="form-row mb-3">
              <div class="col">
                <input type="text" name="dealeraddress" id="dealeraddress" class="form-control" placeholder="Dealer Address" required>
              </div>
              <div class="col">
                <select class="form-control" id="dealerstatus" name="dealerstatus" required>
                  <option value="">Select Status</option>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
            </div>
            <input type="hidden" id="dealerid" name="dealerid">
            <div class="form-row mb-3">
              <div class="col">
                <select class="form-control" id="dealerefris" name="dealerefris" required>
                  <option value="">Efris Option</option>
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
              </div>
              <div class="col">
                <input type="text" name="dealerphonenumber" id="dealerphone" class="form-control" placeholder="Phone Number" required>
              </div>
            </div>
            <div class="form-row mb-3">
              <div class="col">
                <input type="email" name="email" class="form-control" id="email" placeholder="Store Email Address" required>
              </div>
              <div class="col">
                <select class="form-control" id="dealerefris" name="dealerefris" required>
                  <option value="">Supervisor</option>
                  @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ $user->username }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
                <label for="product_divisions">Select Product Divisions</label>
                <select id="product_divisions" name="product_divisions[]" class="form-control" multiple>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}"
                                {{ in_array($division->id, old('product_divisions', $dealer->productDivisions->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $division->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
