<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex px-4 py-4 gap-8">
                    <button type="button" onclick="location.href='{{ route('tasks.create') }}'" class="bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">Create a new task</button>
                    <button type="button" onclick="location.href='{{ route('tasks.import.form') }}'"class="bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">Import tasks from csv file</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
