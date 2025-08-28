<div class="w-1/2 mb-12 py-6">
    <div class="flex flex-col gap-6">
        @if (session()->get('pomodoro.taskId') !== null)
            <p class="text-2xl text-gray-200 text-center">Working on task: </p>

            <div class="w-full dark:bg-gray-600 dark:text-gray-200 text-xl">
                <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <tbody>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600 border-gray-200">
                            <th class="px-6 py-4" scope='row'>Name</th>
                            <td class="px-6 py-4" scope='row'>{{ $task->name }}</td>
                        </tr>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600 border-gray-200">
                            <th class="px-6 py-4" scope='row'>Description</th>
                            <td class="px-6 py-4" scope='row'>{{ $task->description }}</td>
                        </tr>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600 border-gray-200">
                            <th class="px-6 py-4" scope='row'>Due date</th>
                            <td class="px-6 py-4" scope='row'>
                                @if ($task->due_date !== null)
                                    {{ $task->due_date }}
                                @else
                                    No due date
                                @endif
                            </td>
                        </tr>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600 border-gray-200">
                            <th class="px-6 py-4" scope='row'>State</th>
                            <td class="px-6 py-4" scope='row'>
                                <p class="{{ $task->state->cssClass() }}">{{ $task->state->label() }}</p>
                            </td>
                        </tr>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600 border-gray-200">
                            <th class="px-6 py-4" scope='row'>Priority</th>
                            <td class="px-6 py-4" scope='row'>
                                <p class="{{ $task->priority->cssClass() }}">{{ $task->priority->label() }}</p>
                            </td>
                        </tr>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600 border-gray-200">
                            <th class="px-6 py-4" scope='row'>Created at:</th>
                            <td class="px-6 py-4" scope='row'>{{ $task->created_at }}</td>
                        </tr>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600 border-gray-200">
                            <th class="px-6 py-4" scope='row'>Updated at:</th>
                            <td class="px-6 py-4" scope='row'>{{ $task->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button @click="$dispatch('open-modal', 'show-tasks-modal')" x-data="" class="text-2xl bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-100 py-4 px-4 rounded">
                Change task
            </button>

            <button wire:click="removeTask" @click="$dispatch('close-modal', 'show-tasks-modal')" class="text-2xl bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-100 py-4 px-4 rounded">
                Remove task
            </button>
        @else
            @if (! $tasks->isEmpty())
                <button @click="$dispatch('open-modal', 'show-tasks-modal')" x-data="" class="text-2xl bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-100 py-4 px-4 rounded">
                    Select task to work on
                </button>
            @else
                <p class="dark:text-gray-200 text-2xl mb-12">You do not have tasks registered. Create a new one <a href="{{ route('tasks.create') }}" class="underline">here</a>.</p>
            @endif
        @endif
    </div>

    <x-modal name="show-tasks-modal" maxWidth="lg">
        <div class="flex flex-col items-center my-6">
            <p class="text-2xl text-gray-200 text-center">Avalaible tasks</p>

            <div class="w-[65%] text-gray-200 text-xl text-center mt-6 mb-8 rounded">
                <form>
                    @csrf

                    <select wire:model="taskId" wire:click="updateTaskId" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="null" selected disabled>Choose a task</option>
                        @foreach ($tasks as $task)
                            @if (session()->has('pomodoro.taskId') && session()->get('pomodoro.taskId') == $task->id)
                                @continue
                            @endif

                            <option value="{{ $task->id }}">
                                {{ $task->name }} | {{ $task->state->label() }} state | {{ $task->priority->label() }} priority</p>
                            </option>
                        @endforeach
                    </select>

                    <x-secondary-button type="reset" wire:click="resetTaskId" @click="$dispatch('close-modal', 'show-tasks-modal')" class="mt-6">Cancel</x-secondary-button>

                    @if ($taskId !== null)
                        <x-primary-button type="button" wire:click="saveTaskId" @click="$dispatch('close-modal', 'show-tasks-modal')">Select task</x-primary-button>
                    @endif
                </form>
            </div>
        </div>
    </x-modal>
</div>
