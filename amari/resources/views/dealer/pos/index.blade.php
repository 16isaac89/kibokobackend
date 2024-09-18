@extends('layouts.dealer')

@section('content')
@include('admin.dealers.modals.add')
@include('admin.dealers.modals.edit')
@include('dealer.pos.modals.addcustomer')
{{-- //@include('dealer.pos.partials.pos') --}}

<div class="card">
    <div class="card-header">
       ADD NEW ORDER
    </div>
	@if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
    <div class="card-body">
        <div class="row">
            <div class="col-8">
       <INPUT type="button" class="btn btn-success" value="Add Row" onclick="addRow('dataTable')" />
	<INPUT type="button" class="btn btn-danger" value="Delete Row" onclick="deleteRow('dataTable')" />
</div>
<div class="col-4">
    <span><b>Total:</b> <input type="number" readonly value="0" id="totalcart"/></span>
</div>
</div>
	<form method="post" action="{{route('dealer.possave')}}">
<div class="row" style="margin-top:10px;margin-bottom:10px;">
    <div class="form-group mg-b-10-force col-8">
                  <select class="form-control select2" id="customer" name="customer" data-placeholder="Select Customer">
                 
                  </select>
                </div>
                <div class="col-4">
                <button class="btn btn-success" style="width:50px;" data-toggle="modal" data-target="#addcustomer">ADD</button>
</div>
</div>
<table  style="margin-bottom:5px;">
	<tr>
		<td >Action</td>
		<td style="text-align:center;width:150px;">Brand</td>
		<th style="text-align:center;width:150px;">Product</th>
		<th style="text-align:center;width:150px;">Batch</th>
		<th style="text-align:center;width:150px;">Units</th>
		<th style="text-align:center;width:150px;">Price</th>
        <th style="text-align:center;width:150px;">Total</th>
        <th style="text-align:center;width:150px;">Discount</th>
		
		</tr>
</table>

	@csrf
	<TABLE id="dataTable"  style="margin-bottom:5px;">
		<TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
			<TD style="width:150px;text-align:center;">
				<SELECT name="brands[]" class="form-control brand" required="required">
                <option>Select product brand</option>
                @foreach($brands as $brand)
					<OPTION value="{{$brand->id}}">{{$brand->name}}</OPTION>
                @endforeach
				</SELECT>
			</TD>
            <TD style="text-align:center;width:150px">
				<SELECT name="products[]" id="productlist" required="required" class="form-control product">
					
				</SELECT>
			</TD>
			<TD style="text-align:center;width:150px">
				<SELECT name="batches[]" id="batchlist" required="required" class="form-control batch">
					
				</SELECT>
			</TD>
            <TD style="text-align:center;width:150px"><INPUT type="number" required  name="unit[]" id="productunit" class="form-control productunit"/></TD>
            <TD style="text-align:center;width:150px"><INPUT type="number"  readonly name="price[]" class="form-control productprice"/></TD>
            
            <TD style="text-align:center;width:150px"><INPUT type="number"  readonly name="total[]" id="producttotal" class="form-control producttotal"/></TD>
            <TD style="text-align:center;width:150px"><INPUT type="number" name="discount[]" required  id="productdiscount" class="form-control productdiscount"/></TD>

		</TR>
	</TABLE>
	<button class="btn btn-primary">Save</button>
</form>



        </div>        


        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
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

	<script>
		$('#dataTable').on('change', '.brand', function() {
    var selectedValue = $(this).val();
    var row = $(this).closest('tr'); // get the row
    var stateSelect = row.find('.product'); // get the other select in the same row
    $.ajax({
		method:'GET',
        url: "{{route('dealer.brand.products')}}",
        data: { brand: selectedValue, "_token": "{{ csrf_token() }}" },
        success: function(response) {
			let data = response.products
            stateSelect.empty();
			stateSelect.append($('<option></option>').text("Select Product"));
            $.each(data, function(item, index) {
			
                stateSelect.append($('<option></option>').val(index.id).text(index.name));
            })
        },
		error:function(error){
			//console.log(error)
		}
    });
})
		</script>


<script>
		$('#dataTable').on('change', '.product', function() {
    var selectedValue = $(this).val();
	//console.log("selectedValue")
	//console.log(selectedValue)
    var row = $(this).closest('tr'); // get the row
    var stateSelect = row.find('.batch'); // get the other select in the same row
    $.ajax({
		method:'GET',
        url: "{{route('dealer.product.batch')}}",
        data: { product: selectedValue, "_token": "{{ csrf_token() }}" },
        success: function(response) {
			let data = response.batches
            stateSelect.empty();
			stateSelect.append($('<option></option>').text("Select Product Batch"));
            $.each(data, function(item, index) {
                stateSelect.append($('<option></option>').val(index.id).text(index.amount+' '+index.sellingprice+' '+index.expirydate));
            })
        },
		error:function(error){
			//console.log(error)
		}
    });
})
		</script>

<!-- <script>
	$('#dataTable').on('change', '.product', function() {
			var selectedValue = $(this).val();

			var row = $(this).closest('tr'); // get the row
			var productunit = row.find('.productunit'); 
			var productprice = row.find('.productprice');
			var producttotal = row.find('.producttotal');
			$.ajax({
				method:'GET',
				url: "{{route('dealer.product.details')}}",
				data: { product: selectedValue, "_token": "{{ csrf_token() }}" },
				success: function(response) {
				let data = response.product
				productunit.val("1")
				productprice.val("")
				producttotal.val("")
				productprice.val(data.price)
				producttotal.val(parseInt("1")*parseInt(data.price))
				},
				error:function(error){
			console.log(error)
		}
		});
	})
	</script> -->

<script>
		$('#dataTable').on('change', '.batch', function() {
    var selectedValue = $(this).val();

	var row = $(this).closest('tr'); // get the row
			var productunit = row.find('.productunit'); 
			var productprice = row.find('.productprice');
			var producttotal = row.find('.producttotal');
	$.ajax({
				method:'GET',
				url: "{{route('dealer.batch.price')}}",
				data: { batch: selectedValue, "_token": "{{ csrf_token() }}" },
				success: function(response) {
				let data = response.batch
				//console.log("data")
				//console.log('sdsd')
				row.find('#productunit').attr('max',data.amount)
				
				productunit.val("1")
				productprice.val("")
				producttotal.val("")
				productprice.val(data.sellingprice)
				producttotal.val(parseInt("1")*parseInt(data.sellingprice))
				},
				error:function(error){
			//console.log(error)
		}
		});
//console.log(selectedValue)
})
		</script>

<script>
	$('#dataTable').on('change click keyup input paste', '.productunit', function() {
			var selectedValue = $(this).val();
			var row = $(this).closest('tr');
			var productprice = row.find('.productprice');
			var producttotal = row.find('.producttotal');
			let total = parseInt(selectedValue)*parseInt(productprice.val())
			producttotal.val(total)
			
	})
	</script>

<script>
	$('#dataTable').on('change click keyup input paste', '#producttotal', function() {
        
        var selectedValue = $(this).val();
       
			let cartnow = document.getElementById('totalcart').value
            let total = parseInt(selectedValue) + parseInt(cartnow)
			//console.log(total)
			document.getElementById('totalcart').value = total
	})
	</script>
    <script>
      
	$('#dataTable').on('input ', '.productdiscount', function() {
        
        var selectedValue = $(this).val();
			var row = $(this).closest('tr');
			var producttotal = row.find('.producttotal')
			let total = parseInt(producttotal.val())-parseInt(selectedValue)
			producttotal.val(total)
	})
	</script>
    <script>
window.onload = function(){
    $.ajax({
				method:'GET',
				url: "{{route('dealer.get.customers')}}", 
				data: { "_token": "{{ csrf_token() }}" },
				success: function(response) {
				//console.log(response)
                let data = response.customers
                let stateSelect = document.getElementById('customer')
                $("#customer").empty();
                for(var i = 0; i < data.length; i++) {
    var opt = data[i];
    //console.log(data[i])
    var el = document.createElement("option");
    el.textContent = opt.name+' '+opt.phone;
    el.value = opt.id;
    stateSelect.appendChild(el);
}
				},
				error:function(error){
			console.log(error)
		}
		});
}

function addcustomer(){
    let name = document.getElementById('name').value
    let phone = document.getElementById('phone').value
    let address = document.getElementById('address').value
    let tin = document.getElementById('tin').value
    let registered = document.getElementById('efrisstatus').value
    let route = document.querySelector('#route').value
	let category = document.querySelector('#category').value
	let buyertype = document.querySelector('#buyertype').value
document.getElementById('savecustomer').style.display = "none"
document.getElementById('savingcustomer').style.display = "block"
    $.ajax({
		method:'POST',
        url: "{{route('dealer.possavecustomer')}}",
        data: { name: name, 
                phone:phone,
                address:address,
                tin:tin,
                registered:registered,
                route:route,
				category:category,
				buyertype:buyertype,
            "_token": "{{ csrf_token() }}" },
        success: function(response) {
			document.getElementById('savecustomer').style.display = "block"
            document.getElementById('savingcustomer').style.display = "none"
            $('#addcustomer').modal('hide');
            let data = response.customers
                let stateSelect = document.getElementById('customer')
                $("#customer").empty();
                for(var i = 0; i < data.length; i++) {
    var opt = data[i];
    console.log(data[i])
    var el = document.createElement("option");
    el.textContent = opt.name+' '+opt.phone;
    el.value = opt.id;
    stateSelect.appendChild(el);
}
        },
		error:function(error){
			//console.log(error)
			document.getElementById('savecustomer').style.display = "block"
            document.getElementById('savingcustomer').style.display = "none"
		}
    }); 
}
</script>
<script>
        function checkregistration(){

            let route = "{{ route('dealer.suppliers.checktin') }}";
            let token = "{{ csrf_token()}}";
            let tin =document.getElementById('tin').value
if(tin===''){
alert('TIN is a required field.')
return
}else{
	document.getElementById('getbtn').style.display = 'none'
            document.getElementById('loader').style.display = 'block'
            $.ajax({
                url: route,
                type: 'GET',
                data: {
                    _token:token,
                    tin:tin,
               
                },
                success: function(response) {
                    document.getElementById('getbtn').style.display = 'block'
            document.getElementById('loader').style.display = 'none'
                    let taxpayer = response.taxpayer
                    document.getElementById('name').value = taxpayer.businessName
                    document.getElementById('phone').value = taxpayer.contactNumber
                    document.getElementById('email').value = taxpayer.contactEmail
                    document.getElementById('address').value = taxpayer.address
					if(taxpayer.taxpayerType === 201){
						document.querySelector('#buyertype').value ="1";
					}else{
						document.querySelector('#buyertype').value ="0";
					}
					
                 //  console.log(taxpayer)
                },
                error: function(xhr) {
                  //  console.log(xhr)
                    document.getElementById('getbtn').style.display = 'block'
            document.getElementById('loader').style.display = 'none'
                    alert(xhr)
                    //Do Something to handle error
                }});
			}

        }
        </script>

@endsection