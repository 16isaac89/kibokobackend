@extends('layouts.customer')

@section('css')
<link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
@endsection

@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">Dashboard</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
                            href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Dashboard</li>
                </ol>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="row state-overview">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="info-box bg-b-purple">
                            <span class="info-box-icon push-bottom"><i
                                    class="material-icons">group</i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Booked Trips</span>
                                <span class="info-box-number">{{$myorders}}</span>
                                <div class="progress">
                                    <div class="progress-bar width-60"></div>
                                </div>
                                <span class="progress-description">
                                    60% Increase in 28 Days
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="info-box bg-b-green">
                            <span class="info-box-icon push-bottom"><i
                                    class="material-icons">person</i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Cancelled Trip</span>
                                <span class="info-box-number">155</span>
                                <div class="progress">
                                    <div class="progress-bar width-40"></div>
                                </div>
                                <span class="progress-description">
                                    40% Increase in 28 Days
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- chart start -->

        <!-- Chart end -->
        <!-- start Payment Details -->
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card  card-box">
                    <div class="card-head">
                        <header>Booking History</header>
                        <div class="tools">
                            <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="table-wrap">
                            <div class="table-responsive tblDriverDetail">
                                <table class="table display product-overview mb-30" id="bookings">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Booked on</th>
                                            <th>Travel Date</th>
                                            <th>Status</th>
                                            <th>Ppayment Method</th>

                                        </tr>
                                    </thead>
                                    <tbody>




                                    @if(count($orders)<0)
                                    <tr><td>You havent made any bookings.</td></tr>
                                    @else
                                    @foreach ($orders as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->from}}</td>
                                        <td>{{$item->to}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->date}}</td>
                                        <td>
                                            <span class="label label-sm box-shadow-1 label-success">
                                                {{$item->status}}
                                            </span>
                                        </td>

                                        <td>{{\App\Models\PaymentMethod::find($item->paymentmethod_id) || 'null'}}</td>
                                        <td>
                                            <a href="#" class="btn btn-tbl-edit btn-xs">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="{{ route('customer.gen.receipt', $item->id) }}" class="btn btn-tbl-edit btn-xs">
                                                <i class="fa fa-money"></i>
                                            </a>
                                            <button class="btn btn-tbl-delete btn-xs">
                                                <i class="fa fa-trash-o "></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif


                                    </tbody>

                                </table>
                                {{ $orders->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- end Payment Details -->

    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready( function () {
        $('#bookings').DataTable();
    } );
    </script>
@endsection
