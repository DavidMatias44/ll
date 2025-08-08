@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush

@section('main')
    <section class="form-container">
        <form method='POST' class="form" action={{ route('verification.send') }}>
            @csrf
            @method('POST')
            <label class="big-label">An email was sent to you. <br> Please verify your email!</label>
            <button>Send verification link again.</button>
        </form>
    </section>
@endsection
