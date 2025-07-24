<!DOCTYPE html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Task manager</title>

        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        @stack('css-files')
    </head>
    <body>
        <nav>
            <div>Task manager</div>
            <ul>
                @if (Auth::check())
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('dashboard') }}">My account</a></li>
                    {{-- <li><a href="{{ route('logout') }}">Cerrar sesión</a></li> --}}
                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <a href="#" onclick="logout()">Logout</a>
                        </form>
                    </li>
                @else
                    @if (!Route::is('login') && !Route::is('register'))
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Create an account</a></li>
                    @endif
                @endif
            </ul>
        </nav>

        <main>
            @yield('main')
        </main>

        <script>
            function logout() {
                document.getElementById('logout-form').submit();
            }
        </script>
    </body>
</html>
