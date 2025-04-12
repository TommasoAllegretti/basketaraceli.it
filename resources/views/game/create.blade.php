<script>


    function toggleAccordion(event, index) {

        event.preventDefault();

        const content = document.getElementById(`content-${index}`);
        const icon = document.getElementById(`icon-${index}`);

        // SVG for Down icon
        const downSVG = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
        <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
      </svg>
    `;

        // SVG for Up icon
        const upSVG = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
        <path fill-rule="evenodd" d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z" clip-rule="evenodd" />
      </svg>
    `;

        // Toggle the content's max-height for smooth opening and closing
        if (content.style.maxHeight && content.style.maxHeight !== '0px') {
            content.style.maxHeight = '0';
            icon.innerHTML = upSVG;
        } else {
            content.style.maxHeight = content.scrollHeight + 'px';
            icon.innerHTML = downSVG;
        }
    }

    function addStat() {
        const statsWrapper = document.getElementById('stats-wrapper');
        const newStatIndex = statsWrapper.children.length + 1;

        // Create a new accordion item
        const newAccordionItem = document.createElement('div');
        newAccordionItem.className = 'accordion-item border-b border-slate-200';
        newAccordionItem.innerHTML = `
            <button onclick="toggleAccordion(event, ${newStatIndex})" class="w-full flex justify-between items-center py-5 text-slate-800">
                <span>Statistiche Giocatore ${newStatIndex}</span>
                <span id="icon-${newStatIndex}" class="text-slate-800 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z" clip-rule="evenodd" />
                    </svg>
                </span>
            </button>
            <div id="content-${newStatIndex}" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                <div class="pb-5 text-sm text-slate-500">
                    
                </div>
            </div>
        `;

        statsWrapper.appendChild(newAccordionItem);
    }

</script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestione partite') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Nuova partita') }}
                    </h2>

                    <form method="POST" action="{{ route('games.store') }}" class="my-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="date" :value="__('Data')" />
                            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full"
                                autocomplete="off" />
                        </div>

                        <div>
                            <x-input-label for="home_team_id" :value="__('Locali (obbligatorio)')" />
                            <select id="home_team_id" name="home_team_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>
                                <option value="" selected></option>

                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div>
                            <x-input-label for="away_team_id" :value="__('Ospiti (obbligatorio)')" />
                            <select id="away_team_id" name="away_team_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>
                                <option value="" selected></option>

                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <hr>

                        <h3>Inserisci statistiche giocatori</h3>

                        <x-secondary-button onclick="addStat()">Aggiungi statistiche giocatore</x-secondary-button>

                        <div id="stats-wrapper">

                            <!-- Accordion Item -->
                            <div class="accordion-item border-b border-slate-200">
                                <button onclick="toggleAccordion(event, 1)"
                                    class="w-full flex justify-between items-center py-5 text-slate-800">
                                    <span>Statistiche Giocatore 1</span>
                                    <span id="icon-1" class="text-slate-800 transition-transform duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                            class="w-4 h-4">
                                            <path fill-rule="evenodd"
                                                d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                                <div id="content-1"
                                    class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                                    <div class="pb-5 text-sm text-slate-500">

                                    </div>
                                </div>
                            </div>

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