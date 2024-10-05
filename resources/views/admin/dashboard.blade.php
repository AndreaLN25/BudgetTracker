@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Dashboard - Superadmin</h1>

    <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <a href="{{ route('users.index') }}" class="card shadow-sm text-decoration-none d-flex flex-column h-100 border border-dark">
                <div class="card-body text-dark text-center d-flex flex-column justify-content-center flex-grow-1">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text h2">{{ $userCount }}</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('incomes.index') }}" class="card shadow-sm text-decoration-none d-flex flex-column h-100 border border-dark">
                <div class="card-body text-dark text-center d-flex flex-column justify-content-center flex-grow-1">
                    <h5 class="card-title">Total Income</h5>
                    <p class="card-text h2">${{ number_format($totalIncomes, 2) }}</p>
                    <div class="bg-light text-dark p-2 mt-2 rounded">
                        <p class="card-text h5">Incomes Count: {{ $incomeCount }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('expenses.index') }}" class="card shadow-sm text-decoration-none d-flex flex-column h-100 border border-dark">
                <div class="card-body text-dark text-center d-flex flex-column justify-content-center flex-grow-1">
                    <h5 class="card-title">Total Expenses</h5>
                    <p class="card-text h2">${{ number_format($totalExpenses, 2) }}</p>
                    <div class="bg-light text-dark p-2 mt-2 rounded">
                        <p class="card-text h5">Expenses Count: {{ $expenseCount }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('categories.index') }}" class="card shadow-sm text-decoration-none d-flex flex-column h-100 border border-dark">
                <div class="card-body text-dark text-center d-flex flex-column justify-content-center flex-grow-1">
                    <h5 class="card-title">Total Categories</h5>
                    <p class="card-text h2">{{ $categoryCount }}</p>
                </div>
            </a>
        </div>
    </div>
        {{-- <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body bg-secondary text-white text-center">
                    <h5 class="card-title">Active Users</h5>
                    <p class="card-text h2">{{ $activeUsers }}</p>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row mt-5">
        <div class="col-md-12 text-center mb-4">
            <h3>Distribution by Category</h3>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Distribution of Income by Category</h4>
                </div>
                <div class="card-body text-center">
                    <canvas id="incomeCategoryChart" width="300" height="300" style="max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Distribution of Expenses by Category</h4>
                </div>
                <div class="card-body text-center">
                    <canvas id="expenseCategoryChart" width="300" height="300" style="max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Income and Expense Ratio</h4>
                </div>
                <div class="card-body text-center">
                    <canvas id="incomeExpenseRatioChart" width="300" height="300" style="max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>User Distribution of Income and Expenses</h4>
                </div>
                <div class="card-body text-center">
                    <canvas id="userDistributionChart" width="300" height="300" style="max-width: 100%; cursor: pointer;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>User Incomes</h4>
                </div>
                <div class="card-body text-center">
                    <canvas id="userIncomeChart" width="300" height="300" style="max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>User Expenses</h4>
                </div>
                <div class="card-body text-center">
                    <canvas id="userExpenseChart" width="300" height="300" style="max-width: 100%;"></canvas>
                </div>
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
            maintainAspectRatio: false,
            onClick: (event) => {
                const activePoints = incomeExpenseRatioChart.getElementsAtEventForMode(event, 'nearest', {
                    intersect: true
                }, false);
                if (activePoints.length > 0) {
                    // Redirigir a la vista del Income and Expense Ratio
                    window.location.href =
                    "{{ route('income_expense_ratio') }}"; // Cambia esto a la ruta adecuada si es necesario
                }
            },
            plugins: {
                legend: {
                    position: 'right',
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
            data: @json($userDataBalances),
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
            maintainAspectRatio: false,
            onClick: (event) => {
                const activePoints = userDistributionChart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, false);
                if (activePoints.length > 0) {
                    const selectedIndex = activePoints[0].index;
                    const userId = {{ json_encode($userIds) }}[selectedIndex];
                    window.location.href = `/users/${userId}`;
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                            const percentage = ((value / total) * 100).toFixed(2) + '%';
                            return `${label}: ${value} (${percentage}) - Click for details`;
                        }
                    }
                },
                legend: {
                    position: 'right',
                },
            },
        }
    });

    // User Incomes Chart
    const userIncomeCtx = document.getElementById('userIncomeChart').getContext('2d');
    const userIncomeData = {
        labels: @json($userLabels),
        datasets: [{
            label: 'User Incomes',
            data: @json($userDataIncomes),
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
        }]
    };

    const userIncomeChart = new Chart(userIncomeCtx, {
        type: 'bar',
        data: userIncomeData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            onClick: (event) => {
                const activePoints = userIncomeChart.getElementsAtEventForMode(event, 'nearest', {
                    intersect: true
                }, false);
                if (activePoints.length > 0) {
                    const selectedIndex = activePoints[0].index;
                    const userId = {{ json_encode($userIds) }}[selectedIndex]; // Obtener el ID del usuario correspondiente
                    window.location.href = `/users/${userId}/incomes`; // Redirigir a la vista de ingresos del usuario
                }
            }
        }
    });

    // User Expenses Chart
    const userExpenseCtx = document.getElementById('userExpenseChart').getContext('2d');
    const userExpenseData = {
        labels: @json($userLabels),
        datasets: [{
            label: 'User Expenses',
            data: @json($userDataExpenses),
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
        }]
    };

    const userExpenseChart = new Chart(userExpenseCtx, {
        type: 'bar',
        data: userExpenseData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            onClick: (event) => {
                const activePoints = userExpenseChart.getElementsAtEventForMode(event, 'nearest', {
                    intersect: true
                }, false);
                if (activePoints.length > 0) {
                    const selectedIndex = activePoints[0].index;
                    const userId = {{ json_encode($userIds) }}[selectedIndex]; // Obtener el ID del usuario correspondiente
                    window.location.href = `/users/${userId}/expenses`; // Redirigir a la vista de gastos del usuario
                }
            }
        }
    });
</script>
@endsection
