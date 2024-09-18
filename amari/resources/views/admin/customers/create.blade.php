@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.customer.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.customers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-12">
                <label for="routeSelect">Distributor</label>
                <select class="form-control" name="dealer" id="dealerSelect"  placeholder="Select dealer">
                    <option selected value="">Select distributor</option>
                    @foreach($dealers as $dealer)
                    <option value="{{ $dealer->id }}">{{ $dealer->tradename }}</option>
                    @endforeach



                </select>
            </div>
            <div class="row">
            <div class="form-group col-md-6">
                <label for="fullname">{{ trans('cruds.customer.fields.fullname') }}</label>
                <input class="form-control {{ $errors->has('fullname') ? 'is-invalid' : '' }}" type="text" name="fullname" id="fullname" value="{{ old('fullname', '') }}">
                @if($errors->has('fullname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fullname') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.fullname_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label for="phone">{{ trans('cruds.customer.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.phone_helper') }}</span>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="email">{{ trans('cruds.customer.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', '') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.email_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label for="address">{{ trans('cruds.customer.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.address_helper') }}</span>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-md-6">
                <label for="username">Contact Person</label>
                <input class="form-control" type="text" name="contactperson" id="contactperson" value="{{ old('contactperson', '') }}">
            </div>
            <div class="form-group col-md-6">
                <label for="username">Telephone Number</label>
                <input class="form-control" type="text" name="telephoneno" id="telephoneno" value="{{ old('telephoneno', '') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="username">Area</label>
                <input class="form-control" type="text" name="area" id="area" value="{{ old('area', '') }}">
            </div>
            <div class="form-group col-md-6">
                <label for="username">City</label>
                <input class="form-control" type="text" name="city" id="city" value="{{ old('city', '') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="username">Country</label>
                <input class="form-control" type="text" name="country" id="country" value="{{ old('country', '') }}">
            </div>
            <div class="form-group col-md-6">
                <label for="routeSelect">Route</label>
                <select class="form-control" id="routeSelect" aria-label="Select Route">


                </select>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-md-6">
                <label for="routeSelect">Customer Category</label>
                <select class="form-control" name="custcategory" aria-label="Select Route">
                    <option selected>Select Category</option>
                    <option value="wholesale">Whole Sale</option>
                    <option value="retail">Retail</option>
                    <option value="supermarket">Supermarket</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="routeSelect">Classification</label>
                <select class="form-control" name="classification" aria-label="Select Route">
                    <option selected>Select classification</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">C</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="routeSelect">Number of Cash Registers</label>
                <select class="form-control" name="cashregisters" aria-label="Select Route">
                    <option selected>Select Number</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value=">3">>3</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="routeSelect">Select Footfall</label>
                <select class="form-control" name="footfall" aria-label="Select Route">
                    <option selected>Select Footfall</option>
                    <option value=">300">>300</option>
                    <option value="200-300">200-300</option>
                    <option value="100-200">100-200</option>
                    <option value="<100">100</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="routeSelect">Product Range</label>
                <select class="form-control" name="productrange" aria-label="Select Route">
                    <option selected>Select product range</option>
                    <option value=">200">>200</option>
                    <option value="100-200">100-200</option>
                    <option value="50-100">50-100</option>
                    <option value="<50">50</option>
                </select>
            </div>

        </div>


            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
const dealerRoutes = {
    1: [ { id: 1, name: 'Route A' }, { id: 2, name: 'Route B' } ], // Dealer 1
    2: [ { id: 3, name: 'Route C' }, { id: 4, name: 'Route D' } ], // Dealer 2
    3: [ { id: 5, name: 'Route E' }, { id: 6, name: 'Route F' } ]  // Dealer 3
    // Add more dealers and their routes as needed
};

// Event listener for dealer selection change
document.getElementById('dealerSelect').addEventListener('change', function() {
    const dealerId = this.value;
    const routeSelect = document.getElementById('routeSelect');

    // Clear existing options
    routeSelect.innerHTML = '<option selected value="">Select Route</option>';

    if (dealerId) {
            $.ajax({
                url: '{{ route('admin.customer.routesget') }}',
                type: 'POST',
                data: {
                    dealer_id: dealerId,
                    _token: '{{ csrf_token() }}' // CSRF protection
                },
                success: function(routes) {
                    routes.forEach(function(route) {
                        const option = $('<option></option>').val(route.id).text(route.name);
                        routeSelect.append(option);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching routes:', error,xhr);
                }
            });
        }


});
</script>
@endsection
