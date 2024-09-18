@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.expenses.update", [$expense->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">Name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $expense->name) }}" required>
            </div>


            <div class="form-group">
                <label class="required" for="title">Description</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', $expense->description) }}" required>
            </div>
            <div class="form-group">
                <label class="required" for="title">Category</label>
                <select class="form-control" name="expense_category_id" aria-label="Select expense type">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{  $category->id === $expense->expense_category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                    </select>
            </div>
            <div class="form-group">
                <label class="required" for="title">Amount</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount',  $expense->amount) }}" required>
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