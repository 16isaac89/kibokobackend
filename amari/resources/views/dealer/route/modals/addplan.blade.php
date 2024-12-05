<div class="modal fade" id="addplanModal" tabindex="-1" role="dialog" aria-labelledby="addplanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addplanModalLabel">Add Plan For <b id="dealerusername"></b></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" action="{{route('routeplans.store')}}">
                @csrf
                <input type="hidden" name="van" id="van" value="{{$van->id}}">
                <input type="hidden" name="user" id="user">
                <input type="hidden" name="week" id="week">
                <input type="hidden" name="day" id="day">

                <div class="modal-body">
                    <div class="form-row align-items-center mb-3">
                        <div class="col-md-6">
                            <label for="route" class="font-weight-bold">Route</label>
                            <select class="custom-select" id="route" name="route" onchange="handleSelectChange(event)">
                                <option selected disabled>Choose route</option>
                                @foreach ($routes as $route)
                                <option value="{{$route->code}}">{{$route->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button type="button" class="btn btn-outline-primary" onclick="selectallcusts(this)">
                            Select All Customers
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="deselectallcusts(this)">
                            Deselect All
                        </button>
                    </div>

                    <div id="customers_div" class="p-3 border rounded" style="max-height: 300px; overflow-y: auto;">
                        <!-- Customer list will be dynamically injected here -->
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
