<div class="modal fade" id="adduser" tabindex="-1" aria-labelledby="adduserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="adduserModalLabel">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('dealer.user.store') }}">
            @csrf
            <!-- Row 1: User Type and Target -->
            <div class="row g-3">
              <div class="col-md-6">
                <label for="userType" class="form-label">User Type</label>
                <select id="userType"  required class="form-control" name="type">
                  <option selected value="">Select user type</option>
                  <option value="admin">Admin</option>
                  <option value="sales">Sales</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="userTarget" class="form-label">Target Type</label>
                <select id="userTarget" required class="form-control" name="target">
                  <option selected value="">Select user target type</option>
                  <option value="month">Monthly</option>
                  <option value="sku">SKU</option>
                </select>
              </div>
            </div>
            <!-- Row 2: Username and Phone -->
            <div class="row g-3 mt-3">
              <div class="col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-control" name="username" placeholder="User Name">
              </div>
              <div class="col-md-6">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" class="form-control" name="phone" placeholder="Phone Number">
              </div>
            </div>
            <!-- Row 3: Password and Van -->
            <div class="row g-3 mt-3">
              <div class="col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" class="form-control" name="password" placeholder="Password">
              </div>
              <div class="col-md-6">
                <label for="van" class="form-label">Van</label>
                <select id="van"  required class="form-control" name="van">
                  <option value="" selected>Select Van</option>
                  @foreach ($vans as $van)
                  <option value="{{ $van->id }}">{{ $van->name }} {{ $van->reg_id }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <!-- Row 4: Status and Branch -->
            <div class="row g-3 mt-3">
              <div class="col-md-6">
                <label for="status" class="form-label">User Status</label>
                <select id="status"  required class="form-control" name="status">
                  <option selected>Select user status</option>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
              {{-- <div class="col-md-6">
                <label for="branch" class="form-label">Branch</label>
                <select id="branch" class="form-control" name="branch_id">
                  @foreach ($branches as $branch)
                  <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                  @endforeach
                </select>
              </div> --}}
            </div>
            <!-- Row 5: Roles -->
            <div class="row g-3 mt-3">
              <div class="col-md-12">
                <label for="roles" class="form-label">Roles</label>
                <select id="roles" class="form-control select2" name="roles[]" multiple>
                  <option value="" disabled>Choose user roles (ignore if sales person)</option>
                  @foreach ($roles as $role)
                  <option value="{{ $role->id }}">{{ $role->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <!-- Submit Button -->
            <div class="mt-4 d-flex justify-content-end">
              <button type="submit" class="btn btn-success">Save</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
