<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('See task details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center px-4 py-4 gap-8">
                    <button type="button" onclick="location.href='{{ route('tasks.create') }}'"class="max-h-12 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">Create a new task</button>
                    <button type="button" onclick="location.href='{{ route('tasks.index', $task) }}'"class="max-h-12 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">See all tasks</button>
                    <button type="button" onclick="location.href='{{ route('tasks.import.form') }}'"class="max-h-12 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">Import tasks from csv file</button>
                    <button type="button" onclick="location.href='{{ route('tasks.edit', $task) }}'"class="max-h-12 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">Update this task</button>
                </div>
            </div>
        </div>
    </div>

    <div class="w-1/4 mx-auto overflow-x-auto sm:rounded-lg text-lg">
        <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <tbody>
                <tr class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th class="px-6 py-4" scope='row'>Name</th>
                    <td class="px-6 py-4" scope='row'>{{ $task->name }}</td>
                </tr>
                <tr class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th class="px-6 py-4" scope='row'>Description</th>
                    <td class="px-6 py-4" scope='row'>{{ $task->description }}</td>
                </tr>
                <tr class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th class="px-6 py-4" scope='row'>State</th>
                    <td class="px-6 py-4" scope='row'>
                        <p class="{{ $task->state->cssClass() }}">{{ $task->state->label() }}</p>
                    </td>
                </tr>
                <tr class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th class="px-6 py-4" scope='row'>Priority</th>
                    <td class="px-6 py-4" scope='row'>
                        <p class="{{ $task->priority->cssClass() }}">{{ $task->priority->label() }}</p>
                    </td>
                </tr>
                <tr class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th class="px-6 py-4" scope='row'>Created at:</th>
                    <td class="px-6 py-4" scope='row'>{{ $task->created_at }}</td>
                </tr>
                <tr class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th class="px-6 py-4" scope='row'>Updated at:</th>
                    <td class="px-6 py-4" scope='row'>{{ $task->updated_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-app-layout>
