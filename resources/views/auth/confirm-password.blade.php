@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush

@section('main')
    <section class="form-container">
        <form method="POST" action="{{ route('password.confirm') }}" class="form">
            @csrf

            <p class="big-p">Confirm your password before continuing.</p>

            <label for="password">Password</label>
            <input type="password" name="password">
            <button class="accept-button">Confirm</button>
        </form>
    </section>
@endsection
