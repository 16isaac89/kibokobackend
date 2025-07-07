@extends('layouts.admin')
@section('styles')
 <!-- Leaflet.js CDN -->
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

 <style>
     /* Make sure the map containers take up a reasonable height */
     #map1, #map2 {
         height: 400px;
     }
       #salesTodayTable td.details-control {
        background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    #salesTodayTable tr.shown td.details-control {
        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
    }
 </style>
@endsection
@section('content')
@can('customer_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.customers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.customer.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Customer', 'route' => 'admin.customers.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Dealer {{ $dealer->tradename }} Details
    </div>


    <div class="card-body">



            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="routes-tab" data-toggle="tab" href="#routes" role="tab" aria-controls="routes" aria-selected="true">
                        <i class="fas fa-route"></i> Routes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="customers-tab" data-toggle="tab" href="#customers" role="tab" aria-controls="customers" aria-selected="false">
                        <i class="fas fa-users"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pre-sale-orders-tab" data-toggle="tab" href="#presaleorders" role="tab" aria-controls="presaleorders" aria-selected="false">
                        <i class="fas fa-shopping-cart"></i> PreSale Orders
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices" role="tab" aria-controls="invoices" aria-selected="false">
                        <i class="fas fa-file"></i> Invoice Orders
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" id="vans-tab" data-toggle="tab" href="#vans" role="tab" aria-controls="vans" aria-selected="false">
                        <i class="fas fa-truck"></i> Vans
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" id="maps-tab" data-toggle="tab" href="#maps" role="tab" aria-controls="maps" aria-selected="false">
                        <i class="fas fa-map-marked-alt"></i> Maps
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">
                        <i class="fas fa-user"></i> Users
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" id="today-tab" data-toggle="tab" href="#today" role="tab" aria-controls="today"
                    aria-selected="false">
                        <i class="fas fa-calendar"></i> Today
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="routes" role="tabpanel" aria-labelledby="routes-tab">
                    <h4 class="mt-3">Routes</h4>
                    @include('admin.dealers.relationships.routes')
                </div>
                <div class="tab-pane fade" id="customers" role="tabpanel" aria-labelledby="customers-tab">
                    <h4 class="mt-3">Customers List</h4>
                    <h6 class="mt-3">Total:{{ $dealer->customers->count() }}</h6>
                    <h6 class="mt-3">Visited:{{ $dealer->customers()->whereNotNull('updated_at')->count(); }}</h6>
                    @include('admin.dealers.relationships.customers')
                </div>
                <div class="tab-pane fade" id="presaleorders" role="tabpanel" aria-labelledby="pre-sale-orders-tab">
                    <h4 class="mt-3">PreSale Orders Content</h4>
                    @include('admin.dealers.relationships.presales')
                </div>
                {{-- <div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
                    <h4 class="mt-3">Invoices Content</h4>
                    <p>Invoices tab</p>
                </div> --}}
                {{-- <div class="tab-pane fade" id="vans" role="tabpanel" aria-labelledby="vans-tab">
                    <h4 class="mt-3">Vans Content</h4>
                    <p>Vans table</p>
                </div> --}}
                <div class="tab-pane fade" id="maps" role="tabpanel" aria-labelledby="maps-tab">
                    <h4 class="mt-3">Maps Content</h4>
                    @include('admin.dealers.relationships.maps')
                </div>
                <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                    <h4 class="mt-3">Users</h4>
                   @include('admin.dealers.relationships.users')
                </div>
                <div class="tab-pane fade" id="today" role="tabpanel" aria-labelledby="today-tab">
                    <h4 class="mt-3">Today</h4>
                   @include('admin.dealers.relationships.today')
                </div>
            </div>







    </div>
</div>



@endsection
@section('scripts')
@parent
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('customer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.customers.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Customer:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
<script>
         // Define the list of Ugandan coordinates with title for Map 1
    var coordinatesMap1 = [
        { latitude: 0.3476, longitude: 32.5825, title: 'Kampala' },
        { latitude: 0.3227, longitude: 32.5814, title: 'Makerere University' },
        { latitude: 0.3476, longitude: 32.5866, title: 'Kasubi Tombs' }
    ];

    // Define the list of Ugandan coordinates with title for Map 2
    var coordinatesMap2 = [
        { latitude: 0.3136, longitude: 32.5814, title: 'Entebbe International Airport' },
        { latitude: 0.3529, longitude: 32.6158, title: 'Uganda National Mosque' },
        { latitude: 0.0917, longitude: 32.8937, title: 'Mabira Forest' }
    ];

    // Initialize Map 1
    var map1 = L.map('map1').setView([0.3476, 32.5825], 13); // Center on Kampala
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map1);

    // Add markers with popups for Map 1
    coordinatesMap1.forEach(function(location) {
        L.marker([location.latitude, location.longitude])
            .addTo(map1)
            .bindPopup(location.title);
    });

    // Initialize Map 2
    var map2 = L.map('map2').setView([0.3136, 32.5814], 12); // Center on Entebbe
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map2);

    // Add markers with popups for Map 2
    coordinatesMap2.forEach(function(location) {
        L.marker([location.latitude, location.longitude])
            .addTo(map2)
            .bindPopup(location.title);
    });
