@extends('layouts.main')

@section('main')
    <section class="dashboard-options-container">
        <button class="option-button" type="button" onclick="location.href='{{ route('tasks.index') }}'">See all your tasks.</button>
        <button class="option-button" type="button" onclick="location.href='{{ route('tasks.create') }}'">Add a new task.</button>
    </section>
@endsection
