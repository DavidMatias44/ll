@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush

@section('main')
    <h2>Create new task.</h2>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li class="error">{{ $error }}</li>
            @endforeach 
        </ul>
    @endif

    <div class="form-container">
        <form method="POST" action="{{ route('tasks.store') }}" class="form">
            @csrf
            <label for="name">Name: </label>
            <input type="text" name="name" id="name">
            <label for="description">Description: </label>
            <textarea name="description" id="description"></textarea>
            <label for="priority">Priority: </label>
            <select name="priority" id="priority">
                <option value="" selected disabled hidden>Choose here</option>
                @foreach (App\Enums\Priority::cases() as $priority)
                    <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                @endforeach
            </select>
            <label for="state">State: </label>
            <select name="state" id="state">
                @php
                    $todoState = App\Enums\State::TODO;
                @endphp
                <option value="{{ $todoState->value }}" selected hidden>
                    {{ $todoState->label() }}
                </option>
            </select>
            <button class="accept-button" type="submit">Create new task</button>
            <button class="cancel-button" type="button" onclick="location.href='{{ route('tasks.index') }}'">
                Cancel
            </button>
        </form>
    </div>
@endsection
