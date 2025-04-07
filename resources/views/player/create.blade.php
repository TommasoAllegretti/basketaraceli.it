<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestione giocatori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Nuovo giocatore') }}
                    </h2>

                    <form method="POST" action="{{ route('player.store') }}" class="my-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="player_name" :value="__('Nome (obbligatorio)')" />
                            <x-text-input id="player_name" name="name" type="text" class="mt-1 block w-full"
                                autocomplete="off" required />
                        </div>

                        <div>
                            <x-input-label for="position" :value="__('Posizione')" />
                            <x-text-input id="position" name="position" type="text" class="mt-1 block w-full"
                                autocomplete="off" />
                        </div>

                        <div>
                            <x-input-label for="height_cm" :value="__('Altezza (cm)')" />
                            <x-text-input id="height_cm" name="height_cm" type="number" class="mt-1 block w-full"
                                autocomplete="off" />
                        </div>

                        <div>
                            <x-input-label for="birth_date" :value="__('Data di nascita')" />
                            <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full"
                                autocomplete="off" />
                        </div>

                        <div>
                            <x-input-label for="team" :value="__('Squadra')" />
                            <x-text-input id="team" name="team" type="text" class="mt-1 block w-full"
                                autocomplete="off" />
                        </div>

                        <div>
                            <x-input-label for="jersey_number" :value="__('Numero maglia')" />
                            <x-text-input id="jersey_number" name="jersey_number" type="number"
                                class="mt-1 block w-full" autocomplete="off" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Salva') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>