<x-app-layout>
    <div class="py-12">
        <div class="w-1/2 mx-auto sm:px-6 lg:px-8">
            <div class="px-6 py-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div x-data="pomodoroTimer" id="pomodoro-timer" class="w-3/4 flex flex-col items-center mx-auto my-12 py-6 text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 rounded">
                    <div class="flex flex-row justify-start w-full mb-6">
                        <div class="w-[12.5%]"></div>
                        <p x-text="getTimeFormat" class="w-3/4 h-full dark:bg-gray-700 text-9xl text-center py-6 rounded"></p>
                        <button x-show="timerIsRunning" @click="skipToNextPomodoro()" class="w-[12.5%] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>

                    <div class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 rounded">
                        <p class="text-2xl inline">Pomodoro: #</p>
                        <p x-text="currentPomodoro" class="text-2xl inline"></p>
                    </div>

                    <button x-show="!timerIsRunning" @click="pomodoroTimerStart()" type="button" id="start-pomodoro-timer-button" class="text-xl w-1/4 mt-6 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-100 py-2 px-4 rounded disabled:bg-gray-700 disabled:cursor-not-allowed">Start timer</button>
                    <button x-show="timerIsRunning" @click="pomodoroTimerPause()" type="button" id="pause-pomodoro-timer-button" class="text-xl w-1/4 mt-6 bg-gray-600 hover:bg-gray-700 text-gray-800 dark:text-gray-100 py-2 px-4 rounded disabled:bg-gray-700 disabled:cursor-not-allowed">Pause timer</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('pomodoroTimer', () => ({
            intervalId: null,
            currentPomodoro: 1,
            totalTimeInSeconds: 3,
            timeLeftInSeconds: null,
            timerIsRunning: false,

            init() {
                this.setUpPomodoroTimer();
            },

            setUpPomodoroTimer() {
                this.timeLeftInSeconds = this.totalTimeInSeconds;
                this.timerIsRunning = false;
            },

            pomodoroTimerStart() {
                this.timerIsRunning = true;

                this.intervalId = setInterval(() => {
                    if (this.timeLeftInSeconds <= 0) {
                        this.skipToNextPomodoro();
                    } else {
                        this.timeLeftInSeconds--;
                    }
                }, 1000)
            },

            pomodoroTimerPause() {
                clearInterval(this.intervalId);
                this.intervalId = null;
            },

            skipToNextPomodoro() {
                this.currentPomodoro++;
                this.pomodoroTimerPause();
                this.setUpPomodoroTimer();
            },

            getTimeFormat () {
                let minutes = Math.floor(this.timeLeftInSeconds / 60);
                let seconds = this.timeLeftInSeconds % 60;

                let res = ""
                if (minutes < 10) {
                    res += '0';
                }
                res += minutes.toString() + ":";
                if (seconds < 10) {
                    res += '0';
                }
                res += seconds.toString();
                return res;
            },
        }));
    });
</script>
