@extends('layouts.dealer')

@section('styles')
<style>
    .table td {
        position: relative;
    }
</style>
@endsection

@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <strong>ADD {{ $product->product->name }} Stock</strong>
    </div>

    <div class="card-body">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <form method="post" action="{{ route('dealer.product.saveaddbatch') }}">
            @csrf
            <input type="hidden" name="product" value="{{ $product->id }}">

            <div class="table-responsive mb-3">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th style="text-align: center;">Action</th>
                            <th style="text-align: center;">Stock</th>
                            <th style="text-align: center;">Selling Price</th>
                            <th style="text-align: center;">Invoice</th>
                            <th style="text-align: center;">Received At</th>
                            <th style="text-align: center;">Expiry</th>
                            <th style="text-align: center;">Cost</th>
                            <th style="text-align: center;">Purchase Type</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="chk" />
                            </td>
                            <td>
                                <input type="text" name="stocks" class="form-control" placeholder="Enter stock" required />
                            </td>
                            <td>
                                <input type="text" name="prices" class="form-control" placeholder="Enter selling price" required />
                            </td>
                            <td>
                                <input type="text" name="invoices" class="form-control" placeholder="Enter invoice number" required />
                            </td>
                            <td>
                                <input type="text" name="receivedate" class="form-control date" placeholder="YYYY-MM-DD" required />
                            </td>
                            <td>
                                <input type="text" name="expiry" class="form-control date" placeholder="YYYY-MM-DD" required />
                            </td>
                            <td>
                                <input type="text" name="cost" class="form-control" placeholder="Enter cost" />
                            </td>
                            <td>
                                <select class="form-control" name="purchase_type" required>
                                    <option value="" selected>Select Purchase Type</option>
                                    <option value="101">Import</option>
                                    <option value="102">Local Purchase</option>
                                    <option value="103">Manufacture/Assembling</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
@parent
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
        });
    });
</script>
@endsection
