@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    @auth
        <h1 class="mb-4">Bienvenido, {{ Auth::user()->name }}</h1>
        <p class="lead">¿Estás seguro de que deseas cerrar sesión?</p>

        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>

        <a href="{{ url('home') }}" class="btn btn-secondary ml-3">Cancelar</a>
    @endauth
</div>
@endsection
