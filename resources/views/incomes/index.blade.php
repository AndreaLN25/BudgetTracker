@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Income List</h1>
    <a href="{{ route('incomes.create') }}" class="btn btn-success mb-3">Add Income</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($incomes->isEmpty())
        <div class="alert alert-warning">No incomes found.</div>
    @else
        <div class="card mb-4">
            <div class="card-header">
                <h5>Filter Incomes</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('incomes.index') }}">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Search by description" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <select name="category_id" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="number" name="min_amount" class="form-control" placeholder="Min Amount" value="{{ request('min_amount') }}" step="0.01">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="number" name="max_amount" class="form-control" placeholder="Max Amount" value="{{ request('max_amount') }}" step="0.01">
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incomes as $income)
                <tr>
                    <td>{{ $income->category->name }}</td>
                    <td>{{ $income->amount }}</td>
                    <td>{{ $income->description }}</td>
                    <td>{{ \Carbon\Carbon::parse($income->date)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this income?')">Delete</button>
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
