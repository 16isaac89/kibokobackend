
@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    @if($efris === 1)
    <button onclick="updateaes()" class="btn btn-success m-1">Last Update <span id="updated">{{$updatedat}}</span></button>
    @endif
    <div class="row row-sm">
      <div class="col-lg-4">
        <div class="card">



          <div id="rs1" class="wd-100p ht-200"></div>
          <div class="overlay-body pd-x-20 pd-t-20">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-5">Customers</h6>

              </div>
              <a href="" class="tx-gray-600 hover-info"><i class="icon ion-more tx-16 lh-0"></i></a>
            </div><!-- d-flex -->
            <h2 class="mg-b-5 tx-inverse tx-lato">{{$customers}}</h2>

          </div>
        </div><!-- card -->
      </div><!-- col-4 -->
      <div class="col-lg-4 mg-t-15 mg-sm-t-20 mg-lg-t-0">
        <div class="card">
          <div id="rs2" class="wd-100p ht-200"></div>
          <div class="overlay-body pd-x-20 pd-t-20">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-5">Vans</h6>

              </div>
              <a href="" class="tx-gray-600 hover-info"><i class="icon ion-more tx-16 lh-0"></i></a>
            </div><!-- d-flex -->
            <h2 class="mg-b-5 tx-inverse tx-lato">{{$vans}}</h2>

          </div>
        </div><!-- card -->
      </div><!-- col-4 -->
      <div class="col-lg-4 mg-t-15 mg-sm-t-20 mg-lg-t-0">
        <div class="card">
          <div id="rs3" class="wd-100p ht-200"></div>
          <div class="overlay-body pd-x-20 pd-t-20">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-5">Routes</h6>

              </div>
              <a href="" class="tx-gray-600 hover-info"><i class="icon ion-more tx-16 lh-0"></i></a>
            </div><!-- d-flex -->
            <h2 class="mg-b-5 tx-inverse tx-lato">{{$routes}}</h2>

          </div>
        </div><!-- card -->
      </div><!-- col-4 -->
    </div>






    <!-- row -->

         <div class="row row-sm mg-t-15 mg-sm-t-20">
          <div class="col-md-6">
            <div class="card pd-20 pd-sm-40">
              <h6 class="card-body-title">Bar Chart</h6>
             <div class="ht-500">
             <canvas id="myBarChart" height="400px" width="400px"></canvas>
             </div>
            </div><!-- card -->
          </div><!-- col-6 -->
          <div class="col-md-6 mg-t-15 mg-sm-t-20 mg-md-t-0">
            <div class="card pd-20 pd-sm-40">
              <h6 class="card-body-title">Line Chart</h6>
              <div class="ht-500">
              <canvas id="myLineChart" height="400px" width="400px"></canvas>
              </div>
            </div><!-- card -->
          </div><!-- col-6 -->
        </div><!-- row -->

        <div class="row row-sm mg-t-15 mg-sm-t-20">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header bg-transparent pd-20">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Latest 10 Orders</h6>
              </div><!-- card-header -->
              <div class="table-responsive">
                <table class="table table-white mg-b-0 tx-12">
                <thead>
                <tr>
                  <th class="wd-15p">Route</th>
                  <th class="wd-15p">Van</th>
                  <th class="wd-20p">Customer</th>
                  <th class="wd-20p">Amount</th>
                  <th class="wd-20p">Date</th>
                </tr>
                </thead>
                  <tbody>
                  @foreach($latests as $order)
                    <tr>
                      <td class="pd-l-20 tx-center">
                        {{$order->route->name ?? ''}}
                      </td>
                      <td>
                       {{$order->van->name}}
                      </td>
                      <td class="tx-12">
                       {{$order->customer->name ??  ''}}
                      </td>
                      <td class="tx-12">
                        {{$order->total}}
                       </td>
                      <td>{{$order->created_at ?? ''}}</td>
                    </tr>
                       @endforeach
                  </tbody>
                </table>
              </div><!-- table-responsive -->
              <div class="card-footer tx-12 pd-y-15 bg-transparent bd-t bd-gray-200">
                <a href=""><i class="fa fa-angle-down mg-r-5"></i>View All Transaction History</a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div><!-- col-8 -->

        </div><!-- row -->



      </div><!-- col-4 -->
    </div><!-- row -->
    @endsection
    @section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script type="text/javascript">
 var labelss =  @json( $barlabels);
 var orders =  @json($bardata);
 var linelabels =  @json($linelabels);
 var lineorders =  @json($linedata);

  var ctx = document.getElementById("myBarChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labelss,
        datasets: [{
            label: '# of Orders',
            data: orders,
            backgroundColor: '#32CD32',
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
var ctx2 = document.getElementById("myLineChart").getContext('2d');
var myChart = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: linelabels,
        datasets: [{
            label: 'Money',
            data: lineorders,
            backgroundColor: '#32CD32',
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


</script>
<script>
    function updateaes(){
      $('.activityindicator').modal('show');
      let token = "{{ csrf_token()}}";
      let id = "{{ $dealer }}"
      $.ajax({
          type: 'POST', //THIS NEEDS TO BE GET
          url: "{{route("partner.get.efriskey")}}",
          dataType: 'json',
          data:{id,_token:token,},
          success: function (data) {
            console.log(data)
//let date = data.date.toISOString().replace(/^([^T]+)T([^\.]+)(.+)/, "$1 $2")
            $('.activityindicator').modal('hide');
            document.getElementById("updated").innerHTML=data.date;
          },error:function(data){
               console.log(data);
               $('.activityindicator').modal('hide');
          }
      });


    }
    </script>

    @endsection
