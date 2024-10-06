@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Income and Expense Ratio Details</h1>

    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>
    <a href="{{ route('income_expense_ratio') }}" class="btn btn-secondary mb-3">Back to Income and Expense Ratio</a>

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
                                    <button class="btn btn-info" data-toggle="collapse" data-target="#incomeDetails{{ $categoryId }}">View Details</button>
                                    <div id="incomeDetails{{ $categoryId }}" class="collapse">
                                        <ul>
                                            @foreach($incomes as $income)
                                                <li>
                                                    ${{ number_format($income->amount, 2) }} - {{ $income->date }} - {{ $income->user->name }} 
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
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
                                    <button class="btn btn-info" data-toggle="collapse" data-target="#expenseDetails{{ $categoryId }}">View Details</button>
                                    <div id="expenseDetails{{ $categoryId }}" class="collapse">
                                        <ul>
                                            @foreach($expenses as $expense)
                                                <li>
                                                    ${{ number_format($expense->amount, 2) }} - {{ $expense->date }} - {{ $expense->user->name }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            <h3>Income and Expense Summary</h3>
            <p>Total Income: ${{ number_format($totalIncomes, 2) }}</p>
            <p>Total Expenses: ${{ number_format($totalExpenses, 2) }}</p>
        </div>
    </div>
</div>
@endsection
