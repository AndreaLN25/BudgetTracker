<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Tracker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        nav {
            position: sticky;
            top: 0;
            z-index: 1000;/
        }

        footer {
            background-color: #f8f9fa;
            padding: 1.5rem 0;
            margin-top: auto;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
        }

        .footer-links a {
            margin: 0 10px;
        }

        .container {
            flex: 1;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Budget Tracker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (Auth::check())
                        @if (!Auth::user()->isSuperAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('incomes.index') }}">Incomes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('expenses.index') }}">Expenses</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @endif
                </ul>

                <ul class="navbar-nav">
                    @if (Auth::check())
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login.store') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register.store') }}">Register</a>
                        </li>
                    @endif
                </ul>
            </div>
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

    <footer class="text-center mt-4">
        <div class="container">
            <p class="mb-0">© 2024 Budget Tracker. All rights reserved.</p>
            <div class="footer-links">
                <a href="#" class="text-decoration-none">Privacy Policy</a>
                <a href="#" class="text-decoration-none">Terms of Service</a>
            </div>
            <div class="mt-2">
                <a href="https://github.com/AndreaLN25" class="text-dark me-2"><i class="fab fa-github"></i></a>
                <a href="https://www.linkedin.com/in/andrea-lopez-/" class="text-dark me-2"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
