@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">    
@endpush

@section('main')
    <h2>Tasks</h2>

    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            <p>{{ session('success') }}</p>
            <button type="button" class="close-button" id="btn-close">&times;</button>
        </div>
    @endif

    @if (!$tasks->isEmpty())
        <section class="options-container">
            <button class="option-button" type="button" onclick="location.href='{{ route('tasks.create') }}'">
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
                            <td class="{{ $task->priority->cssClass() }}">
                                <p>{{ $task->priority->label() }}</p>
                            </td>
                            <td class="{{ $task->state->cssClass() }}">
                                <p>{{ $task->state->label() }}</p>
                            </td>
                            <td>
                                <a href="{{ route('tasks.show', $task->id) }}">Details</a>
                                <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                                <form method="POST" action="{{ route('tasks.delete', $task->id) }}" id="delete-form-{{ $task->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete-button" onclick="return confirm('Are you sure?')" type="submit">Delete</button>
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


