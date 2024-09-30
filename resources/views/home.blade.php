@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
    <h1>Welcome to Budget Tracker</h1>
    <p>Manage your incomes and expenses easily</p>

    @if(Auth::check())
        <a href="{{ route('incomes.index') }}" class="btn btn-primary">View Incomes</a>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">View Expenses</a>
    @else
        <a href="{{ route('login') }}" class="btn btn-warning">Login</a>
        <a href="{{ route('register') }}" class="btn btn-success">Register</a>
    @endif
</div>
@endsection
