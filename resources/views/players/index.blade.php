<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestione giocatori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                    href="{{ route('players.create') }}">
                    {{ __('Crea nuovo giocatore') }}
                </a>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    @if ($players->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">
                            {{ __('Nessun giocatore trovato.') }}
                        </p>
                    @endif

                    @if (!$players->isEmpty())
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nome
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Squadra
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Posizione
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Altezza
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        PPG
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        RPG
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        APG
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        Azioni
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($players as $player)

                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $player->jersey_number ?? '-' }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $player->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @foreach ($player->teams as $teams)
                                                <span class="flex whitespace-nowrap">
                                                    {{ $teams->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $player->position ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $player->height_cm ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $player->points_per_game ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $player->rebounds_per_game ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $player->assists_per_game ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('players.destroy', $player->id) }}" method="POST"
                                                class="space-x-2">



                                                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                    href="{{ route('players.show', $player->id) }}">Show</a>



                                                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                    href="{{ route('players.edit', $player->id) }}">Edit</a>



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

            </div>
        </div>
    </div>
</x-app-layout>