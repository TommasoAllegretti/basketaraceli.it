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

                    <form method="POST" action="{{ route('players.store') }}" class="my-6 space-y-6 lg:w-3/4 xl:w-1/2">
                        @csrf

                        <div>
                            <x-input-label for="team_id" :value="__('Squadra (obbligatorio)')" />
                            {{-- <x-select-input id="team" name="team_id" class="mt-1 block w-full" autocomplete="off"
                                required>
                                <option value="">test</option>
                            </x-select-input> --}}
                            <select id="team_id" name="team_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>
                                <option value="" selected></option>

                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach

                            </select>
                        </div>

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