@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush

@section('main')
    <h2>Forgot password</h2>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li class="form-validation-error">{{ $error  }}</li>
            @endforeach
        </ul>
    @endif
    <section class="form-container">
        <form class="form" method="POST" action="{{ route('password.email') }}">
            @csrf
            <p class="big-p">Type your email address and we will email you a password reset link that will allow you to choose a new one.</p>
            <label for="email">Email: </label>
            <input id="email" type="email" name="email">
            <button class="accept-button">Send password reset link</button>
        </form>
    </section>
@endsection
