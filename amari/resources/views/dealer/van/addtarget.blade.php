@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">

    <div class="card pd-20 pd-sm-40">
	<b> {{$user->name}}</b><br/>
	{{-- <b>Target \type: {{$user->targettype}}</b><br/> --}}
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
      <div class="table-wrapper">
      {{-- @if($user->targettype === 'month') --}}
      <div id="monthtarget" style="margin:10px;">
      <b>Set target by Month</b>
      <form method="POST" action="{{route('dealer.van.targetpost')}}">
              @csrf
              <input type="hidden" name="user" value="{{$user->id}}">
              <div class="form-row mt-2">
                <div class="col">
                <div class="row">
<div class="col-6">
                    <input type="text" required class="form-control month" id="month" name="month" placeholder="Select month">
                  </div>
				  <div class="col-6">
                    <input type="text" required class="form-control year" id="year" name="year" placeholder="Select year">
                  </div>
                  <!-- <div class="col-6">
                    <input type="text" class="form-control month" id="month" name="todate" placeholder="To Date">
                  </div> -->
</div>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" required name="money" placeholder="Amount">
                  </div>

                </div>
                <input type="hidden" id="userid" name="userid" value='{{$user->id}}'>
                <button type="submit" class="btn btn-primary mt-2">Save</button>
            </form>


      </div>

      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection
@section('scripts')
<script>
    $('.month').datetimepicker({
format: 'MM',
locale: 'en',
icons: {
up: 'fas fa-chevron-up',
down: 'fas fa-chevron-down',
previous: 'fas fa-chevron-left',
next: 'fas fa-chevron-right'
}
})

$('.year').datetimepicker({
format: 'YYYY',
locale: 'en',
icons: {
up: 'fas fa-chevron-up',
down: 'fas fa-chevron-down',
previous: 'fas fa-chevron-left',
next: 'fas fa-chevron-right'
}
})
 </script>
@endsection
