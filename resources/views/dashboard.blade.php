@extends('layouts.main')

@section('main')
    @if ($errors->any())
        <ul id="error-list">
            @foreach ($errors->all() as $error)
                <li class="error">{{ $error }}</li>
            @endforeach 
        </ul>
    @endif

    @if (session('error'))
        <ul>
            <li class="error">{{ session('error') }}</li>
        </ul>
    @endif

    <section class="dashboard-options-container">
        <button class="option-button" type="button" onclick="location.href='{{ route('tasks.index') }}'">See all your tasks.</button>
        <button class="option-button" type="button" onclick="location.href='{{ route('tasks.create') }}'">Add a new task.</button>
        <button class="option-button" type="button" onclick="location.href='{{ route('tasks.import.form') }}'">Add task from CSV file.</button>
    </section>

    <script>
        setTimeout(() => {
            hideErrorList()
        }, 5000);

        function hideErrorList() {
            document.getElementById('error-list').style.display = 'none';
        }
    </script>
@endsection
