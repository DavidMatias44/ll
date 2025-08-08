@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush

@section('main')
    <h2>Reset password form</h2>
    <section class="form-container">
        <form method="POST"class="form" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <label for="email">Email: </label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password">
            <label for="password_confirmation">Confirm password: </label>
            <input type="password" name="password_confirmation" id="password_confirmation">
            <button type="submit" class="accept-button">Reset password</button>
        </form>
    </section>
@endsection
