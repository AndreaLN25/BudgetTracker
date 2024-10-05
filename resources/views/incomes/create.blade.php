@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Income</h1>

        @if (auth()->user()->isSuperAdmin())
            <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>
        @else
            <a href="{{ route('home') }}" class="btn btn-secondary mb-3">Back to Home</a>
        @endif

        <form action="{{ route('incomes.store') }}" method="POST">
            @csrf

            <label for="category_id">Category</label>
            <select class="form-control" name="category_id" id="category_id" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
                <option value="other">Other</option>
            </select>

            <div class="form-group" id="new_category_group" style="display: none;">
                <label for="new_category">New Category</label>
                <input type="text" class="form-control" name="new_category" id="new_category">
            </div>

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

    <script>
        document.getElementById('category_id').addEventListener('change', function() {
            var newCategoryGroup = document.getElementById('new_category_group');
            if (this.value === 'other') {
                newCategoryGroup.style.display = 'block';
            } else {
                newCategoryGroup.style.display = 'none';
            }
        });
    </script>
@endsection
