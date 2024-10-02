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
