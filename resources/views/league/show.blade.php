<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $league->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <div class="space-y-6 lg:w-3/4 xl:w-1/2">
                        <h2>Squadre:</h2>

                        @foreach ($league->teams as $team)
                            <p class="font-bold">{{ $team->name }}</p>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>