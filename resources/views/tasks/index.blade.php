@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">    
@endpush

@section('main')
    <h2>Tasks</h2>
    @if (!$tasks->isEmpty())
        <section class="options-container">
            <button class="button-option" type="button" onclick="location.href='{{ route('tasks.create') }}'">
                Add a new task
            </button>
        </section>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th colspan="5">Tasks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Priority</th>
                        <th>State</th>
                        <th>Actions</th>
                    </tr>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->name }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->priority->label() }}</td>
                            <td>{{ $task->state->label() }}</td>
                            <td>
                                <a href="{{ route('tasks.show', $task->id) }}">Details</a>
                                <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                                <form method="POST" action="{{ route('tasks.delete', $task->id) }}" id="delete-form-{{ $task->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button-delete" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>You do not have tasks registered yet. Add a new one <a href="{{ route('tasks.create') }}">here</a>.</p>
    @endif
    <style>
        .options-container {
            flex-direction: row;
            justify-content: center;
        }
        
        #delete-form {
            display: inline;
        }

        .button-delete {
            border: none;
            background-color: white;
            font-size: 1.5rem;
            color: blue;
            font-family: 'Times New Roman', Times, serif;
        }
        
        .button-delete:hover {
            border: none;
        }
    </style>   
@endsection


