@extends('layouts.dealer')
@section('styles')
<style>
td.details-control {
    background: url('/images/logo/plus.png') no-repeat center center;
    cursor: pointer;
}
tr.details td.details-control {
    background: url('/images/logo/minus.png') no-repeat center center;
}
</style>
@endsection
@section('content')
<div class="am-pagebody">
  @include('dealer.route.modals.edit')
@include('dealer.route.modals.add')
    <div class="card pd-20 pd-sm-40">
      <div class="card-header">
        <div class="mb-6">
        <form class="form-inline" method="get" action="{{route('dealer.searchsales')}}">
          @csrf
          <input class="form-control mr-sm-2 from" type="search" name="from" placeholder="Search" aria-label="Search">
          <input class="form-control mr-sm-2 to" type="search" name="to" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        </div>
      </div>
      <div class="row">
<!-- <button id="btn-show-all-children col-4" style="width:100px;border-radius:25px;margin:10px;" type="button">Expand All</button>
<button id="btn-hide-all-children col-4" style="width:100px;border-radius:25px;margin:10px;" type="button">Collapse All</button> -->
</div>
      <div class="table-wrapper">
        <table id="sales"  class="table display responsive nowrap sales">
          <thead>
            <tr>
              <th>
                <i class="fas fa-eye"></i>
              </th>
              <th class="wd-15p">ID</th>
              <th class="wd-15p">Date</th>
              <th class="wd-15p">Sales Rep</th>
              <th class="wd-20p">Customer</th>
              <th class="wd-20p">Route</th>
              <th >Total</th>
              
              
            </tr>
          </thead>
          <tbody>
            @foreach($sales as $sale)
            <tr>
            <td data-items = "{{$sale->items}}">
              <i class="fas fa-eye"></i>
            </td>
            <td >{{$sale->id}}</td>
              <td>{{\Carbon\Carbon::parse($sale->created_at)->toFormattedDateString()}}</td>
              <td>{{$sale->user->username ?? ''}}</td>
              <td>{{$sale->customer->name ?? ''}}</td>
              <td>{{$sale->route->name ?? ''}}</td>
              <td>{{$sale->total ?? ''}}</td>
            
            </tr>
        @endforeach
          </tbody>
          <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
             </tr>
        </tfoot>
        </table>
      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->
 
@endsection
@section('scripts')
@parent
<script>

  
 function format(d,items) {
  let data = JSON.parse(items)  
  let x = ""
  for (let i = 0; i < data.length; i++) {
    
   x += "<p style='text-align:left;'><b>"+"ITEM: "+data[i].name+"("+data[i].quantity+") "+"Price: "+data[i].sellingprice+" Total: "+data[i].total+"</b></p>"+"<br>"
}
return x 
}
 
  (function() {
    var table = $('.sales').DataTable({
      
        dom: 'Bfrtip',
    buttons: [
        // 'colvis',
       
        // 'print',
        // 'copy', 'pdf',
        {
          extend:'csv',
                              text:      '<i class="fa fa-file-excel-o"></i>',
                              titleAttr: 'Excel',
                              "oSelectorOpts": { filter: 'applied', order: 'current' },
                              "sFileName": "salesreport.xls",
                              action : function( e, dt, button, config ) {
                                  exportTableToCSV.apply(this, [$('#sales'), 'salesreport.xls']);
 
                              }
 
        },
    ],
    

    columns: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
            
            { data: 'id' },
            { data: 'date' },
            { data: 'rep' },
            { data: 'customer' },
            { data: 'route' },
            { data: 'amount' },
        ],
        footerCallback: function( tfoot, data, start, end, display ) {
        var api = this.api();
        $(tfoot).find('th').eq(0).html( "Total" );
        $(api.column(6).footer()).html(
            api.column(6).data().reduce(function ( a, b ) {
                return parseFloat(a) + parseFloat(b);
            }, 0)
        );
    }
       
    });
 
    // Add event listener for opening and closing details
    $('.sales tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var items = tr.children("td:eq(0)").attr('data-items')
        var row = table.row(tr);

        
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
         
            row.child(format(row.data(),items)).show();
            tr.addClass('shown');
        }
    });



    function exportTableToCSV($tables, filename) {
 
 //rescato los títulos y las filas
 var $Tabla_Nueva = $tables.find('tr:has(td,th)');
 // elimino la tabla interior.
 var Tabla_Nueva2= $Tabla_Nueva.filter(function() {
      return (this.childElementCount != 1 );
 });

 var $rows = Tabla_Nueva2,
     // Temporary delimiter characters unlikely to be typed by keyboard
     // This is to avoid accidentally splitting the actual contents
     tmpColDelim = String.fromCharCode(11), // vertical tab character
     tmpRowDelim = String.fromCharCode(0), // null character

     // Solo Dios Sabe por que puse esta linea
     colDelim = (filename.indexOf("xls") !=-1)? '"\t"': '","',
     rowDelim = '"\r\n"',


     // Grab text from table into CSV formatted string
     csv = '"' + $rows.map(function (i, row) {
         var $row = $(row);
         var   $cols = $row.find('td:not(.hidden),th:not(.hidden)');

         return $cols.map(function (j, col) {
             var $col = $(col);
             var text = $col.text().replace(/\./g, '');
             return text.replace('"', '""'); // escape double quotes

         }).get().join(tmpColDelim);
         csv =csv +'"\r\n"' +'fin '+'"\r\n"';
     }).get().join(tmpRowDelim)
         .split(tmpRowDelim).join(rowDelim)
         .split(tmpColDelim).join(colDelim) + '"';


  download_csv(csv, filename);


}



function download_csv(csv, filename) {
 var csvFile;
 var downloadLink;

 // CSV FILE
 csvFile = new Blob([csv], {type: "text/csv"});

 // Download link
 downloadLink = document.createElement("a");

 // File name
 downloadLink.download = filename;

 // We have to create a link to the file
 downloadLink.href = window.URL.createObjectURL(csvFile);

 // Make sure that the link is not displayed
 downloadLink.style.display = "none";

 // Add the link to your DOM
 document.body.appendChild(downloadLink);

 // Lanzamos
 downloadLink.click();
}



})();
      </script>
      <script>
         $('.from').datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'en',
    sideBySide: true,
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })
  $('.to').datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'en',
    sideBySide: true,
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })
        </script>

@endsection