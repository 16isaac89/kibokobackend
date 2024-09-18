@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
  @include('dealer.route.modals.edit')
@include('dealer.route.modals.add')
    <div class="card pd-20 pd-sm-40">
    
      <div class="table-wrapper">
        <table id="sales"  class="table display responsive nowrap sales">
          <thead>
            <tr>
              <th></th>
              <th class="wd-15p">Rep</th>
              <th class="wd-15p">Route(s)</th>
              <th class="wd-20p">Date</th>
              <th class="wd-20p">TOutlets</th>
              <th class="wd-20p">Product Calls</th>
              <th class="wd-20p">PunchIn</th>
              <th class="wd-20p">PunchOut</th>
              <th class="wd-20p">Amount</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            
            @foreach($sales as $sale)
            @if(count($sale->sales) > 0 )
            <tr>
              <td data-items = "{{$sale->sales}}">
                <i class="fas fa-eye"></i>
              </td>
              <td>{{$sale->phone}}</td>
              <td></td>
              <td>{{\Carbon\Carbon::parse($today)->toFormattedDateString()}}</td>
              <td>{{count($sale->sales)}}</td>
              <td></td>
              <td></td>
              <td></td>
              <td>{{$sale->sales->sum('total')}}</td>
             <td></td>
            </tr>
            @endif
        @endforeach
          </tbody>
        </table>
      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->
 
@endsection
@section('scripts')
<script>

  
  function format(d,items) {
    
   let data = JSON.parse(items)  
  
   let result = ""
   let custroute = ''
  var div = document.createElement('div')

   data.forEach((sale)=>{
    var p = document.createElement("p");
    p.style.cssText = 'text-align:left;color:orange;margin-top:5px;';
    p.innerHTML = sale.customer.name+' '+sale.route.name;
    div.appendChild(p)
    var div2 = document.createElement('div')

    let myArray = sale.items
    myArray.forEach((item)=>{
      var p2 = document.createElement("p");
    p2.style.cssText = 'text-align:left;color:black;';
    p2.innerHTML = 'Product: '+item.name+' '+'Quantity: '+item.quantity+' '+'Price: '+item.sellingprice+' '+'Total: '+item.total;
    div2.appendChild(p2)
    div.appendChild(div2)
    })

//     x += "<p style='text-align:left;'><b>"+"ITEM: "+data[i].name+"("+data[i].quantity+") "+"Price: "+data[i].sellingprice+" Total: "+data[i].total+"</b></p>"+"<br>"

   })
   return div
 //return x 
 }
  
   (function() {
     var table = $('.sales').DataTable({
       
         dom: 'Bfrtip',
     buttons: [
         // 'colvis',
        {
            extend: 'pdfHtml5',
            footer: true,
        },
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
             { data: '' },
             { data: 'id' },
             { data: 'date' },
             { data: 'rep' },
             { data: 'customer' },
             { data: 'route' },
             { data: 'amount' },
             { data: 'id' },
             { data: 'date' },
            
             
           
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

@endsection