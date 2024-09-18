@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card ">


        <form method="POST" action="{{ route("productunits.update",['productunit'=>$unit->id]) }}">
        @method('PUT')
            @csrf

<div class="col-12">
    <div class="row" style="margin:10px;">
      <div class="col-6">
        <input type="text" value="{{ $unit->name }}" name="name" id="unitname" required class="form-control" placeholder="Unit Name">
      </div>
      <div class="col-6">
        <input type="text" value="{{ $unit->shortname }}"  name="short_name" required class="form-control" placeholder="Short Name">
      </div>
      <div class="col-6" style="margin:10px;">
        <b>Allow Decimals</b>
        <div class="row">
            <b><span>No</span></b>
          <input type="radio"  name="allow_decimal" value="0" {{ $unit->allow_decimal === '0' || $unit->allow_decimal === 0 ? 'checked' :'' }}   >
        </div>
        <div class="row">
            <b><span>Yes</span></b>
          <input type="radio" name="allow_decimal" value="1" {{ $unit->allow_decimal === '1' || $unit->allow_decimal === 1 ? 'checked' :'' }} >
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
    <script>
        window.onload = function(){
            var x=$("#asmultiple").is(":checked");

    if(x === true){
        document.getElementById("multiplierdiv").style.visibility = 'visible'
    }else{
        document.getElementById("multiplierdiv").style.visibility = 'hidden'
    }
        }
    </script>
@endsection

