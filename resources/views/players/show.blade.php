<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ '#' . $player->jersey_number . ' ' . $player->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-400 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                <div class="space-y-6 lg:w-3/4 xl:w-1/2">

                    <p>Squadre:

                        @foreach ($player->teams as $key => $teams)
                            <span class="whitespace-nowrap font-bold dark:text-gray-100">
                                {{ $teams->name }}
                            </span>
                            @if ($key < count($player->teams) - 1)
                                <span>- </span>
                            @endif
                        @endforeach
                    </p>


                    <p>Posizione: <span class="font-bold dark:text-gray-100">{{ $player->position }}</span></p>


                    <p>Altezza (cm): <span class="font-bold dark:text-gray-100">{{ $player->height_cm }}</span></p>


                    <p>Data di nascita: <span class="font-bold dark:text-gray-100">{{ $player->birth_date }}</span></p>

                    <p>Punti a partita: <span class="font-bold dark:text-gray-100">{{ $player->points_per_game }}</span>
                    </p>

                    <p>Rimbalzi a partita: <span
                            class="font-bold dark:text-gray-100">{{ $player->rebounds_per_game }}</span></p>

                    <p>Assist a partita: <span
                            class="font-bold dark:text-gray-100">{{ $player->assists_per_game }}</span></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>