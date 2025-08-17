@extends('layouts.main')

@section('main')
    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            <p>{{ session('success') }}</p>
            <button type="button" class="close-button" id="btn-close">&times;</button>
        </div>
    @endif

    <section class="dashboard-options-container">
        <button class="option-button" type="button" onclick="location.href='{{ route('tasks.index') }}'">See all your tasks.</button>
        <button class="option-button" type="button" onclick="location.href='{{ route('tasks.create') }}'">Add a new task.</button>
        <button class="option-button" type="button" onclick="location.href='{{ route('tasks.import.form') }}'">Add task from CSV file.</button>
    </section>

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
