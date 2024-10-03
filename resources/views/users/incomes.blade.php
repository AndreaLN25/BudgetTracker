@extends('layouts.app')

@php
    use Carbon\Carbon;
@endphp

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">{{ $user->name }}'s Incomes</h1>

    <form method="GET" action="{{ route('users.incomes', $user->id) }}" class="mb-3">
        <div class="form-group">
            <label for="categoryFilter">Filter by Category</label>
            <select name="category_id" id="categoryFilter" class="form-control" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    @if ($category->type === 'income') 
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
    </form>

    @if ($incomes->isEmpty())
        <p>No incomes found for this user.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($incomes as $income)
                    <tr>
                        <td>{{ $income->category->name }}</td>
                        <td>${{ number_format($income->amount, 2) }}</td>
                        <td>{{ Carbon::parse($income->date)->format('Y-m-d') }}</td>
                    </tr>
                    @php $total += $income->amount; @endphp
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td>${{ number_format($total, 2) }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif
</div>
@endsection
