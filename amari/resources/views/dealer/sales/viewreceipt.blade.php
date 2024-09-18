@extends('layouts.dealer')
@section('styles')
    <style>

    </style>
@endsection
@section('content')
    <div class="am-pagebody">




        <div class="card pd-5 pd-sm-20">
            <div class="container">
                <button class="btn btn-success" onclick="generatepdf()">PDF</button>
                <!-- BEGIN INVOICE -->
                <div class="col-xs-12 receipt" id='receipt'>
                    <div class="grid invoice">
                        <div class="grid-body">
                            <div class="invoice-title">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <img src="http://vergo-kertas.herokuapp.com/assets/img/logo.png" alt=""
                                            height="35">
                                    </div>
                                </div>
                                <br>

                                <div class="col-xs-6 text-center ">
                                    <h3><b>{{ $dealer->tradename }}</b></h3>
                                </div>

                            </div>
                            <hr>

                            <div class="col-xs-6">
                                <address>
                                    <strong>Address:{{ $dealer->address }}</strong><br>
                                    <strong>Phone:{{ $dealer->phonenumber }}</strong><br>
                                    <strong>TIN:{{ $dealer->tin }}</strong><br>
                                    <strong>Receipt/INV No:{{ $sale->id }}</strong><br>
                                    <strong>Date:{{ $sale->created_at }}</strong><br>
                                </address>
                            </div>



                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <h3>ORDER SUMMARY</h3>
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr class="line">
                                                <td><strong>#</strong></td>
                                                <td class="text-center"><strong>Item</strong></td>
                                                <td class="text-center"><strong>Qty</strong></td>
                                                <td class="text-right"><strong>Price</strong></td>
                                                <td class="text-right"><strong>Discount</strong></td>
                                                <td class="text-right"><strong>SUBTOTAL</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sale->items as $key => $item)
                                                <tr class="line">
                                                    <td>{{ intVal($key) + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-center">{{ $item->sellingprice }}</td>
                                                    <td class="text-right">{{ $item->discount }}</td>
                                                    <td class="text-right">{{ $item->total-$item->discount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                            <div class="col-xs-6 text-left " id="qrcode-container">

                            </div><br><br>

                                <div class="col-xs-6 text-left ">
                                    <p>Powered By<br><strong>EDS +256788924134</strong></p> 1@0,bRLE}ManE}QUS

                                </div>

                        </div>
                    </div>
                </div>
                <!-- END INVOICE -->

            </div>

        </div><!-- card -->

    </div><!-- am-pagebody -->
@endsection
@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        window.onload = function() {
            var qrc = new QRCode(
                document.getElementById("qrcode-container"),
                "{{ $sale->efrisdoc->qrcode }}"
            );
        }
    </script>
    <script>
        function generatepdf() {
            var HTML_Width = $(".receipt").width();
            var HTML_Height = $(".receipt").height();
            var top_left_margin = 15;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;

            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

            html2canvas($(".receipt")[0]).then(function(canvas) {
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
                pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width,
                    canvas_image_height);
                for (var i = 1; i <= totalPDFPages; i++) {
                    pdf.addPage(PDF_Width, PDF_Height);
                    pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin * 4),
                        canvas_image_width, canvas_image_height);
                }
                pdf.save("{{ $sale->id }}");
                $(".receipt").hide();
            });
        }
    </script>
@endsection
