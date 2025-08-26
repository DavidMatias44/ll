<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center px-4 py-4 gap-8">
                    <button type="button" onclick="location.href='{{ route('tasks.create') }}'"class="max-h-12 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">Create a new task</button>
                    <button type="button" onclick="location.href='{{ route('tasks.import.form') }}'"class="max-h-12 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded">Import tasks from csv file</button>

                    <form x-data="{ filterSelected : false }" class="flex items-center gap-8">
                        @csrf

                        <div>
                            <x-input-label for="priority" :value="__('Priority')" />
                            <select @change="filterSelected = true" class="bg-gray-600 text-gray-200 focus:outline-none focus:ring-0 focus:border-none rounded" name="priority" id="filter-select-priority">
                                <option value="" selected disabled>Choose an option</option>
                                @foreach (App\Enums\Tasks\Priority::cases() as $priority)
                                    <option value="{{ $priority->value }}" {{ ("$priority->value" === request('priority')) ? 'selected' : '' }}>{{ $priority->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="state" :value="__('State')" />
                            <select @change="filterSelected = true" class="bg-gray-600 text-gray-200 focus:outline-none focus:ring-0 focus:border-none rounded" name="state" id="filter-select-state">
                                <option value="" selected disabled>Choose an option</option>
                                @foreach (App\Enums\Tasks\State::cases() as $state)
                                    <option value="{{ $state->value }}" {{ ("$state->value" === request('state')) ? 'selected' : '' }}>{{ $state->label() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button x-bind:disabled="! filterSelected" class="max-h-12 w-36 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded disabled:bg-gray-700 disabled:cursor-not-allowed">Filter</button>
                        @if (request('priority') !== null || request('state') !== null)
                            <button type="reset" onclick="location.href='{{ route('tasks.index') }}'" class="max-h-12 w-36 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded disabled:bg-gray-700 disabled:cursor-not-allowed">Clear filters</button>
                        @else
                            <button type="reset" onclick="location.href='{{ route('tasks.index') }}'" disabled class="max-h-12 w-36 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded disabled:bg-gray-700 disabled:cursor-not-allowed">Clear filters</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (! $tasks->isEmpty())
        <div class="w-3/4 mx-auto overflow-x-auto sm:rounded-lg text-lg">
            <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Due date</th>
                        <th scope="col" class="px-6 py-3">Priority</th>
                        <th scope="col" class="px-6 py-3">State</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-4" scope='row'>{{ $task->name }}</td>
                            <td class="px-6 py-4">
                                
                                @if ($task->due_date !== null)
                                    {{ $task->due_date }}
                                @else
                                    No due date
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="{{ $task->priority->cssClass() }}">{{ $task->priority->label() }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="{{ $task->state->cssClass() }}">{{ $task->state->label() }}</p>
                            </td>
                            <td class="px-6 py-4 flex gap-4">
                                <a class="text-blue-600 dark:text-blue-800 hover:underline" href="{{ route('tasks.show', $task) }}">Details</a>
                                <a class="text-blue-600 dark:text-blue-800 hover:underline" href="{{ route('tasks.edit', $task) }}">Edit</a>

                                <button 
                                    class="text-red-600 dark:text-red-700" 
                                    type="button" 
                                    @click="$dispatch('open-modal', 'delete-modal')" 
                                    onclick="setupActionFromDeletionForm({{ $task->id }})" 
                                    x-data="">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $tasks->appends(request()->query())->links() }}
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("There is no tasks registered. Add a new one") }} <a class="underline" href="{{ route('tasks.create') }}">{{ __('here') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>

<x-modal name="delete-modal" maxWidth="sm">
    <div class="flex flex-col items-center my-6">
        <p class="text-2xl text-gray-200 text-center mb-6">Are you sure?</p>
        <form id="deletion-form" method="POST">
            @csrf
            @method('DELETE')

            <x-secondary-button @click="$dispatch('close-modal', 'delete-modal')">Cancel</x-secondary-button>
            <x-primary-button>Confirm</x-primary-button>
        </form>
    </div>
</x-modal>

<script>
    function setupActionFromDeletionForm (taskId) {
        let form = document.getElementById('deletion-form');
        form.action = `/tasks/delete/${taskId}`;
    }
</script>
