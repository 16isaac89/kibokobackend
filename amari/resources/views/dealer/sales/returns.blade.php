@extends('layouts.dealer')
@section('styles')
<style>
td.details-control {
    background: url('/images/logo/plus.png') no-repeat center center;
    cursor: pointer;
}
tr.details td.details-control {
    background: url('/images/logo/minus.png') no-repeat center center;
}
</style>
@endsection
@section('content')
<div class="am-pagebody">
  @include('dealer.sales.modals.document')
  @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
@if (session('errors'))
    <div class="alert alert-danger text-center msg" id="error">
    <strong>{{ session('errors') }}</strong>
    </div>
@endif
<form class="form-inline py-3" method="post" action="{{route('dealer.addreturnview')}}">
  @csrf
  <input type="text" name="receipt" class="form-control" placeholder="Receipt number"/>
  <button type="submit" class="btn btn-primary">Search</button>
</form>


<div class="card pd-20 pd-sm-40">
    <form method="post" action="{{route('dealer.searchreturns')}}">
        @csrf
    <div class="row">
      
    <div class="col-6">
                <select class="form-control select2" data-placeholder="Choose sale status" name="status">
                  <option label="Choose sale status"></option>
                  <option value="pending">Pending</option>
                  <option value="approved">Approved</option>
                </select>
              </div><!-- col-4 -->

              <div class="col-2 wd-100">
            <div class="input-group">
            <button type="submit" class="btn btn-primary btn-icon mg-r-5 mg-b-10"><div><i class="fa fa-search"></i></div></button>
            </div>
          </div><!-- wd-200 -->      
                       
</div>
</div>
</form>


    <div class="card pd-5 pd-sm-20">
      <div class="row">
<!-- <button id="btn-show-all-children col-4" style="width:100px;border-radius:25px;margin:10px;" type="button">Expand All</button>
<button id="btn-hide-all-children col-4" style="width:100px;border-radius:25px;margin:10px;" type="button">Collapse All</button> -->
</div>
      <div class="table-wrapper">
        <table id="sales"  class="table display responsive nowrap">
          <thead>
            <tr>
            <th></th>
              <th>ID</th>
              <th>Date</th>
              <th>Customer</th>
              <th >Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($returns as $return)
            <tr>
              <td></td>
            <td>{{$return->id}}</td>
              <td>{{$return->created_at}}</td>
              <td>{{$return->customer->name ?? ''}}</td>
              <td>{{$return->status ?? ''}}</td>
              <td>
                @if($return->status === 'pending')
              <a class="btn btn-primary btn-icon mg-r-5 mg-b-10" href="{{route('dealer.getreturn',['return'=>$return->id])}}"><div><i class="fa fa-search"></i></div></a>
              @else
              <a class="btn btn-primary btn-icon mg-r-5 mg-b-10"><div><i class="fa fa-eye"></i></div></a>
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
 
@endsection
@section('scripts')


@endsection