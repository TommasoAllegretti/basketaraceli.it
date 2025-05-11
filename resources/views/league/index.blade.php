<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestione categorie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                    href="{{ route('leagues.create') }}">
                    {{ __('Crea nuova categoria') }}
                </a>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    @if ($leagues->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">
                            {{ __('Nessuna categoria trovata.') }}
                        </p>
                    @endif

                    @if (!$leagues->isEmpty())
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nome
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        Azioni
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($leagues as $league)

                                    <tr
                                        class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 border-gray-200 last:border-b-0">

                                        <td class="px-6 py-4">
                                            {{ $league->name }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('leagues.destroy', $league->id) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questa categoria?');"
                                                class="space-x-2">



                                                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                    href="{{ route('leagues.show', $league->id) }}">Show</a>



                                                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                    href="{{ route('leagues.edit', $league->id) }}">Edit</a>



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
                    {{ $leagues->links('layouts.pagination') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>