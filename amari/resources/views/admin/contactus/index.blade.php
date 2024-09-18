@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
       Contact Us Messages
    </div>

    @if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-messages">
                <thead>
                    <tr>
                        <th width="10">

                        </th>

                        <th>
                            Name
                        </th>
                        <th>
                           Email
                        </th>
                        <th>
                        Phone
                        </th>
                        <th>
                           Message
                        </th>
                        <th>
                            Status
                        </th>

                        <th>
                        Created On
                        </th>
                        <th>
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr data-entry-id="{{ $message->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $message->name ?? '' }}
                            </td>
                            <td>
                                {{ $message->email ?? '' }}
                            </td>
                             <td>
                                {{ $message->phone ?? '' }}
                            </td>
                            <td>
                                {{ $message->message ?? '' }}
                            </td>
                             <td>
                               @if($message->status === 0)
                               <b><span class="badge badge-warning">Not Handled</span></b>
                               @else
                               <b><span class="badge badge-success">Handled</span></b>
                               @endif
                            </td>
                             <td>
                                {{ $message->created_at ?? '' }}
                            </td>
                            <td>
                                @if($message->status === 0)
                                <a class="btn btn-success" href="{{ route('admin.contactus.handle',$message->id) }}">
                                    Handle
                                </a>
                                @endif
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
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-messages:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>



@endsection
