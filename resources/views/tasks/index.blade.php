@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">    
@endpush

@section('main')
    <h2>Tasks</h2>

    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            <p>{{ session('success') }}</p>
            <button type="button" class="button-close" id="btn-close">&times;</button>
        </div>
    @endif

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

        .alert {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 25%;
            margin: 0 auto;
            min-height: 4rem; 
            border-radius: 15px;
            position: relative;
        }

        .alert-success {
            background-color: #bae1c1ff;
            color: #4cb35fff
        }

        .button-close {
            position: absolute;
            top: 0;
            right: 0.5rem;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .button-close:hover {
            background: none;
            border: none;
            color: #4cb35fff
        }
    </style>
    <script>
        setTimeout(() => {
            hideSuccessAlert()
        }, 5000);

        document.getElementById('btn-close').addEventListener('click', function () {
            hideSuccessAlert();
        });


        function hideSuccessAlert() {
            document.getElementById('success-message').style.display = 'none';
        }
    </script>
@endsection


