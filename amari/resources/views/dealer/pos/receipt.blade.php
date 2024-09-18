@extends('layouts.dealer')
@section('styles')
<style>
        body {
            margin: 25mm 25mm 25mm 25mm;
            padding: 0;
            font-family: 'PT Sans', sans-serif;
        }

        @page {
            size: 2.8in 11in;
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
        }

        table {
            width: 60%;
        }

        tr {
            width: 100%;

        }

        h1 {
            text-align: center;
            vertical-align: middle;
        }

        header {
            width: 100%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            vertical-align: middle;
        }

        .items thead {
            text-align: center;
        }

        .center-align {
            text-align: center;
        }

        .bill-details td {
            font-size: 12px;
        }

        .receipt {
            font-size: medium;
        }

        .items .heading {
            font-size: 12.5px;
            text-transform: uppercase;
            border-top:1px solid black;
            margin-bottom: 4px;
            border-bottom: 1px solid black;
            vertical-align: middle;
        }

        .items thead tr th:first-child,
        .items tbody tr td:first-child {
            width: 47%;
            min-width: 47%;
            max-width: 47%;
            word-break: break-all;
            text-align: left;
        }

        .items td {
            font-size: 12px;
            text-align: right;
            vertical-align: bottom;
        }

        .price::before {
             
            font-family: Arial;
            text-align: right;
        }

        .sum-up {
            text-align: right !important;
        }
        .total {
            font-size: 13px;
            border-top:1px dashed black !important;
            border-bottom:1px dashed black !important;
        }
        .total.text, .total.price {
            text-align: right;
        }
        
        .line {
            border-top:1px solid black !important;
        }
        .heading.rate {
            width: 20%;
        }
        .heading.amount {
            width: 25%;
        }
        .heading.qty {
            width: 5%
        }
        p {
            padding: 1px;
            margin: 0;
        }
        section, footer {
            font-size: 12px;
        }
        @media print 
{
    @page {
      size: A4; /* DIN A4 standard, Europe */
      margin:0;
    }
    html, body {
        width: 210mm;
        /* height: 297mm; */
        height: 282mm;
        font-size: 11px;
        background: #FFF;
        overflow:visible;
    }
    body {
        padding-top:15mm;
    }
}
    </style>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
       RECEIPT
    </div>


    <div class="card-body">

<div id="DivIdToPrint">

<center><p>{{$dealerefris->tradename}}</p>
<p>Address: {{$dealerefris->address}}</p>
<p>Phone: {{$dealerefris->phonenumber}}</p>
<p>TIN: {{$dealerefris->tin}}</p>
<p>Receipt: {{$receiptno}}</p>
<p>Date: {{$created}}</p>
</center>
<center>
    <table class="items">
        <thead>
            <tr>
                <th class="heading name" style="text-align: center">Item</th>
                <th class="heading qty" style="text-align: center">Qty</th>
                <th class="heading rate" style="text-align: center">Rate</th>
                <th class="heading rate" style="text-align: center">Disc</th>
            </tr>
        </thead>
       
        <tbody>
            @foreach($goodsdetails as $goodsdetail)
            @if(strpos($goodsdetail->item, '(Discount)'))
            @continue
            @else
            <tr>
                <td style="text-align: center">{{$goodsdetail->item}}</td>
                <td style="text-align: center">{{$goodsdetail->qty}}</td>
                <td class="price" style="text-align: center">{{($goodsdetail->qty*$goodsdetail->unitPrice)-intval($goodsdetail->discountTotal)}}</td>
                <td class="price" style="text-align: center">{{$goodsdetail->discountTotal ?? 0}}</td>
                
            </tr>
            @endif
            @endforeach
         
        </tbody>
    </table>
    <div class="col-xs-6 text-left ">
        <address>
            <strong>Summary</strong><br>
            <strong>Tax(18%):</strong>{{ $tax }}UGX<br>
            <strong>Net:</strong>{{ $net }}UGX<br>
            <strong>Total:</strong>{{$gross}}UGX<br>

        </address>
    </div><br><br>
    <div class="col-xs-6 text-left ">
        <address>
            <strong>Customer:</strong><br>
            <strong>Name:</strong>{{ $customer->tin ? $customer->legalName : $customer->name }}<br>
            <strong>Phone:</strong>{{ $customer->tin ? $customer->contactMobile  : $customer->phone }},<br>
            <strong>TIN:</strong>{{ $customer->tin ? $customer->tin : $customer->tin }},<br>
            <strong>Address:</strong>{{  $customer->address }},<br>
        </address>
    </div><br><br>

    <p>FDN:<strong>{{ $sale->efrisdoc->fdn }}</strong></p>
    <p>Ver Code:<strong>{{ $sale->efrisdoc->invoiceid }}</strong></p>
    <section>
        <div id="qrcode"></div>
        <p>Powered By Exquisite Digital Systems 256701831705/788924134</p>
    </section>
</center>
   
    
    </div>
<input type='button' id='btn' value='Print' onclick='printDiv();'>
    </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script type="text/javascript">
  function printDiv() {
    var divToPrint = document.getElementById('DivIdToPrint');
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
    newWin.document.close();
    setTimeout(function() {
      newWin.close();
    }, 10);
  }

</script>
<script>
    window.onload = function(){
        var qrcode = new QRCode("qrcode", {
    text: '{{$qrcode}}',
    width: 128,
    height: 128,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
});
    }
    </script>

@endsection