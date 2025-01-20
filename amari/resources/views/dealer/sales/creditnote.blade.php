@extends('layouts.dealer')

@section('styles')
<style>
    .form-control:focus {
        box-shadow: none;
        border-color: #4CAF50;
    }

    .profile-button {
        background: #4CAF50;
        color: white;
        border: none;
    }

    .profile-button:hover {
        background: #45A049;
    }

    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }

    .table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }

    .alert {
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .labels {
        font-size: 14px;
        font-weight: bold;
        color: #333;
    }

    .container {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    textarea {
        resize: none;
    }
</style>
@endsection

@section('content')
<div class="am-pagebody">
    @include('dealer.sales.modals.document')

    <div class="card pd-20">
        @if (\Session::has('errors'))
            <div class="alert alert-danger">
                <ul>
                    <li>{!! \Session::get('errors') !!}</li>
                </ul>
            </div>
        @endif

        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif

        <div class="container mb-4">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center mb-4">Receipt/Invoice Items</h4>
                    <form method="post" action="{{ route('dealer.sales.notesform') }}">
                        @csrf
                        <input type="hidden" value="{{ $sale->id }}" name="saleid">

                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Deduct</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->items as $item)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="product[]" value="{{ $item->id }}" />
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            <input type="number" readonly value="{{ $item->quantity }}" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="number" value="0" max="{{ $item->quantity }}" name="unit[]" class="form-control" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="labels">Reason</label>
                                <select required class="form-control" name="reasoncode">
                                    <option value="" selected>Select reason for credit note</option>
                                    <option value="101">Return of products due to expiry or damage</option>
                                    <option value="102">Cancellation of the purchase</option>
                                    <option value="103">Invoice amount wrongly stated due to miscalculation</option>
                                    <option value="104">Partial/complete waive-off after invoice generation</option>
                                    <option value="105">Others</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Additional Details</label>
                                <textarea class="form-control" name="reasontext" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <button type="submit" class="btn profile-button">Save Credit Note</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
