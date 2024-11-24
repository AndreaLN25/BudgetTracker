@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Incomes for the category: {{ $category->name }}</h1>

    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a> 

    @if($incomes->isEmpty())
        <p>No incomes recorded in this category.</p>
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
                @foreach($incomes as $income)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($income->date)->format('d-m-Y') }}</td>
                        <td>${{ number_format($income->amount, 2) }}</td>
                        <td>{{ $income->description }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>${{ number_format($incomes->sum('amount'), 2) }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif

</div>
@endsection
