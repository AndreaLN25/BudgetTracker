@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Income and Expense Ratio</h1>

    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <h3>Ratio of Income to Expenses</h3>
            <p>Income: ${{ number_format($totalIncomes, 2) }}</p>
            <p>Expenses: ${{ number_format($totalExpenses, 2) }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            <canvas id="incomeExpenseRatioChart" width="300" height="300" style="max-width: 100%;"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
            plugins: {
                legend: {
                    position: 'right',
                },
            },
        }
    });

</script>
@endsection
