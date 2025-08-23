<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @auth
                {{ __('You can see your tasks ') }} <a class="underline" href="{{ route('tasks.index') }}">here</a>.
            @endauth

            @guest
                {{ __('Welcome! Please login.') }}                
            @endguest
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @auth
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-xl">
                        {{ __("Welcome!") }} {{ Auth::user()->name }}
                    </div>   
                @endauth

                @guest
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-xl">
                        {{ __("If you do not have an account you can create one") }} <a class="underline" href="{{ route('register') }}">here</a>.
                    </div>    
                @endguest
            </div>
        </div>
    </div>
</x-app-layout>