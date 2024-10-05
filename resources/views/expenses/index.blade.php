@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Expense List</h1>

        @if (auth()->user()->isSuperAdmin())
            <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>
        @else
            <a href="{{ route('home') }}" class="btn btn-secondary mb-3">Back to Home</a>
        @endif

        <a href="{{ route('expenses.create') }}" class="btn btn-success mb-3">Add Expense</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($expenses->isEmpty())
            <div class="alert alert-warning">No expenses found.</div>
        @else
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Filter Expenses</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('expenses.index') }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search by description" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <select name="category_id" class="form-control">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="number" name="min_amount" class="form-control" placeholder="Min Amount"
                                    value="{{ request('min_amount') }}" step="0.01">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="number" name="max_amount" class="form-control" placeholder="Max Amount"
                                    value="{{ request('max_amount') }}" step="0.01">
                            </div>
                            <div class="col-md-4 mb-3">
                                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                <a href="{{ route('expenses.index') }}" class="btn btn-secondary btn-block">Reset Filters</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)
                        <tr>
                            <td>{{ $expense->user->name }}</td>
                            <td>{{ $expense->category->name }}</td>
                            <td>{{ $expense->amount }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this expense?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="alert alert-info">
                <strong>Total: </strong>{{ $total }}
            </div>
        @endif
    </div>
@endsection
