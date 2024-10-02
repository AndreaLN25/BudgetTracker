@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Dashboard de Superadministrador</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Usuarios</h3>
                </div>
                <div class="card-body">
                    <p>Total de usuarios: {{ $userCount }}</p>
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Ver Usuarios</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Ingresos</h3>
                </div>
                <div class="card-body">
                    <p>Total de ingresos: {{ $incomeCount }}</p>
                    <a href="{{ route('incomes.index') }}" class="btn btn-primary">Ver Ingresos</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Gastos</h3>
                </div>
                <div class="card-body">
                    <p>Total de gastos: {{ $expenseCount }}</p>
                    <a href="{{ route('expenses.index') }}" class="btn btn-primary">Ver Gastos</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Categorías</h3>
                </div>
                <div class="card-body">
                    <p>Total de categorías: {{ $categoryCount }}</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary">Ver Categorías</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Estadísticas</h3>
            <p>Aquí puedes incluir estadísticas adicionales, gráficos, etc.</p>
        </div>
    </div>
</div>
@endsection
