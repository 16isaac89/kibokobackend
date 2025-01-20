<!-- Modal -->
<div class="modal fade" id="adddealer" tabindex="-1" role="dialog" aria-labelledby="addproductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addproductModalLabel">Add Dealer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route('admin.dealers.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Dealer Name & TIN -->
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Dealer Name</label>
                  <input type="text" name="name" id="name" class="form-control" placeholder="Dealer Name">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tin">Dealer TIN</label>
                  <input type="text" name="tin" id="tin" class="form-control" placeholder="Dealer TIN">
                </div>
              </div>
            </div>

            <!-- Dealer Address & Status -->
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="address">Dealer Address</label>
                  <input type="text" name="address" id="address" class="form-control" placeholder="Dealer Address">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" name="status" id="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Efris Active & Phone Number -->
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="efris">Efris Active</label>
                  <select class="form-control" name="efris" id="efris">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="phonenumber">Phone Number</label>
                  <input type="text" name="phonenumber" id="phonenumber" class="form-control" placeholder="Phone Number">
                </div>
              </div>
            </div>

            <!-- Device No & Private Key -->
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="deviceno">Device No</label>
                  <input type="text" name="deviceno" id="deviceno" class="form-control" placeholder="Device No">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="privatekey">Upload Private Key</label>
                  <input type="file" name="privatekey" id="privatekey" class="form-control">
                </div>
              </div>
            </div>

            <!-- Key Password & Branch -->
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="keypwd">Key Password</label>
                  <input type="text" name="keypwd" id="keypwd" class="form-control" placeholder="Key Password">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="branch">Branch (e.g., HQ)</label>
                  <input type="text" name="branch" id="branch" class="form-control" placeholder="Branch">
                </div>
              </div>
            </div>

            <!-- Dealer Code -->
            <div class="form-group mb-3">
              <label for="code">Dealer Code</label>
              <input type="text" name="code" id="code" class="form-control" placeholder="Dealer Code">
            </div>

            <!-- Product Divisions -->
            <div class="form-group mb-3">
              <label for="product_divisions">Select Product Divisions</label>
              <select id="product_divisions" name="product_divisions[]" class="form-control select2" multiple>
                @foreach ($divisions as $division)
                  <option value="{{ $division->id }}" {{ in_array($division->id, old('product_divisions', [])) ? 'selected' : '' }}>
                    {{ $division->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-row mb-4">

                <div class="col-md-6">
                    <select class="form-control" id="dealerefris" name="supervisor" required>
                        <option value="">Supervisor</option>
                        @foreach($users as $user)
                            <option  value="{{ $user->id }}">{{ $user->username }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group text-right">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
