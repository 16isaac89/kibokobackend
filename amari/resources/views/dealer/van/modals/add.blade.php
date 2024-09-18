<div class="modal fade" id="addvan" tabindex="-1" role="dialog" aria-labelledby="addvanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ADD VAN</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('vans.store')}}">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Van Name </label>
                  <input type="text" class="form-control" name="vanname"  placeholder="Van Name">

                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Registration</label>
                  <input type="text" class="form-control" name="reg_id" placeholder="Registration ID eg UBL 125G">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Select Branch</label>
                    <select class="form-control" name="branch">
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                       @endforeach
                      </select>
                  </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>
