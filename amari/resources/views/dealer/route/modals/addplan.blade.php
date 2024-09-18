<div class="modal fade" id="addplanModal" tabindex="-1" role="dialog" aria-labelledby="addplanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addplanModalLabel">ADD Plan For <b id="dealerusername"></b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{route('routeplans.store')}}">
            @csrf
            <input type="hidden" name="van" value = "{{$van->id}}">
            <input type="hidden" name="user" id="user">

            <input type="hidden" name="week" id="week">
            <input type="hidden" name="day" id="day">

        <div class="modal-body">
            <div class="form-row align-items-center">
                <div class="col-6">
                  <label class="mr-sm-2" for="inlineFormCustomSelect">Route</label>
                  <select class="custom-select mr-sm-2" id="route" name="route" onchange="handleSelectChange(event)">
                    <option selected>Choose route</option>
                    @foreach ($routes as $route)
                    <option value="{{$route->id}}">{{$route->name}}</option>
                    @endforeach
                  </select>
                </div>
                <!-- <div class="col-6">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Date</label>
                    <input type="text" id="datetime" name="date" class="form-control">
                  </div> -->
            </div>
            <div class="row">
            <a class="btn btn-light" onclick="selectallcusts(this)">Select All</a>
            <a class="btn btn-warning" onclick="deselectallcusts(this)">DeSelect All</a>
</div>
            <div id="customers_div" style="margin:10px;">
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