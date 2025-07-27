@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('main')
    <section class="options-container">
        <button class="button-option" type="button" onclick="location.href='{{ route('tasks.index') }}'">See all your tasks.</button>
        <button class="button-option" type="button" onclick="location.href='{{ route('tasks.create') }}'">Add a new task.</button>
    </section>
@endsection
