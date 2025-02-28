<div class="modal fade" id="addcustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomerTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerTitle">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="efrisstatus">Registered</label>
                            <select class="form-control" id="efrisstatus">
                                <option>Choose...</option>
                                <option value="1">Registered</option>
                                <option value="2">Unregistered</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tin">TIN</label>
                            <input type="text" class="form-control" id="tin">
                        </div>
                        <div class="form-group col-md-3 mt-3 d-flex align-items-end">
                            <img src="{{ asset('/images/loader.gif') }}" style="width:60px;height:60px;display:none;" id="loader">
                            <button type="button" class="btn btn-warning ml-2" onclick="checkregistration()" id="getbtn">Get Info</button>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Name or Business name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" placeholder="Phone number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Apartment, studio, or floor">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email Address">
                    </div>

                    <div class="form-group">
                        <label for="buyertype">Buyer Type</label>
                        <select class="form-control" id="buyertype" required>
                            <option value="0">Business/Gov</option>
                            <option value="1">Individual</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="route">Route</label>
                        <select class="form-control" id="route" required>
                            @foreach($routes as $route)
                                <option value="{{ $route->id }}">{{ $route->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category">Customer Category</label>
                        <select class="form-control" id="category" required>
                            <option selected value="">Choose customer category ...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="addcustomer()" class="btn btn-primary" id="savecustomer">Save changes</button>
                <img src="{{ asset('images/loader.gif') }}" id="savingcustomer" style="width:50px;height:50px;display:none;" class="ml-2">
            </div>
        </div>
    </div>
</div>
