@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Income</h1>

        <form action="{{ route('incomes.store') }}" method="POST">
            @csrf

{{--             <div class="form-group">
                <label for="user_id">User</label>
                <input type="number" class="form-control" name="user_id" required>
            </div> --}}

            <label for="category_id">Category</label>
            <select class="form-control" name="category_id" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" name="amount" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" name="description">
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" name="date" required>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
@endsection
