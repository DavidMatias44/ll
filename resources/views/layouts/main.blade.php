<!DOCTYPE html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Task manager</title>

        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        @stack('css-files')
        @stack('scripts')
    </head>
    <body>
        <nav>
            <div>Task manager</div>
            <ul>
                @auth
                    @if (!Route::is('verification.notice'))
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}">My account</a></li>
                    @endif

                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <a href="#" onclick="logout()">Logout</a>
                        </form>
                    </li>
                @endauth

                @guest
                    @if (!(Route::is('login') || Route::is('register')))
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Create an account</a></li>
                    @endif
                @endguest
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
