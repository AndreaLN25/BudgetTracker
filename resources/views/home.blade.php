@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
    <h1>Welcome to Budget Tracker</h1>
    <p>Manage your incomes and expenses easily</p>
    <a href="{{ route('incomes.index') }}" class="btn btn-primary">View Incomes</a>
    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">View Expenses</a>
</div>
@endsection
