<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create a Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center px-4 py-4 gap-8">
                    <button type="button" onclick="location.href='{{ route('tasks.index') }}'"class="max-h-12 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">See all tasks</button>
                    <button type="button" onclick="location.href='{{ route('tasks.import.form') }}'"class="max-h-12 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">Import tasks from csv file</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center px-4 py-4 gap-8">
                    <form method="POST" action="{{ route('tasks.store') }}" class="w-3/4 mx-auto">
                        @csrf
                        
                        <div class="my-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full"
                                type="text"
                                name="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="my-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" class="block mt-1 w-full"
                                type="text"
                                name="description" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="my-4">
                            <x-input-label for="priority" :value="__('Priority')" />
                            <select class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="priority" id="filter-select-priority">
                                <option value="" selected disabled>Choose an option</option>
                                @foreach (App\Enums\Priority::cases() as $priority)
                                    <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                        </div>

                        <div class="my-4">
                            <x-input-label for="state" :value="__('State')" />
                            <select class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="state" id="filter-select-state">
                                @php
                                    $state = App\Enums\State::TODO;
                                @endphp
                                <option value="{{ $state->value }}">{{ $state->label() }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('state')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <x-secondary-button onclick="history.back()">Cancel</x-secondary-button>
                            <x-primary-button class="my-4">Create task</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