</script>
<script>
    function getDetails() {
        let fromDate = document.getElementById('from_date').value;
        let toDate = document.getElementById('to_date').value;
        let subdealer = document.getElementById('{{ $dealer->id }}').value;

        if (fromDate == '' || toDate == '' || fromDate == null || toDate == null || fromDate == undefined || toDate == undefined) {
            alert('Please select a date range');
            return;
        } else {
            // Show loader and disable button
            document.getElementById('search-text').style.display = 'none';
            document.getElementById('search-loader').style.display = 'inline-block';
            document.getElementById('search-btn').disabled = true;

            $.ajax({
                url: '{{ route('admin.presaleorders.searchbydatepostdealer') }}',
                type: 'GET',
                data: {
                    'fromdate': fromDate,
                    'todate': toDate,
                    'dealer_id': '{{ $dealer->id }}',
                    '__token': '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data) {
                    let preorders = data.preorders;
                    generateDataTable(preorders);

                    // Hide loader and enable button
                    document.getElementById('search-text').style.display = 'inline';
                    document.getElementById('search-loader').style.display = 'none';
                    document.getElementById('search-btn').disabled = false;
                },
                error: function(error) {
                    console.log(error);

                    // Hide loader and enable button in case of error
                    document.getElementById('search-text').style.display = 'inline';
                    document.getElementById('search-loader').style.display = 'none';
                    document.getElementById('search-btn').disabled = false;
                }
            });
        }
    }

    function generateDataTable(preorders) {
        const table = document.createElement('table');
        table.id = 'bootstrap-datatable';
        table.classList.add('table', 'table-bordered', 'table-striped', 'table-hover', 'datatable');

        // Generate the table header
        const thead = document.createElement('thead');
        thead.innerHTML = `
            <tr>
                <th>Invoice No</th>
                <th>Invoice Date</th>
                  <th>Sales Person</th>
                <th>Customer Name</th>
                <th>SUBD</th>
                <th>Executive Name</th>
                <th>Product Code</th>
                <th>Quantity</th>
                <th>Item Description</th>
                <th>Basic Value</th>
                <th>VAT Value</th>
                <th>Total Sales</th>
                <th>Route</th>
                <th>In Time</th>
                <th>Out Time</th>
            </tr>
        `;
        table.appendChild(thead);

        // Generate the table body
        const tbody = document.createElement('tbody');
        preorders.forEach(preorder => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${preorder.stockreqs.id ?? ''}</td>
               <td>${new Date(preorder.stockreqs.created_at).toLocaleString('en-GB', {
year: 'numeric',
month: '2-digit',
day: '2-digit',
hour: '2-digit',
minute: '2-digit',
second: '2-digit'
})}</td>
<td>${preorder.stockreqs.saler?.username ?? ''}</td>
                <td>${preorder.stockreqs.customer.name ?? ''}</td>
                <td>${preorder.stockreqs.dealer.tradename ?? ''}</td>
                <td>${preorder.stockreqs.saler.username}</td>
                <td>${preorder.product.code}</td>
                <td>${preorder.reqqty}</td>
                <td>${preorder.product.description ?? ''}</td>
                <td>${preorder.sellingprice}</td>
                <td>${preorder.product.tax_amount ?? 0}</td>
                <td>${preorder.total}</td>
                <td>${preorder.stockreqs.customerroute.name}</td>
                <td>${preorder.stockreqs.checkin}</td>
                <td>${preorder.stockreqs.checkout}</td>
            `;
            tbody.appendChild(row);
        });
        table.appendChild(tbody);

        // Clear and append the table
        document.getElementById('datatable-container').innerHTML = '';
        document.getElementById('datatable-container').appendChild(table);

        // Initialize DataTables
        $('#bootstrap-datatable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            responsive: true
        });
    }
</script>
<script>
    document.querySelectorAll('.export-btn').forEach(function (button) {
button.addEventListener('click', function (e) {
    e.preventDefault();

    let fromDate = document.getElementById('from_date').value;
    let toDate = document.getElementById('to_date').value;
    let type = this.getAttribute('data-type');
    let dealerid = '{{ $dealer->id }}'; // Get the dealer ID from the server-side variable

    if (fromDate == '' || toDate == '' || fromDate == null || toDate == null) {
        alert('Please select a date range');
        return;
    }

    // Redirect to the correct export route with query parameters
    window.location.href = `/admin/presaleorders/export/dealer/?from_date=${fromDate}&to_date=${toDate}&type=${type}&dealer_id=${$dealerid}`;
});
});
</script>
<script>
$(document).ready(function() {
    // Sales Today Table with expandable rows
    // var salesTable = $('#salesTodayTable').DataTable({
    //     "order": [[1, 'asc']]
    // });

    // Add event listener for opening and closing details
    $('#salesTodayTable tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = salesTable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            var items = JSON.parse(tr.attr('data-items'));
            row.child(formatSaleItems(items)).show();
            tr.addClass('shown');
        }
    });

    // Function to format the child row data with actual items
    function formatSaleItems(items) {
        let itemsHtml = `
            <div class="p-3">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>`;

        items.forEach(item => {
            itemsHtml += `
                        <tr>
                            <td>${item.product ? item.product.name : 'N/A'}</td>
                            <td>${item.reqqty}</td>
                            <td>${item.price ? '₦' + item.price.toFixed(2) : 'N/A'}</td>
                            <td>${item.price ? '₦' + (item.price * item.reqqty).toFixed(2) : 'N/A'}</td>
                        </tr>`;
        });

        itemsHtml += `
                    </tbody>
                </table>
            </div>`;

        return itemsHtml;
    }

    // Customers Today Table
    $('#customersTodayTable').DataTable({
        "order": [[1, 'asc']]
    });
});
</script>
@endsection
