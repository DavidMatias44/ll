<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Import csv file') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center px-4 py-4 gap-8">
                    <button type="button" onclick="location.href='{{ route('tasks.index') }}'"class="max-h-12 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">See all tasks</button>
                    <button type="button" onclick="location.href='{{ route('tasks.create') }}'"class="max-h-12 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">Create a task</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center px-4 py-4 gap-8">
                    <form method="POST" action="{{ route('tasks.import.csv') }}" class="w-3/4 mx-auto" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="my-4">
                            <x-input-label for="csv-file" :value="__('Csv file')" />
                            <x-text-input id="csv-file" class="block mt-1 w-full"
                                type="file"
                                name="csv-file" />
                            <x-input-error :messages="$errors->get('csv-file')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <x-secondary-button onclick="history.back()">Cancel</x-secondary-button>
                            <x-primary-button class="my-4">Upload csv file</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- @extends('layouts.main')

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
@endsection--}}