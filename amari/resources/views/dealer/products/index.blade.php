@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">

@include('dealer.van.modals.add')

    <div class="card pd-20 pd-sm-40">
     @include('dealer.products.modals.price')
        <a href="{{ route('products.create') }}" class="btn btn-primary" style="width:50px;align-self:flex-end;border-radius:25px;margin:10px;">
        ADD
        </a>
        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
            {{ trans('global.app_csvImport') }}
        </button>
      <div class="table-responsive">

        <table id="products" class="display nowrap" width="100%">
          <thead>
            <tr>
              <th >ID</th>
              <th >Supplier</th>
              <th style="width: 25%">Name</th>
              <th >Code</th>
              <th >Brand</th>
              <th >Category</th>
              <th >Stock</th>
              <th >Unit</th>
              <th >Selling Price</th>
              <th >Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($products as $product)
            <tr>
              <td>{{$product->id}}</td>
              <td>{{$product->supplier?->name ?? ''}}</td>
              <td style="width: 90px;">
                {{ $product->name ?? '' }}
            </td>
              <td>{{$product->code}}</td>
              <td>{{$product->brand->name ?? ''}}</td>
              <td>{{ $product->productcategory?->name ?? '' }}</td>
              <td>
                <ul>
                    @foreach($product->stocks as $stock)
                    <li>
                    {{ \Carbon\Carbon::parse($stock->expirydate)->format('j F, Y') }} ({{$stock->amount}})
                    </li>
                    @endforeach
                    </ul>
              </td>
              <td>{{$product->unit}}</td>
              <td>
                <ul>
                    @foreach($product->stocks as $stock)
                    <li>
                    {{ \Carbon\Carbon::parse($stock->expirydate)->format('j F, Y') }} ({{$stock->sellingprice}})
                    </li>
                    @endforeach
                    </ul>
              </td>
              <td>
                @if(\Gate::forUser('dealer')->allows('product_edit'))
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="{{route('dealer.product.viewedit',['product'=>$product->id])}}" class="dropdown-item">
                            {{ trans('global.edit') }}
                        </a>
                        <a href="{{route('dealer.product.batches',['product'=>$product->id])}}" class="dropdown-item">
                            Batches
                        </a>
                        <a href="{{route('dealer.product.adjust',['product'=>$product->id])}}" class="dropdown-item">
                            Adjust Stock
                        </a>
                        <a href="{{route('dealer.product.addbatches',['product'=>$product->id])}}" class="dropdown-item">
                            ADD Batch
                        </a>
                        <a href="{{route('dealer.product.delete',['product'=>$product->id])}}" class="dropdown-item">
                            Delete
                        </a>

                        <a href="{{route('dealer.product.cost',['product'=>$product->id])}}" class="dropdown-item">
                            Cost Price
                        </a>

                    @if($product->efrissync?->type !== 1 && \Auth::guard('dealer')->user()->dealer->efris === 1)
                        <a class="dropdown-item" href="{{route('dealer.sync.product',$product->id)}}">
                            Sync
                        </a>
                    @endif
                    @if($product->openingstock === 0 && \Auth::guard('dealer')->user()->dealer->efris === 1)
                        <a class="dropdown-item" onclick="openingstockmodal(this)" id="opbtn" data-id="{{$product->id}}" data-name="{{$product->name}}" data-toggle="modal" data-target="#openingstock">
                            Opening Stock
                        </a>
                     @endif
                    </div>
                  </div>
@endif

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
        'copy', 'pdf','csv'
    ],
       
       

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
