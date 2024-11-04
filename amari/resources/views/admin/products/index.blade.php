@extends('layouts.admin')
@section('styles')
<style>
 .dropdown {
  position: relative;
  display: inline-block;
  width:200px;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  padding: 12px 16px;
  z-index: 1;
}

.dropdown:hover .dropdown-content {
  display: block;
}
    </style>
@endsection
@section('content')
@include('admin.products.modals.add',['brands'=>$brands,'categories'=>$categories])
@include('admin.products.modals.edit',['brands'=>$brands])
@include('admin.products.modals.stock')
@include('admin.products.modals.opening')
@include('admin.products.modals.update')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" data-toggle="modal" data-target="#addproduct">
                {{ trans('global.add') }} Product
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Product', 'route' => 'admin.products.parseCsvImport'])
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                Upload Excel File
            </button>
        </div>



    </div>
@endcan
<div class="card">
    <div class="card-header">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
@if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
    </div>

    <div class="card-body">
    <div class="card-header">
        <b style="color:black;font-size:25px;">Product List</b>
</div>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-products">
                <thead>
                    <tr>
                        <th width="10">

                        </th>

                        <th>
                            {{ trans('cruds.role.fields.id') }}
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Code
                         </th>
                         <th>
                            Category
                        </th>
                        <th>
                            Brand
                        </th>
                        <th>
                            Tax
                        </th>
                        <th>
                            Price
                        </th>
                        <th>
                            Unit
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr data-entry-id="{{ $product->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $product->id ?? '' }}
                            </td>
                            <td>
                                {{ $product->name ?? '' }}
                            </td>
                            <td>
                                {{ $product->code ?? '' }}
                            </td>
                            <td>
                                {{ $product->category->name ?? '' }}
                            </td>
                            <td>
                                {{ $product->brand->name ?? '' }}
                            </td>
                            <td>
                                {{ $product->tax_amount ?? '' }}
                            </td>
                            <td>
                                {{ $product->selling_price ?? '' }}
                            </td>
                            <td>
                                {{ $product->unit ?? '' }}
                            </td>
                            <td>

                                <div class="dropdown">
                                        <button style="padding:14px 16px;background-color:blue;color:#000;background-color: cyan;opacity: 1;border-radius:25px;">Actions</button>
                                        <div class="dropdown-content">
                                @can('product_edit')
                                    <a href="{{route('admin.product.viewedit',['product'=>$product->id])}}" class="btn btn-primary">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan


                                @can('product_delete')
                                    <a href="{{route('admin.product.delete',['product'=>$product->id])}}" class="btn btn-danger">
                                        Delete
                                    </a>
                                @endcan




                                @if($product->sync === 0)
                                @can('product_edit')
                                    <a class="btn btn-xs btn-warning" href="{{route('admin.sync.product',['product'=>$product->id])}}">
                                        Sync
                                    </a>
                                @endcan
                                @endif

</div>
</div>







                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-products:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
<script>
$('#editproduct').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal

  var id = button.data('id');
  var code = button.data('code');
  var stock = button.data('stock');
  var name = button.data('name');
  var price = button.data('price');
  var brand = button.data('brand')
  var location = button.data('location')
  var unit = button.data('unit')
  document.getElementById('productid').value = id;
  document.getElementById('productname').value = name;
  document.getElementById('productstock').value = stock;
  document.getElementById('productcode').value = code;
  document.getElementById('productprice').value = price;
  document.getElementById('productbrandname').value = brand;
  document.getElementById('productunit').value = unit;
  document.getElementById('locationid').value = location;
})
</script>


<script type="text/javascript">
$('#search').on('keyup',function(){
$value=$(this).val();
$.ajax({
type : 'get',
url : '{{ route('admin.efrisgoodsategory.get') }}',
data:{'search':$value},
success:function(data){
    console.log(data)
$('#searchresults').html(data);
}
});
})
</script>
<script>
$('#stockproduct').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id');
  var name = button.data('name');
  document.getElementById('stockid').value=id
  document.getElementById('pname').innerHTML = name
})
</script>
<script>
$('#openingstock').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id');
  var name = button.data('name');
  document.getElementById('openingstockid').value=id
  document.getElementById('opname').innerHTML = name
})
</script>



<script language="javascript">
		function addRow(tableID) {

			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var colCount = table.rows[0].cells.length;

			for(var i=0; i<colCount; i++) {

				var newcell	= row.insertCell(i);

				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				//alert(newcell.childNodes);
				switch(newcell.childNodes[0].type) {
					case "text":
							newcell.childNodes[0].value = "";
							break;
					case "checkbox":
							newcell.childNodes[0].checked = false;
							break;
					case "select-one":
							newcell.childNodes[0].selectedIndex = 0;
							break;
				}
			}
		}

		function deleteRow(tableID) {
			try {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Cannot delete all the rows.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}


			}
			}catch(e) {
				alert(e);
			}
		}

	</script>


<script language="javascript">
		function addVRow(tableID) {

			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var colCount = table.rows[0].cells.length;

			for(var i=0; i<colCount; i++) {

				var newcell	= row.insertCell(i);

				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				//alert(newcell.childNodes);
				switch(newcell.childNodes[0].type) {
					case "text":
							newcell.childNodes[0].value = "";
							break;
					case "checkbox":
							newcell.childNodes[0].checked = false;
							break;
					case "select-one":
							newcell.childNodes[0].selectedIndex = 0;
							break;
				}
			}
		}

		function deleteVRow(tableID) {
			try {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Cannot delete all the rows.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}


			}
			}catch(e) {
				alert(e);
			}
		}

	</script>

@endsection
