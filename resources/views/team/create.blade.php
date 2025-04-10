<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestione squadre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Nuova squadra') }}
                    </h2>

                    <form method="POST" action="{{ route('teams.store') }}" class="my-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="league_id" :value="__('Categoria (obbligatorio)')" />
                            <select id="league_id" name="league_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>
                                <option value="" selected></option>

                                @foreach ($leagues as $league)
                                    <option value="{{ $league->id }}">{{ $league->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div>
                            <x-input-label for="team_name" :value="__('Nome (obbligatorio)')" />
                            <x-text-input id="team_name" name="name" type="text" class="mt-1 block w-full"
                                autocomplete="off" required />
                        </div>

                        <div>
                            <x-input-label for="abbreviation" :value="__('Abbreviazione')" />
                            <x-text-input id="abbreviation" name="abbreviation" type="text" class="mt-1 block w-full"
                                autocomplete="off" required />
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