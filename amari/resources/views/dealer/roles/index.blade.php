@extends('layouts.dealer')
@section('content')
      <div class="am-pagebody">

        <div class="card pd-20 pd-sm-40">
@if(\Gate::forUser('dealer')->allows('role_create'))
<a style="margin:10px;width:100px;border-radius:25px;" type="button" class="btn btn-primary" href="{{route('dealerroles.create')}}">
  ADD
</a>
@endif

          <div class="table-wrapper">
            <table id="roles" class="table display responsive">
              <thead>
                <tr>
                <th class="wd-15p">ID</th>
                  <th class="wd-15p">Role</th>
                  <th class="wd-15p">Permissions</th>
                  <th class="wd-15p">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($roles as $role)
                <tr>
                  <td>{{$role->id}}</td>
                  <!-- <td>Nixon</td> -->
                  <td>{{$role->title}}</td>
                 <td class="wd-15p">
                  @foreach($role->dealerpermissions as $permission)
                  <li><span class="badge badge-success">{{ $permission->title }}</span></li>
                  @endforeach
                 </td>
                 <td>
                    {{-- <a class="btn btn-primary"><b>View</b></a> --}}
                    @if(\Gate::forUser('dealer')->allows('role_edit'))
                    <a class="btn btn-success" href="{{ route('dealerroles.edit', $role->id) }}"><b>Edit</b></a>
                    @endif
                    {{-- <a class="btn btn-danger"><b>Delete</b></a> --}}
                 </td>
                  <!-- <td>t.nixon@datatables.net</td> -->
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
        (function() {
            'use strict';

$('#roles').DataTable({
  responsive: true,
  language: {
    searchPlaceholder: 'Search...',
    sSearch: '',
    lengthMenu: '_MENU_ items/page',
  }
});


        })();
    </script>
    @endsection
