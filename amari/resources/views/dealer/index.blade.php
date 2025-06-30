@extends('layouts.dealer')
@section('content')
<div class="am-pagebody" style="padding: 20px; background-color: #f8f9fa;">
    @if($efris === 1)
    <button onclick="updateaes()" class="btn btn-success m-1" style="background-color: #28a745; border-color: #28a745; border-radius: 4px; padding: 8px 16px;">
        Last Update <span id="updated">{{$updatedat}}</span>
    </button>
    @endif
    <div class="row" style="margin-left: -15px; margin-right: -15px;">
        <div class="col-lg-4" style="padding: 15px;">
            <div class="card" style="border: none; border-radius: 8px; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); overflow: hidden;">
                <div id="rs1" style="width: 100%; height: 200px; background-color: #f8f9fa;"></div>
                <div style="padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <div>
                            <h6 style="font-size: 12px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 5px;">Customers</h6>
                        </div>
                        <a href="" style="color: #6c757d;"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <h2 style="font-size: 28px; font-weight: 600; color: #343a40; margin-bottom: 5px;">{{$customers}}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4" style="padding: 15px;">
            <div class="card" style="border: none; border-radius: 8px; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); overflow: hidden;">
                <div id="rs2" style="width: 100%; height: 200px; background-color: #f8f9fa;"></div>
                <div style="padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <div>
                            <h6 style="font-size: 12px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 5px;">Vans</h6>
                        </div>
                        <a href="" style="color: #6c757d;"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <h2 style="font-size: 28px; font-weight: 600; color: #343a40; margin-bottom: 5px;">{{$vans}}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4" style="padding: 15px;">
            <div class="card" style="border: none; border-radius: 8px; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); overflow: hidden;">
                <div id="rs3" style="width: 100%; height: 200px; background-color: #f8f9fa;"></div>
                <div style="padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <div>
                            <h6 style="font-size: 12px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 5px;">Routes</h6>
                        </div>
                        <a href="" style="color: #6c757d;"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <h2 style="font-size: 28px; font-weight: 600; color: #343a40; margin-bottom: 5px;">{{$routes}}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row" style="margin-top: 20px; margin-left: -15px; margin-right: -15px;">
        <div class="col-md-6" style="padding: 15px;">
            <div class="card" style="border: none; border-radius: 8px; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); padding: 20px;">
                <h6 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Bar Chart</h6>
                <div style="height: 500px;">
                    <canvas id="myBarChart" height="400" width="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="padding: 15px;">
            <div class="card" style="border: none; border-radius: 8px; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); padding: 20px;">
                <h6 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Line Chart</h6>
                <div style="height: 500px;">
                    <canvas id="myLineChart" height="400" width="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="row" style="margin-top: 20px; margin-left: -15px; margin-right: -15px;">
        <div class="col-lg-12" style="padding: 15px;">
            <div class="card" style="border: none; border-radius: 8px; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                <div style="padding: 20px; background-color: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                    <h6 style="font-size: 12px; text-transform: uppercase; font-weight: 600; margin-bottom: 0;">Latest 10 Orders</h6>
                </div>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; margin-bottom: 0; color: #212529;">
                        <thead>
                            <tr>
                                <th style="padding: 12px; font-weight: 600; width: 15%;">Route</th>
                                <th style="padding: 12px; font-weight: 600; width: 15%;">Van</th>
                                <th style="padding: 12px; font-weight: 600; width: 20%;">Customer</th>
                                <th style="padding: 12px; font-weight: 600; width: 20%;">Amount</th>
                                <th style="padding: 12px; font-weight: 600; width: 20%;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latests as $order)
                            <tr style="border-top: 1px solid #dee2e6;">
                                <td style="padding: 12px; text-align: center;">{{$order->route->name ?? ''}}</td>
                                <td style="padding: 12px;">{{$order->van?->name}}</td>
                                <td style="padding: 12px; font-size: 12px;">{{$order->customer?->name ?? ''}}</td>
                                <td style="padding: 12px; font-size: 12px;">{{$order->total}}</td>
                                <td style="padding: 12px;">{{$order->created_at ?? ''}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="padding: 15px; background-color: transparent; border-top: 1px solid rgba(0, 0, 0, 0.05); font-size: 12px;">
                    <a href="" style="color: #6c757d;"><i class="fas fa-angle-down" style="margin-right: 5px;"></i>View All Transaction History</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="activityindicator" tabindex="-1" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: transparent; border: none;">
            <div style="display: flex; justify-content: center;">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript">
    var labelss = @json($barlabels);
    var orders = @json($bardata);
    var linelabels = @json($linelabels);
    var lineorders = @json($linedata);

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

    function updateaes(){
        $('#activityindicator').modal('show');
        let token = "{{ csrf_token()}}";
        let id = "{{ $dealer }}"
        $.ajax({
            type: 'POST',
            url: "{{route('partner.get.efriskey')}}",
            dataType: 'json',
            data:{id,_token:token,},
            success: function (data) {
                console.log(data);
                $('#activityindicator').modal('hide');
                document.getElementById("updated").innerHTML=data.date;
            },
            error:function(data){
                console.log(data);
                $('#activityindicator').modal('hide');
            }
        });
    }
</script>
@endsection
