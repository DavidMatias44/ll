<x-app-layout>
    <div class="py-12">
        <div class="w-1/2 mx-auto sm:px-6 lg:px-8">
            <div class="px-6 py-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div x-data="{ timerIsRunning : false }" id="pomodoro-timer" class="w-3/4 flex flex-col items-center mx-auto my-12 py-6 text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 rounded">
                    <div class="flex flex-row justify-start w-full mb-6">
                        <div class="w-[12.5%]"></div>
                        <p id="pomodoro-timer-text" class="w-3/4 h-full dark:bg-gray-700 text-9xl text-center py-6 rounded"></p>
                        <button @click="timerIsRunning = false" id="skip-to-next-pomodoro-button" x-bind:class="{ 'hidden' : !timerIsRunning }" class="w-[12.5%] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>

                    <div class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 rounded">
                        <p id="current-pomodoro-text" class="text-2xl"></p>
                    </div>

                    <button x-bind:disabled="timerIsRunning" @click="timerIsRunning = true" type="button" id="start-pomodoro-timer-button" class="text-xl w-1/4 mt-6 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-100 py-2 px-4 rounded disabled:bg-gray-700 disabled:cursor-not-allowed">Start timer</button>
                    <button x-bind:disabled="!timerIsRunning" @click="timerIsRunning = false" type="button" id="pause-pomodoro-timer-button" class="text-xl w-1/4 mt-6 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-100 py-2 px-4 rounded disabled:bg-gray-700 disabled:cursor-not-allowed">Pause timer</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let pomodoroTimer = document.getElementById('pomodoro-timer');
    let pomodoroTimerText = document.getElementById('pomodoro-timer-text');

    let startPomodoroTimerButton = document.getElementById('start-pomodoro-timer-button');
    let pausePomodoroTimerButton = document.getElementById('pause-pomodoro-timer-button');
    let skipToNextPomodoroButton = document.getElementById('skip-to-next-pomodoro-button');

    let currentPomodoroText = document.getElementById('current-pomodoro-text');
    let currentPomodoro = 1;

    let timerInterval;

    let totalTimeInSeconds = 0.25 * 60; // this '25' may vary, that depends on user preferences.
    let timeLeftInSeconds;

    (() => {
        setupTimer();
    })();

    function setupTimer () {
        timeLeftInSeconds = totalTimeInSeconds;
        pomodoroTimerText.textContent = getTimeFormat(timeLeftInSeconds);
        currentPomodoroText.textContent = "Pomodoro: #" + currentPomodoro.toString();
    }

    function skipToNextPomodoro() {
        currentPomodoro++;
        pausePomodoroTimer();
        setupTimer();
    }

    function updatePomodoroTimer () {
        pomodoroTimerText.textContent = getTimeFormat();
    }

    function startPomodoroTimer () {
        timerInterval = setInterval(() => {
            if (timeLeftInSeconds <= 0) {
                clearInterval(timerInterval);
                currentPomodoro++;
                setupTimer();
            } else {
                timeLeftInSeconds--;
                updatePomodoroTimer();
            }
        }, 1000);
    }

    function pausePomodoroTimer () {
        clearInterval(timerInterval);
    }

    function getTimeFormat () {
        let minutes = Math.floor(timeLeftInSeconds / 60);
        let seconds = timeLeftInSeconds % 60;

        let response = ""
        if (minutes < 10) {
            response += '0';
        }
        response += minutes.toString() + ":";
        if (seconds < 10) {
            response += '0';
        }
        response += seconds.toString();
        return response;
    }

    startPomodoroTimerButton.addEventListener('click', startPomodoroTimer);
    pausePomodoroTimerButton.addEventListener('click', pausePomodoroTimer);
    skipToNextPomodoroButton.addEventListener('click', skipToNextPomodoro);
</script>
