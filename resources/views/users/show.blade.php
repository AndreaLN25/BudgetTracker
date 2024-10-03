@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">User Details</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Created At:</strong> {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</p>
            <p class="card-text"><strong>Updated At:</strong> {{ \Carbon\Carbon::parse($user->updated_at)->format('d M Y') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Incomes</h4>
                    @if($user->incomes->isEmpty())
                        <p>No incomes recorded.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($user->incomes as $income)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        ${{ number_format($income->amount, 2) }} - {{ $income->description }}
                                    </span>
                                    <span class="text-muted">{{ \Carbon\Carbon::parse($income->date)->format('d M Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <h5 class="mt-3">Total Incomes: ${{ number_format($totalIncomes, 2) }}</h5>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Expenses</h4>
                    @if($user->expenses->isEmpty())
                        <p>No expenses recorded.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($user->expenses as $expense)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        ${{ number_format($expense->amount, 2) }} - {{ $expense->description }}
                                    </span>
                                    <span class="text-muted">{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <h5 class="mt-3">Total Expenses: ${{ number_format($totalExpenses, 2) }}</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title">Balance</h4>
            <p class="card-text">Total Balance: ${{ number_format($balance, 2) }}</p>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('users.index') }}" class="btn btn-primary">Back to Users List</a>
    </div>
</div>
@endsection
