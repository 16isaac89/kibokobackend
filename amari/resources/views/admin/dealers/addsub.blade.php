@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       <span><b>Total:<p id="total"></p></b></span>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.dealersubs.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="dealer_id" value="{{ $dealer->id }}">
            <div class="form-group">
                <label class="required" for="title">Total(Years/Months)</label>
                <input class="form-control" type="text" name="totalmonths" id="totalmonths" required>
            </div>
            <div class="form-group">
            <select class="form-control" required name="subscription_id" id="subscription"  aria-label="Default select example">
                <option selected value="">Select Type of Subscription</option>
                @foreach ($subscriptions as $subscription)
                @if($subscription->name == 'Trial' && ($dealer->tried == 1 || $dealer->tried == "1"))
                @continue
                @endif
                <option value="{{ $subscription->id }}" {{ $dealer->subscription_id === $subscription->id ? 'selected':'' }}>{{ $subscription->name }}</option>

                @endforeach
              </select>
            </div>
<div class="row">
            <div class="form-group col-4">
                <label class="required" for="title">From</label>
                <input class="form-control date" type="text" name="from_date"  required>
            </div>
            <div class="form-group col-4">
                <label class="required" for="title">To</label>
                <input class="form-control date" type="text" name="to_date"  required>
            </div>

            <div class="form-group col-4">
                <label for="exampleFormControlTextarea3">Paid On</label>
                <input class="form-control date" type="text" name="paidon"  required>
              </div>
            </div>
            <div class="row">
            <div class="form-group col-6">
                <label for="exampleFormControlTextarea3">Transaction ID</label>
                <input class="form-control" type="text" name="transaction"  required>
              </div>
              <div class="form-group col-6">
                <label for="exampleFormControlTextarea3">Payment Method</label>
                <input class="form-control" type="text" name="ptmethod"  required>
              </div>
            </div>
            <div class="form-group col-6">
                <label for="exampleFormControlTextarea3">Discount</label>
                <input class="form-control" type="text" name="discount"  required>
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
        document.getElementById('subscription').addEventListener('change', function() {
            let sub = this.value;
            // alert(sub)

            let token = "{{ csrf_token()}}";
            $.ajax({
                url: "{{ route('admin.dealer.subprice') }}",
                type: 'POST',
                data: {
                    _token:token,
                   sub:sub
                },
                success: function(response) {
                //     console.log(response)
                // return
          //  document.getElementById('price').value = response.price;
            document.getElementById('total').innerHTML = response.price*document.getElementById('totalmonths').value;

                },
                error: function(xhr) {
                    console.log(xhr)
                }

            });



        })

    </script>
@endsection
