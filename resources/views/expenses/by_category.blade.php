@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Expenses for the category: {{ $category->name }}</h1>

    @if($expenses->isEmpty())
        <p>No expenses recorded in this category.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                        <td>${{ number_format($expense->amount, 2) }}</td>
                        <td>{{ $expense->description }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>${{ number_format($expenses->sum('amount'), 2) }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif

</div>
@endsection
