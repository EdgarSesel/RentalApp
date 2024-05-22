<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css?v={{ time() }}" rel="stylesheet">
    <style>
        .navbar {
            background-image: url('/storage/images/kilimas.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            height: 80px;
        }
        .user-menu {
            position: relative;
            display: inline-block;
            float: right;
        }
        .user-menu .dropdown-menu {
            right: 0;
            left: auto;
        }

        .hover-grow {
            transition: transform 0.3s;
        }

        .hover-grow:hover {
            transform: scale(1.4);
        }
        .navbar-brand {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            color: #FFFFFF !important; /* Change the font color to bright yellow */
            font-size: 24px; /* Increase the font size */
            font-weight: bold; /* Make the font bold */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand hover-grow" href="{{ route('home') }}">Kilimų nuoma</a>

    @if (Auth::check())
        <div class="ml-auto">
            <a href="{{ route('products.create') }}" class="btn btn-success">New Product</a>
            <div class="user-menu dropdown d-inline-block">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                    <a class="dropdown-item" href="{{ route('products.my') }}">My Products</a>
                    @if (Auth::user()->admin == 1)
                        <a class="dropdown-item" href="{{ route('user.management') }}">User Management</a>
                        <a class="dropdown-item" href="{{ route('product.management') }}">Product Management</a>
                    @endif
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>

                </div>
            </div>
        </div>
    @else

        <nav class="-mx-3 flex flex-1 justify-end">
            @auth
                <a
                    href="{{ url('/dashboard') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Dashboard
                </a>

            @else
                <a
                    href="{{ route('login') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Log in
                </a>

                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif

</nav>

    <main>
        @yield('content')
    </main>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
@yield('scripts')
</body>
</html>
