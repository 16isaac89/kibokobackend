@extends('layouts.dealer')
@section('styles')
<style>
    #infoDiv {
        display: none; /* Hidden by default */
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
        text-align: left;
    }
</style>
@endsection
@section('content')
@include('dealer.customer.modals.add',['categories'=>$categories,'routes'=>$routes])
@include('dealer.customer.modals.verifytin')
<div class="am-pagebody">
    <div>
        <h6 class="card-body-title">Customer List</h6>
      </div>
    <div class="card pd-20 pd-sm-40">
        <div class="card-header row">


      <div class="float-right" style="float:right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
        ADD
      </button>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#verifytinModal">
        VERIFY TIN
      </button>
    </div>
    </div>
<div class="card-body">
      <div class="table-wrapper">
        <table id="customers" class="table display responsive nowrap">
          <thead>
            <tr>
              <th class="wd-15p">Name</th>
              <th class="wd-15p">Category</th>
              <th class="wd-20p">Address</th>
              <th class="wd-20p">Phone Number</th>
              <th class="wd-10p">Route</th>
              <th class="wd-10p">Classification</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($customers as $customer)
            <tr>
              <td>{{$customer->name ?? ''}}</td>
              <td>{{$customer->custcategory  ?? ''}}</td>
              <td>{{$customer->address ?? ''}}</td>
              <td>{{$customer->phone ?? ''}}</td>
              <td>{{$customer->route?->name ?? ''}}</td>
              <td>{{$customer->classification ?? ''}}</td>

            </tr>

            @endforeach

          </tbody>
        </table>
      </div><!-- table-wrapper -->
    </div>
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection
@section('scripts')
<script>
   (function() {
    $('#customers').DataTable({
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
    </script>
    <script>
        function verifytin() {
    $.ajax({
        url: '{{ route('dealer.taxpayer.info') }}',
        type: 'GET',
        data: {
            "_token": "{{ csrf_token() }}",
            tin: document.getElementById('customer_tin').value,
        },
        success: function(response) {
            let taxpayer = response.taxpayer;

            const tableBody = document.getElementById('infoTableBody');
                    tableBody.innerHTML = ''; // Clear existing rows
                    for (const key in taxpayer) {
                        if (taxpayer.hasOwnProperty(key)) {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${key}</td>
                                <td>${taxpayer[key]}</td>
                            `;
                            tableBody.appendChild(row);
                        }
                    }

                    // Show the info div
                    document.getElementById('infoDiv').style.display = 'block';

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown, jqXHR);
        }
    });
}
    </script>

@endsection
