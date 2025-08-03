@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}"> 
@endpush

@section('main')
    <h2>Task details</h2>

    <section class="options-container">
        <button class="option-button" type="button" onclick="location.href='{{ route('tasks.edit', $task->id) }}'">
            Edit this task
        </button>
    </section>

    <div class="table-container">
        <table class="detail-table">
            <tbody>
                <tr>
                    <th>Name: </th>
                    <td>{{ $task->name }}</td>
                </tr>
                <tr>
                    <th>Description: </th>
                    <td>{{ $task->description }}</td>
                </tr>
                <tr>
                    <th>Priority: </th>
                    <td>{{ $task->priority->label() }}</td>
                </tr>
                <tr>
                    <th>State: </th>
                    <td>{{ $task->state->label() }}</td>
                </tr>
                <tr>
                    <th>Created at: </th>
                    <td>{{ $task->created_at }}</td>
                </tr>
                <tr>
                    <th>Updated at: </th>
                    <td>{{ $task->updated_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection