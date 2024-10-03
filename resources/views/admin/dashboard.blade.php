@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Dashboard - Superadmin</h1>

    <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <a href="{{ route('users.index') }}" class="card shadow-sm text-decoration-none">
                <div class="card-body bg-info text-white text-center">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text h2">{{ $userCount }}</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('incomes.index') }}" class="card shadow-sm text-decoration-none">
                <div class="card-body bg-success text-white text-center">
                    <h5 class="card-title">Total Income</h5>
                    <p class="card-text h2">${{ number_format($totalIncomes, 2) }}</p>
                    <p class="card-text h2">Incomes Count: {{ $incomeCount }}</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('expenses.index') }}" class="card shadow-sm text-decoration-none">
                <div class="card-body bg-danger text-white text-center">
                    <h5 class="card-title">Total Expenses</h5>
                    <p class="card-text h2">${{ number_format($totalExpenses, 2) }}</p>
                    <p class="card-text h2">Expenses Count: {{ $expenseCount }}</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('categories.index') }}" class="card shadow-sm text-decoration-none">
            <div class="card shadow-sm">
                <div class="card-body bg-warning text-white text-center">
                    <h5 class="card-title">Total Categories</h5>
                    <p class="card-text h2">{{ $categoryCount }}</p>
                </div>
            </div>
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body bg-secondary text-white text-center">
                    <h5 class="card-title">Active Users</h5>
                    <p class="card-text h2">{{ $activeUsers }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h3 class="text-center">Distribution of Income and Expenses by Category</h3>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <canvas id="incomeCategoryChart" width="600" height="400"></canvas>
                </div>
                <div class="col-md-6 mb-4">
                    <canvas id="expenseCategoryChart" width="600" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <h3>Income and Expense Ratio</h3>
            <canvas id="incomeExpenseRatioChart" width="400" height="300"></canvas>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <h3>User Distribution of Income and Expenses</h3>
            <canvas id="userDistributionChart" width="600" height="400"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Income by Category Chart
    const incomeCategoryCtx = document.getElementById('incomeCategoryChart').getContext('2d');
    const incomeCategoryData = {
        labels: @json($incomeCategoryLabels),
        datasets: [{
            label: 'Income by Category',
            data: @json($incomeCategoryData),
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
        }]
    };

    const incomeCategoryChart = new Chart(incomeCategoryCtx, {
        type: 'bar',
        data: incomeCategoryData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        }
    });

    // Expenses by Category Chart
    const expenseCategoryCtx = document.getElementById('expenseCategoryChart').getContext('2d');
    const expenseCategoryData = {
        labels: @json($expenseCategoryLabels),
        datasets: [{
            label: 'Expenses by Category',
            data: @json($expenseCategoryData),
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
        }]
    };

    const expenseCategoryChart = new Chart(expenseCategoryCtx, {
        type: 'bar',
        data: expenseCategoryData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        }
    });

    // Income and Expense Ratio Chart
    const incomeExpenseRatioCtx = document.getElementById('incomeExpenseRatioChart').getContext('2d');
    const incomeExpenseRatioData = {
        labels: ['Income', 'Expenses'],
        datasets: [{
            label: 'Ratio',
            data: [{{ $totalIncomes }}, {{ $totalExpenses }}],
            backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(255, 99, 132, 0.5)'],
        }]
    };

    const incomeExpenseRatioChart = new Chart(incomeExpenseRatioCtx, {
        type: 'pie',
        data: incomeExpenseRatioData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        }
    });

    // User Distribution Chart
    const userDistributionCtx = document.getElementById('userDistributionChart').getContext('2d');
    const userDistributionData = {
        labels: @json($userLabels),
        datasets: [{
            label: 'User Income and Expenses',
            data: @json($userData),
            backgroundColor: [
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(255, 206, 86, 0.5)',
            ],
        }]
    };

    const userDistributionChart = new Chart(userDistributionCtx, {
        type: 'pie',
        data: userDistributionData,
        options: {
            responsive: true,
            onClick: (event) => {
                const activePoints = userDistributionChart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, false);
                if (activePoints.length > 0) {
                    const selectedIndex = activePoints[0].index;
                    const userId = {{ json_encode($userIds) }}[selectedIndex];
                    window.location.href = `/users/${userId}`;
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        }
    });

</script>
@endsection
