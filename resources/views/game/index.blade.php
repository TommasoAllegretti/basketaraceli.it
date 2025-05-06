<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestione partite') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                    href="{{ route('games.create') }}">
                    {{ __('Crea nuova partita') }}
                </a>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    @if ($games->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">
                            {{ __('Nessuna categoria trovata.') }}
                        </p>
                    @endif

                    @if (!$games->isEmpty())
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Data
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Locali
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Ospiti
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        Azioni
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($games as $game)

                                    <tr
                                        class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 border-gray-200 last:border-b-0">

                                        <td class="px-6 py-4">
                                            {{ $game->date }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $game->home_team->name }} ({{$game->home_team_total_score}})
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $game->away_team->name }} ({{$game->away_team_total_score}})
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('games.destroy', $game->id) }}" method="POST"
                                                class="space-x-2">



                                                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                    href="{{ route('games.show', $game->id) }}">Show</a>



                                                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                    href="{{ route('games.edit', $game->id) }}">Edit</a>



                                                @csrf

                                                @method('DELETE')



                                                <button type="submit"
                                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</button>

                                            </form>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $games->links('layouts.pagination') }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>