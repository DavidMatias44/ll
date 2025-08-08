@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush

@section('main')
    <h2>Login</h2>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li class="form-validation-error">{{ $error  }}</li>
            @endforeach
        </ul>
    @endif
    <div class='form-container'>
        <form method="POST" action="{{ route('login') }}" class="form">
            @csrf
            <label for="email">Email: </label>
            <input type="email" name="email" id="email">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password">
            <button class="accept-button" type="submit">Login</button>

            <p>If you do not have an account click <a href="{{ route('register') }}">here</a>.</p>
            <p>Forgot your password? Click <a href="{{ route('password.request') }}">here</a>.</p>
        </form>
    </div>
@endsection