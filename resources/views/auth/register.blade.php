@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush

@section('main')
    <h2>Register</h2>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li class="error">{{ $error }}</li>                
            @endforeach
        </ul>
    @endif
    <div class="form-container">
        <form method="POST" action="{{ route('register') }}" class="form">
            @csrf
            <label for="name">Username: </label>
            <input type="text" name="name" id="name">
            <label for="email">Email: </label>
            <input type="email" name="email" id="email">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password">
            <label for="password_confirmation">Confirm password: </label>
            <input type="password" name="password_confirmation" id="password_confirmation">
            <button type="submit">Login</button>

            <p>If you already have an account click <a href="{{ route('login') }}">here</a>.</p>
        </form>
    </div>
@endsection