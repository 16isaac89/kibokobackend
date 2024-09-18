@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        @can('expense_category_create')
            <a class="btn btn-success" href="{{route('admin.expensecategories.create')}}">
                {{ trans('global.add') }} Expense expensecategory
            </a>
            @endcan
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-expensecat">
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
                        &nbsp;
                    </th>
                </tr>
            </thead>
            <tbody>
                    @foreach($categories as $key => $expensecategory)
                        <tr data-entry-id="{{ $expensecategory->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $expensecategory->id ?? '' }}
                            </td>
                            <td>
                                {{ $expensecategory->name ?? '' }}
                            </td>
                            <td>
                            @can('expense_category_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.expensecategories.edit',$expensecategory->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                            @can('expense_category_delete')
                                    <form action="{{ route('admin.expensecategories.destroy', $expensecategory->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="expensecategory" value="{{ $expensecategory->id }}">
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
    $('.datatable-expensecat').DataTable();
} );
</script>
@endsection