<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Tracker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">Budget Tracker</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                @if (Auth::check())
                    <li class="nav-item"><a class="nav-link" href="{{ route('incomes.index') }}">Incomes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('expenses.index') }}">Expenses</a></li>

                    @if (!Auth::user()->isSuperAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    @endif

                    @if (Auth::user()->isSuperAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                    @endif
                @endif
            </ul>

            <ul class="navbar-nav ms-auto">
                @if (Auth::check())
                    <li class="nav-item">
                        <button class="nav-link btn btn-link" style="cursor: pointer;" data-bs-toggle="modal"
                            data-bs-target="#logoutModal">Logout</button>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login.store') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register.store') }}">Register</a></li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
