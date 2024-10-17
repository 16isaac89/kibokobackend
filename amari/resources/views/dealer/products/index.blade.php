@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">

{{-- @include('dealer.van.modals.add') --}}

    <div class="card pd-20 pd-sm-40">
      <div class="table-responsive">

        <table id="products" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{ $product->name ?? '' }}</td>
                    <td>{{$product->code}}</td>
                    <td>{{$product->brand->name ?? ''}}</td>
                    <td>{{ $product->category?->name ?? '' }}</td>
                    <td>{{$product->unit}}</td>
                    <td>{{ $product->dealerproduct?->sellingprice ?? '' }}</td>
                    <td>{{ $product->dealerproduct?->stock ?? '' }}</td>
                    <td>
                        <a href="{{route('dealer.product.viewedit', $product->id)}}" type="button" class="btn btn-primary">
                            @if($product->dealerproduct)
                            Update
                            @else
                            Create
                            @endif

                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->
  @include('dealer.products.modals.openingstock')
@endsection
@section('scripts')
<script>
    function openingstockmodal(d){
        let id = d.getAttribute('data-id');
  let name = d.getAttribute('data-name')
  console.log(id,name)
  document.getElementById("product-id").value = id
  document.getElementById("modal-title").innerHTML = 'Enter opening stock for ' + name
    }
//     document.getElementById("opbtn").addEventListener("click", function(){
//   let id = this.getAttribute('data-id');
//   let name = this.getAttribute('data-name')
//   console.log(id,name)
//   document.getElementById("product-id").value = id
//   document.getElementById("modal-title").innerHTML = 'Enter opening stock for ' + name
// });
</script>
<script>
    (function() {
     $('#products').DataTable({
         dom: 'Bfrtip',
         buttons: [
             'colvis',
             'excel',
             'print',
             'copy',
             'pdf',
             'csv'
         ],
         lengthMenu: [ [10, 20, 50, 100, -1], [10, 20, 50, 100, "All"] ], // Add row selector
     });
 })();
 </script>
    <script>
        $('#addprice').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('id') // Extract info from data-* attributes
  document.getElementById('product').value = recipient
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
})
        </script>

<script>
        //   function syncproduct(d){
        //       let product = d.getAttribute("data-id")
        //       document.getElementById('btn-'+product).style.display = "none"
        //       document.getElementById('loader-'+product).style.display = "block"
        //       alert(product)
        //       return
        //        $.ajax({
        //
        //             type: 'POST',
        //             data: {
        //             "_token": "{{ csrf_token() }}",
        //             product:product,
        //             dealer:"{{\Auth::guard('dealer')->user()->dealer_id}}"
        //              },
        //             success: function (response) {
        //               document.getElementById('btn-'+product).style.display = "block"
        //               document.getElementById('loader-'+product).style.display = "none"
        //               console.log(response)
        //               alert(response.message)
        //              },
        //             error: function (jqXHR, textStatus, errorThrown) {

        //             console.log(textStatus, errorThrown,jqXHR);
        //             }
        //         })
        //   }
</script>
<script>
    $(document).ready(function () {
        $('.date').datetimepicker({
          format: 'YYYY-MM-DD',
          locale: 'en',
          icons: {
            up: 'fas fa-chevron-up',
            down: 'fas fa-chevron-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right'
          }
        })
    })
    </script>


@endsection
