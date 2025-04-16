<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ '#' . $player->jersey_number . ' ' . $player->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <div class="space-y-6 lg:w-3/4 xl:w-1/2">

                        <p>Squadra: <span class="font-bold">{{ $player->team->name }}</span></p>


                        <p>Posizione: <span class="font-bold">{{ $player->position }}</span></p>


                        <p>Altezza (cm): <span class="font-bold">{{ $player->height_cm }}</span></p>


                        <p>Data di nascita: <span class="font-bold">{{ $player->birth_date }}</span></p>

                        <p>Punti a partita: <span class="font-bold">{{ $player->points_per_game }}</span></p>

                        <p>Rimbalzi a partita: <span class="font-bold">{{ $player->rebounds_per_game }}</span></p>

                        <p>Assist a partita: <span class="font-bold">{{ $player->assists_per_game }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>