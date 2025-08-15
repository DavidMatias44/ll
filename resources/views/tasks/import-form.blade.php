@extends('layouts.main')

@push('css-files')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush

@section('main')
    <h2>Import tasks from a CSV file.</h2>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li class="error">{{ $error }}</li>
            @endforeach 
        </ul>
    @endif

    <section class="form-container">


        <form method="POST" action="{{ route('tasks.import.csv') }}" class="form" enctype="multipart/form-data">
            @csrf

            <label for="csv-file">Archivo CSV: </label>
            <input type="file" accept=".csv" name="csv-file">
            <button class="accept-button">Upload CSV file</button>
            <button class="cancel-button" type="button" onclick="location.href='{{ url()->previous() }}'">Cancel</button>
        </form>
    </section>
@endsection