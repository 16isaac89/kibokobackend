@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
@include('dealer.route.modals.addplan',['routes'=>$routes])
    <div class="card pd-20 pd-sm-40">
      <h6 class="card-body-title">Add Route Plans For Sales People</h6>
      <div class="table-wrapper">
        @foreach ($van->dealerusers as $vanuser)
        <button type="button" style="margin:10px;" class="btn btn-success">{{$vanuser->username}}  {{$van->name}}</button>
  <div class="table-responsive">
  <table class="table" id="RoutePlanListtable-{{$vanuser->id}}">
  <thead>
    <tr>
      <th scope="col" style="text-align:center;">Week 1</th>
      <th scope="col" style="text-align:center;">Week 2</th>
      <th scope="col" style="text-align:center;">Week 3</th>
      <th scope="col" style="text-align:center;">Week 4</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td data-wk="1" data-day="0" style="text-align:center;">
      <a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal" data-wk="1" data-day="0">
        <b>Sun 1 ({{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>1,'day'=>0])->get())
        }})</b></a></td>
      <td data-wk="2" data-day="0" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="2" data-day="0"><b>Sun 2 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>2,'day'=>0])->get())
        }}
        )</b></a></td>
      <td data-wk="3" data-day="0" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="3" data-day="0"><b>Sun 3 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>3,'day'=>0])->get())
        }}
        )</b></a></td>
      <td data-wk="4" data-day="0" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="4" data-day="0"><b>Sun 4 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>4,'day'=>0])->get())
        }}
        )</b></a></td>
    </tr>
    <tr>
      <td data-wk="1" data-day="1" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="1" data-day="1"><b>Mon 1 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>1,'day'=>1])->get())
        }}
        )</b></a></td>
      <td data-wk="2" data-day="1" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="2" data-day="1"><b>Mon 2 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>2,'day'=>1])->get())
        }}
        )</b></a></td>
      <td data-wk="3" data-day="1" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="3" data-day="1"><b>Mon 3 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>3,'day'=>1])->get())
        }}
        )</b></a></td>
      <td data-wk="4" data-day="1" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="4" data-day="1"><b>Mon 4 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>4,'day'=>1])->get())
        }}
        )</b></a></td>
    </tr>

<!-- day 2 -->
    <tr>
      <td data-wk="1" data-day="2" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="1" data-day="2"><b>Tue 1 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>1,'day'=>2])->get())
        }}
        )</b></a></td>
      <td data-wk="2" data-day="2" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="2" data-day="2"><b>Tue 2 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>2,'day'=>2])->get())
        }}
        )</b></a></td>
      <td data-wk="3" data-day="2" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="3" data-day="2"><b>Tue 3 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>3,'day'=>2])->get())
        }}
        )</b></a></td>
      <td data-wk="4" data-day="2" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="4" data-day="2"><b>Tue 4 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>4,'day'=>2])->get())
        }}
        )</b></a></td>
    </tr>






<!-- Day 3 -->
    <tr>
      <td data-wk="1" data-day="3" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="1" data-day="3"><b>Wed 1 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>1,'day'=>3])->get())
        }}
        )</b></a></td>
      <td data-wk="2" data-day="3" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="2" data-day="3"><b>Wed 2 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>2,'day'=>3])->get())
        }}
        )</b></a></td>
      <td data-wk="3" data-day="3" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"   data-wk="3" data-day="3"><b>Wed 3 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>3,'day'=>3])->get())
        }}
        )</b></a></td>
      <td data-wk="4" data-day="3" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"   data-wk="4" data-day="3"><b>Wed 4 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>4,'day'=>3])->get())
        }}
        )</b></a></td>
    </tr>





<!-- day 4 -->
    <tr>
      <td data-wk="1" data-day="4" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="1" data-day="4"><b>Thu 1 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>1,'day'=>4])->get())
        }}
        )</b></a></td>
      <td data-wk="2" data-day="4" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="2" data-day="4"><b>Thu 2 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>2,'day'=>4])->get())
        }}
        )</b></a></td>
      <td data-wk="3" data-day="4" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="3" data-day="4"><b>Thu 3 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>3,'day'=>4])->get())
        }}
        )</b></a></td>
      <td data-wk="4" data-day="4" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="4" data-day="4"><b>Thu 4 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>4,'day'=>4])->get())
        }}
        )</b></a></td>
    </tr>



<!-- day 5 -->
    <tr>
      <td data-wk="1" data-day="5" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="1" data-day="5"><b>Fri 1 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>1,'day'=>5])->get())
        }}
        )</b></a></td>
      <td data-wk="2" data-day="5" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="2" data-day="5"><b>Fri 2 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>2,'day'=>5])->get())
        }}
        )</b></a></td>
      <td data-wk="3" data-day="5" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="3" data-day="5"><b>Fri 3 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>3,'day'=>5])->get())
        }}
        )</b></a></td>
      <td data-wk="4" data-day="5" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="4" data-day="5"><b>Fri 4 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>4,'day'=>5])->get())
        }}
        )</b></a></td>
    </tr>




