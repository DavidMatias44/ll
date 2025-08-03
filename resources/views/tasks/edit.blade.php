@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/forms.css')  }}">
@endpush

@section('main')
    <h2>Edit task.</h2>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li class="form-validation-error">{{ $error }}</li>
            @endforeach 
        </ul>
    @endif
    <div class="form-container">
        <form method="POST" action="{{ route('tasks.update', $task) }}" class="form">
            @csrf
            @method('PUT')
            <label for="name">Name: </label>
            <input type="text" name="name" id="name" value="{{ $task->name }}">
            <label for="description">Description: </label>
            <textarea name="description" id="description">{{ $task->description }}</textarea>
            <label for="priority">Priority: </label>
            <select name="priority" id="priority">
                @foreach (App\Enums\Priority::cases() as $priority)
                    <option value="{{ $priority->value }}" {{ $task->priority == $priority ? 'selected' : '' }}>
                        {{ $priority->label() }}
                    </option>
                @endforeach
            </select>
            <label for="state">State: </label>
            <select name="state" id="state">
                @foreach (App\Enums\State::cases() as $state)
                    <option value="{{ $state->value }}" {{ $task->state == $state ? 'selected' : '' }}>
                        {{ $state->label() }}
                    </option>
                @endforeach
            </select>
            <button class="accept-button" type="submit">Edit task</button>
            <button class="cancel-button" type="button" onclick="location.href='{{ route('tasks.index') }}'">
                Cancel
            </button>
        </form>
    </div>
@endsection
