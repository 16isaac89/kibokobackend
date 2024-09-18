@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        @can('expense_create')
    <a class="btn btn-success" href="{{route('admin.expenses.create')}}">
                {{ trans('global.add') }} Expense
            </a>
            @endcan
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-expenses">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        ID
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Description
                    </th>
                    <th>
                        Category
                    </th>
                    <th>
                        Amount
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
            <tbody>
                    @foreach($expenses as $expense)
                        <tr data-entry-id="{{ $expense->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $expense->id ?? '' }}
                            </td>
                            <td>
                                {{ $expense->name ?? '' }}
                            </td>
                            <td>
                                {{ $expense->description ?? '' }}
                            </td>
                            <td>
                                {{ $expense->category->name ?? '' }}
                            </td>
                            <td>
                                {{ $expense->amount ?? '' }}
                            </td>
                            <td>
                            @can('expense_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.expenses.edit',$expense->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                            @can('expense_delete')
                                    <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="expense" value="{{ $expense->id }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan 
                            </td>
                         

                        </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
$(document).ready(function() {
    $('.datatable-expenses').DataTable();
} );
</script>
@endsection