@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">
      <div class="table-responsive">
        <button id="editButton" class="btn btn-primary mb-3" style="display:none;" onclick="submitSelectedProducts()">Edit Selected</button>
        <table id="products" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th> <!-- Select All Checkbox -->
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
                    <td><input type="checkbox" class="selectProduct" data-id="{{$product->id}}"></td> <!-- Row Checkbox -->
                    <td>{{$product->id}}</td>
                    <td>{{ $product->name ?? '' }}</td>
                    <td>{{$product->code}}</td>
                    <td>{{$product->brand->name ?? ''}}</td>
                    <td>{{ $product->category?->name ?? '' }}</td>
                    <td>{{$product->unit}}</td>
                    <td>{{ $product->dealerproduct?->sellingprice ?? '' }}</td>
                    <td>{{ $product->dealerproduct?->stock ?? '' }}</td>
                    <td>

                        @if(\Gate::forUser('dealer')->allows('product_edit'))
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Actions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{route('dealer.product.viewedit', $product->id)}}" class="btn btn-primary">
                                    @if($product->dealerproduct)
                                    Update
                                    @else
                                    Create
                                    @endif
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
</div><!-- am-pagebody -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#products').DataTable({
            dom: 'Bfrtip',
            buttons: ['colvis', 'excel', 'print', 'copy', 'pdf', 'csv'],
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]], // Add row selector
        });

        // Handle 'Select All' checkbox
        $('#selectAll').click(function() {
            let isChecked = $(this).prop('checked');
            $('.selectProduct').prop('checked', isChecked);
            toggleEditButton(); // Check whether to show or hide the edit button
        });

        // Handle individual checkbox click
        $('.selectProduct').click(function() {
            toggleEditButton(); // Check whether to show or hide the edit button
        });

        // Function to toggle the visibility of the "Edit Selected" button
        function toggleEditButton() {
            let anyChecked = $('.selectProduct:checked').length > 0;
            if (anyChecked) {
                $('#editButton').show();
            } else {
                $('#editButton').hide();
            }
        }
    });

    // Function to submit selected products
    function submitSelectedProducts() {
    let selectedProducts = [];
    $('.selectProduct:checked').each(function() {
        selectedProducts.push($(this).data('id'));
    });

    if (selectedProducts.length > 0) {
        // Create a URL for redirection with the selected IDs
        let selectedIds = selectedProducts.join(',');
        let editUrl = "{{ url('/dealer/product/bulkedit') }}?ids=" + selectedIds;

        // Redirect to the edit page with the selected IDs
        window.location.href = editUrl;
    } else {
        alert('Please select at least one product to edit.');
    }
}
</script>
@endsection
