@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="{{ route('incomes.index') }}" class="text-decoration-none">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Income</h5>
                        <p class="card-text h2">${{ number_format($incomes, 2) }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('expenses.index') }}" class="text-decoration-none">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Total Expenses</h5>
                        <p class="card-text h2">${{ number_format($expenses, 2) }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white {{ $balance >= 0 ? 'bg-info' : 'bg-warning' }}">
                <div class="card-body">
                    <h5 class="card-title">Balance</h5>
                    <p class="card-text h2">${{ number_format($balance, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Financial Summary</h3>
            <p>
                Your total income is <strong>${{ number_format($incomes, 2) }}</strong>, and your total expenses are <strong>${{ number_format($expenses, 2) }}</strong>.
            </p>
            <p>
                This gives you a balance of <strong>${{ number_format($balance, 2) }}</strong>.
                @if($balance >= 0)
                    Keep up the good work managing your finances!
                @else
                    You are in the negative; consider reviewing your expenses.
                @endif
            </p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Income Distribution by Category</h3>
            <canvas id="incomeChart"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Expense Distribution by Category</h3>
            <canvas id="expenseChart"></canvas>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h3>Trends Over Last 6 Months</h3>
            <canvas id="trendsChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const incomeCtx = document.getElementById('incomeChart').getContext('2d');
    const expenseCtx = document.getElementById('expenseChart').getContext('2d');

    const incomeData = {
        labels: @json($incomeLabels),
        datasets: [{
            label: 'Income by Category',
            data: @json($incomeData),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    const expenseData = {
        labels: @json($expenseLabels),
        datasets: [{
            label: 'Expenses by Category',
            data: @json($expenseData),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    };

    const incomeChart = new Chart(incomeCtx, {
        type: 'pie',
        data: incomeData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        }
    });

    const expenseChart = new Chart(expenseCtx, {
        type: 'pie',
        data: expenseData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        }
    });

</script>

<script>
    const trendsCtx = document.getElementById('trendsChart').getContext('2d');

    const trendsData = {
        labels: @json($months),
        datasets: [
            {
                label: 'Income',
                data: @json($incomeTrends),
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
            },
            {
                label: 'Expenses',
                data: @json($expenseTrends),
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: true,
            },
        ]
    };

    const trendsChart = new Chart(trendsCtx, {
        type: 'line',
        data: trendsData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        }
    });
</script>

@endsection
