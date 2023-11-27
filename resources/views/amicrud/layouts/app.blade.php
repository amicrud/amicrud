<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title ?? "AmiCrud"}}</title>
    @stack('amicrud_css')
    <style>
        .sidebar {
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: #333;
        }
        .sidebar .nav-link.active {
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Products
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Admin Dashboard</a>
                    <ul class="navbar-nav ml-auto">
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                Notifications
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li> --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="#">My Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Content -->
            @yield('content')
        </main>
    </div>
</div>
@stack('amicrud_js')
</body>
</html>
