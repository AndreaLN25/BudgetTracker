@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalles de Ingresos y Gastos</h2>

    <div class="row">
        <div class="col-md-6">
            <h3>Ingresos</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incomes as $income)
                    <tr>
                        <td>{{ $income->category->name }}</td>
                        <td>{{ $income->description ?? 'Sin descripción' }}</td>
                        <td>${{ number_format($income->amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($income->date)->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="1">Total</th>
                        <th>${{ number_format($incomes->sum('amount'), 2) }}</th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-md-6">
            <h3>Gastos</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                    <tr>
                        <td>{{ $expense->category->name }}</td>
                        <td>{{ $expense->description ?? 'Sin descripción' }}</td>
                        <td>${{ number_format($expense->amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="1">Total</th>
                        <th>${{ number_format($expenses->sum('amount'), 2) }}</th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div>
@endsection