<!-- day 6 -->
    <tr>
      <td data-wk="1" data-day="6" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="1" data-day="6"><b>Sat 1 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>1,'day'=>6])->get())
        }}
        )</b></a></td>
      <td data-wk="2" data-day="6" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="2" data-day="6"><b>Sat 2 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>2,'day'=>6])->get())
        }}
        )</b></a></td>
      <td data-wk="3" data-day="6" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="3" data-day="6"><b>Sat 3 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>3,'day'=>6])->get())
        }}
        )</b></a></td>
      <td data-wk="4" data-day="6" style="text-align:center;"><a class="btn btn-light" data-van="{{$van->id}}" data-user="{{$vanuser->id}}" data-name="{{$vanuser->username}}" data-toggle="modal" data-target="#addplanModal"  data-wk="4" data-day="6"><b>Sat 4 (
        {{
          count(\App\Models\RoutePlanList::where(['dealer_user_id'=>$vanuser->id,'week'=>4,'day'=>6])->get())
        }}
        )</b></a></td>
    </tr>
    
  </tbody>
</table>
</div>
        @endforeach
      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->
 
@endsection
@section('scripts')
{{-- <script>
   (function() {
    $('#routes').DataTable({
        dom: 'Bfrtip',
    buttons: [
        'colvis',
        'excel',
        'print',
        'copy', 'pdf','csv'
    ],
        responsive: true,
        language: {
          searchPlaceholder: 'Search...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        },
   
      });
})();
    </script> --}}
    <script>
        function handleSelectChange(event) {

var selectElement = event.target;
var value = selectElement.value;
$.ajax({
    url: "{{route('route.customers')}}",
    data: { 
        "route":value,
        "_token":"{{ csrf_token() }}"
    },
    cache: false,
    method: "GET",
    success: function(response) {
        let data = response.customers
        document.getElementById('customers_div').innerHTML = ""
        var span = document.createElement('span');
        span.style.color = 'black';
        let textNode = document.createTextNode("Select Customer"+"\r\n");
        span.appendChild(textNode);
        $('#customers_div').append(span)
        $('#customers_div').append(document.createElement("br"));
        data.forEach( function (obj){
        $('#customers_div').append('<input name="customer[]" type="checkbox" value="'+obj.id+'"/> '+obj.name +'<br/>');
    });

    },
    error: function(error) {
        console.log(error)
    }
});
}

$('#addplanModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var userid = button.data('user') // Extract info from data-* attributes
  var username = button.data('name') // Extract info from data-* attributes
  var wk = button.data('wk')
  var day = button.data('day')
  console.log(wk,day)
  document.getElementById('user').value = userid
  document.getElementById('week').value = wk
  document.getElementById('day').value = day
  document.getElementById('dealerusername').innerHTML = username;
})
    </script>
    <script>
       (function() {
  $('#datetime').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    locale: 'en',
    sideBySide: true,
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })
})();
        </script>

        <script>
          document.addEventListener("DOMContentLoaded", function(){
const d = new Date();
const date = d.getDate();
const day = d.getDay();
const users = @json($van->dealerusers);
console.log(users)
//const weekOfMonth = Math.ceil((date - 1 - day) / 7);
const dayOfWeekDigit = new Date().getDay();


var todayDate = new Date().toISOString().slice(0, 10);

function getWeekNumber(date) {
  var monthStartDate = new Date(new Date().getFullYear(), new Date().getMonth(), 1);
  monthStartDate = new Date(monthStartDate);
  var day = monthStartDate.getDay();
  // date = new Date(date);
  // var date = date.getDate();
  // let weekNumber = Math.ceil((date + (day)) / 7);
var d = new Date();
var date = d.getDate();
var day = d.getDay();
var weekNumber = Math.ceil((date - 1 - day) / 7);
  return (weekNumber == 0) ? 1 : weekNumber;
}

var weekOfMonth = getWeekNumber(todayDate);


users.forEach((item)=>{
  var table = document.getElementById("RoutePlanListtable-"+item.id);
let cells = table.querySelectorAll('td');
cells.forEach( (cell) => {
if(cell.dataset.wk == weekOfMonth && cell.dataset.day == dayOfWeekDigit){
  console.log('gh')
  cell.style.backgroundColor = "yellow"
}else{
  console.log('gh444')
}
});
})

          });
          </script>
          <script>
            function selectallcusts(source){
              let checkboxes = document.getElementsByName('customer[]');
              console.log(checkboxes[0].checked)
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = true;
  }
            }
            function deselectallcusts(source){
              let checkboxes = document.getElementsByName('customer[]');
              console.log(checkboxes[0].checked)
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = false;
  }
            }
            </script>

@endsection