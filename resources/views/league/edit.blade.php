<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestione categorie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Modifica categoria') }}
                    </h2>

                    <form method="POST" action="{{ route('leagues.update', $league->id) }}" class="my-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="league_name" :value="__('Nome (obbligatorio)')" />
                            <x-text-input id="league_name" name="name" type="text" class="mt-1 block w-full"
                                autocomplete="off" value="{{ $league->name }}" required />
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