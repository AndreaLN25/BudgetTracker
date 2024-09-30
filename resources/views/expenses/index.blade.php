@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Expense List</h1>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Add Expense</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($expenses->isEmpty())
        <div class="alert alert-warning">No expenses found.</div>
    @else
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
                @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->category->name }}</td>
                    <td>{{ $expense->amount }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this expense?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
