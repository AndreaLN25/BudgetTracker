@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Income</h1>

        @if (auth()->user()->isSuperAdmin())
            <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>
        @else
            <a href="{{ route('home') }}" class="btn btn-secondary mb-3">Back to Home</a>
        @endif

        <form action="{{ route('incomes.update', $income->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="category_id">Category</label>
                <input type="text" class="form-control" name="category_id" value="{{ $income->category_id }}" required>
            </div>

            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" name="amount" value="{{ $income->amount }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" name="description" value="{{ $income->description }}">
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" name="date" value="{{ $income->date }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
