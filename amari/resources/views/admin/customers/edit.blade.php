@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Customer
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.customers.update', $customer->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            {{-- Distributor --}}
            <div class="form-group col-md-12">
                <label for="dealerSelect">Distributor</label>
                <select class="form-control" name="dealer_id" id="dealerSelect">
                    <option value="">Select distributor</option>
                    @foreach($dealers as $dealer)
                        <option  value="{{ $dealer->id }}" {{ $customer->dealer_code == $dealer->code ? 'selected' : '' }}>
                            {{ $dealer->tradename }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Personal Info --}}
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Full Name</label>
                    <input class="form-control" type="text" name="fullname" value="{{ $customer->name }}">
                </div>

                <div class="form-group col-md-6">
                    <label>Phone</label>
                    <input class="form-control" type="text" name="phone" value="{{ $customer->phone }}">
                </div>
            </div>

            {{-- Contact --}}
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input class="form-control" type="text" name="email" value="{{ $customer->email }}">
                </div>

                <div class="form-group col-md-6">
                    <label>Address</label>
                    <input class="form-control" type="text" name="address" value="{{ $customer->address }}">
                </div>
            </div>

            {{-- Route --}}
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Route</label>
                    <select class="form-control" id="routeSelect" name="route_id">
                        <option value="">Select Route</option>
                    </select>
                </div>
            </div>

            {{-- Classification --}}
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Customer Category</label>
                    <select class="form-control" name="custcategory">
                        <option value="">Select Category</option>
                        <option value="wholesale" {{ $customer->custcategory == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                        <option value="retail" {{ $customer->custcategory == 'retail' ? 'selected' : '' }}>Retail</option>
                        <option value="supermarket" {{ $customer->custcategory == 'supermarket' ? 'selected' : '' }}>Supermarket</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>Classification</label>
                    <select class="form-control" name="classification">
                        <option value="">Select classification</option>
                        @foreach(['A','B','C','D'] as $class)
                            <option value="{{ $class }}" {{ $customer->classification == $class ? 'selected' : '' }}>
                                {{ $class }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button class="btn btn-danger" type="submit">
                Save
            </button>
        </form>
    </div>
</div>

@endsection
@section('scripts')
<script>
$(document).ready(function () {

    const dealerSelect = $('#dealerSelect');
    const routeSelect = $('#routeSelect');
    const existingRouteId = "{{ $customer->route_id }}";

    function loadRoutes(dealerId, preselectRoute = null) {
        routeSelect.html('<option value="">Loading...</option>');

        $.ajax({
            url: "{{ route('admin.customer.routesget') }}",
            type: "POST",
            data: {
                dealer_id: dealerId,
                _token: "{{ csrf_token() }}"
            },
            success: function (routes) {
                routeSelect.html('<option value="">Select Route</option>');

                routes.forEach(route => {
                    routeSelect.append(
                        `<option value="${route.id}"
                            ${route.id == preselectRoute ? 'selected' : ''}>
                            ${route.name}
                        </option>`
                    );
                });
            },
            error: function (xhr) {
                console.log("Route loading error:", xhr.responseText);
            }
        });
    }

    // Load routes when dealer is changed
    dealerSelect.on('change', function () {
        const dealerId = $(this).val();
        if (dealerId) {
            loadRoutes(dealerId);
        } else {
            routeSelect.html('<option value="">Select Route</option>');
        }
    });

    // On page load: auto-load customer's routes & auto-select the current one
    if (dealerSelect.val()) {
        loadRoutes(dealerSelect.val(), existingRouteId);
    }

});
</script>
@endsection
