@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Category</h1>

    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-3">Back to Categories</a>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $category->name }}" required>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control" name="type" required>
                <option value="income" {{ $category->type == 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ $category->type == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
