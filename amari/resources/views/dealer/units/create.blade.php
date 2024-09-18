@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card ">


        <form method="POST" action="{{ route("productunits.store") }}">
            @csrf

<div class="col-12">
    <div class="row" style="margin:10px;">
      <div class="col-6">
        <input type="text" name="name" id="unitname" required class="form-control" placeholder="Unit Name">
      </div>
      <div class="col-6">
        <input type="text" name="short_name" required class="form-control" placeholder="Short Name">
      </div>
      <div class="col-6" style="margin:10px;">
        <b>Allow Decimals</b>
        <div class="row">
            <b><span>No</span></b>
          <input type="radio" name="allow_decimal" value="0" checked  >
        </div>
        <div class="row">
            <b><span>Yes</span></b>
          <input type="radio" name="allow_decimal" value="1" >
        </div>
      </div>
      <div class="col-6">
        <input type="checkbox" name="asmultiple" id="asmultiple" onchange="checkCheckbox()">
        <b>Add as multiple of other unit </b>
    </div>
    <div class="col-12" id="multiplierdiv" style="visibility:hidden;">
        <div class="row">
            <div class="col-4">
        <h5><b id="addedunit"></b></h5>
    </div>
        <div class="col-4">
        <input type="text" name="multiplier" required class="form-control" placeholder="Quantity">
    </div>
        <div class="col-4">
        <select class="form-control" aria-label="Default select example" name="base_unit">
            <option selected>Select Unit</option>
            @foreach ($units as $unit)
            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
            @endforeach
          </select>
        </div>


        </div>
      </div>
    </div>




    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
        </div>
      </div>





@endsection
@section('scripts')
    <script>
$("#unitname").on('change keydown paste input', function(){
    let unitname = document.getElementById('unitname').value
    let txtstring = "1  "+unitname+'='
     document.getElementById('addedunit').innerHTML = txtstring
});

function checkCheckbox(){
    var x=$("#asmultiple").is(":checked");
    if(x === true){
        document.getElementById("multiplierdiv").style.visibility = 'visible'
    }else{
        document.getElementById("multiplierdiv").style.visibility = 'hidden'
    }

    console.log(x)
}
//  $(document).ready(function(){
//      var data=$('input[name=allow_decimal]:checked').map(function(err, el) {
//       			return $(el).val();
//   			}).get();
//      alert(data)
// });
    </script>
@endsection

