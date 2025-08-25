<div class="w-3/4 flex flex-col items-center mx-auto my-12 py-6 text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 rounded">

    <div class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 mb-4 rounded">
        <p class="text-2xl inline">{{ $pomodoroState }}</p>
    </div>

    <div class="flex flex-row justify-start w-full mb-6">
        <div class="w-[12.5%]"></div>
        <p wire:poll.1s='tick' class="w-3/4 h-full dark:bg-gray-700 text-9xl text-center py-6 rounded">
            @php
                $minutes = floor($timeLeftInSeconds / 60);
                $seconds = $timeLeftInSeconds % 60;

                $res = '';
                if ($minutes < 10) {
                    $res .= '0';
                }
                $res .= strval($minutes) . ":";
                if ($seconds < 10) {
                    $res .= '0';
                }
                $res .= strval($seconds);
            @endphp

            {{ $res }}
        </p>

        @if ($timerIsRunning)
            <button wire:click="skipToNextPomodoro" class="w-[12.5%] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        @endif
    </div>

    <div class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 rounded">
        <p class="text-2xl inline">Pomodoro: #</p>
        <p class="text-2xl inline">{{ $currentPomodoro }}</p>
    </div>

    @if ($timerIsRunning)
        <button wire:click="timerStop" type="button" class="text-xl w-1/4 mt-6 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-100 py-2 px-4 rounded disabled:bg-gray-700 disabled:cursor-not-allowed">Pause timer</button>
    @else
        <button wire:click="timerStart" type="button" class="text-xl w-1/4 mt-6 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-100 py-2 px-4 rounded disabled:bg-gray-700 disabled:cursor-not-allowed">Start timer</button>
    @endif

</div>
