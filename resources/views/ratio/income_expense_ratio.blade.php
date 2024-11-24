@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Income and Expense Ratio Details</h1>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <div class="row mb-4">
        <div class="col-md-12">
            <h3>Income Overview</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Total Amount</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incomesByCategory as $categoryId => $incomes)
                        @if ($incomes->count() > 0)
                            <tr>
                                <td>{{ $incomes->first()->category->name }}</td>
                                <td>${{ number_format($incomes->sum('amount'), 2) }}</td>
                                <td>
                                    <a href="{{ route('incomes.byCategory', $categoryId) }}" class="btn btn-info">View Details</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <h3>Expense Overview</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Total Amount</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expensesByCategory as $categoryId => $expenses)
                        @if ($expenses->count() > 0)
                            <tr>
                                <td>{{ $expenses->first()->category->name }}</td>
                                <td>${{ number_format($expenses->sum('amount'), 2) }}</td>
                                <td>
                                    <a href="{{ route('expenses.byCategory', $categoryId) }}" class="btn btn-info">View Details</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <h3 class="text-center">Income and Expense Summary</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Total Income</th>
                        <th>Total Expenses</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>${{ number_format($totalIncomes, 2) }}</td>
                        <td>${{ number_format($totalExpenses, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
