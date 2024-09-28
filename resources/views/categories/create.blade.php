@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Category</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control" name="type" required>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection