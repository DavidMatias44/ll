@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">    
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">    
@endpush

@push('scripts')
    <script src="{{ asset('js/hideAlert.js') }}"></script>
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
            <form class="filter-form">
                @csrf
                <label for="priority">Filter by priority: </label>
                <select class="filter-select" name="priority" id="filter-select-priority">
                    <option value="" selected disabled>Choose an option</option>
                    @foreach (App\Enums\Priority::cases() as $priority)
                        <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                    @endforeach
                </select>
                <label for="state">Filter by state: </label>
                <select class="filter-select" name="state" id="filter-select-state">
                    <option value="" selected disabled>Choose an option</option>
                    @foreach (App\Enums\State::cases() as $state)
                        <option value="{{ $state->value }}">{{ $state->label() }}</option>
                    @endforeach
                </select>
                <button class="option-button">Filter</button>
            </form>
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
                                <a href="{{ route('tasks.show', $task) }}">Details</a>
                                <a href="{{ route('tasks.edit', $task) }}">Edit</a>
                                <form method="POST" action="{{ route('tasks.delete', $task) }}" id="delete-form-{{ $task->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete-button" onclick="return confirm('Are you sure?')" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <br>
            <div>
                {{ $tasks->appends(request()->query())->links()  }}
            </div>
        </div>
    @else
        <p>You do not have tasks registered yet. Add a new one <a href="{{ route('tasks.create') }}">here</a>.</p>
    @endif
@endsection


