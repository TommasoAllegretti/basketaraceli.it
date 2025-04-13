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
            
            <button onclick="toggleAccordion(event, ${newStatIndex})"
                class="w-full flex justify-between items-center py-5 text-slate-800">
                <span>Statistiche Giocatore ${newStatIndex}</span>
                <span id="icon-1" class="text-slate-800 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                        class="w-4 h-4">
                        <path fill-rule="evenodd"
                            d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
            </button>
            <div id="content-${newStatIndex}"
                class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                <div class="pb-5 text-sm text-slate-500 space-y-6">

                    <div>
                        <x-input-label for="stats${newStatIndex}[player_id]" :value="__('Giocatore (obbligatorio)')" />
                        <select id="stats${newStatIndex}[player_id]" name="stats${newStatIndex}[player_id]"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required>

                            <option value="" selected>-</option>

                            @foreach ($players as $player)
                                <option value="{{ $player->id }}">#{{ $player->jersey_number }} {{ $player->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div>
                        <x-input-label for="stats${newStatIndex}[seconds_played]" :value="__('Secondi giocati')" />
                        <x-text-input id="stats${newStatIndex}[seconds_played]" name="stats${newStatIndex}[seconds_played]"
                            type="number" class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[points]" :value="__('Punti')" />
                        <x-text-input id="stats${newStatIndex}[points]" name="stats${newStatIndex}[points]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[field_goals_made]" :value="__('Tiri segnati')" />
                        <x-text-input id="stats${newStatIndex}[field_goals_made]"
                            name="stats${newStatIndex}[field_goals_made]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[field_goals_attempted]" :value="__('Tiri tentati')" />
                        <x-text-input id="stats${newStatIndex}[field_goals_attempted]"
                            name="stats${newStatIndex}[field_goals_attempted]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[field_goal_percentage]" :value="__('Percentuale di tiro')" />
                        <x-text-input id="stats${newStatIndex}[field_goal_percentage]"
                            name="stats${newStatIndex}[field_goal_percentage]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[three_point_field_goals_made]"
                            :value="__('Tiri da 3 segnati')" />
                        <x-text-input id="stats${newStatIndex}[three_point_field_goals_made]"
                            name="stats${newStatIndex}[three_point_field_goals_made]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[three_point_field_goals_attmepted]"
                            :value="__('Tiri da 3 tentati')" />
                        <x-text-input id="stats${newStatIndex}[three_point_field_goals_attmepted]"
                            name="stats${newStatIndex}[three_point_field_goals_attmepted]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[three_point_field_goal_percentage]"
                            :value="__('Percentuale tiro da 3')" />
                        <x-text-input id="stats${newStatIndex}[three_point_field_goal_percentage]"
                            name="stats${newStatIndex}[three_point_field_goal_percentage]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[two_point_field_goals_made]"
                            :value="__('Tiri da 2 segnati')" />
                        <x-text-input id="stats${newStatIndex}[two_point_field_goals_made]"
                            name="stats${newStatIndex}[two_point_field_goals_made]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[two_point_field_goals_attmepted]"
                            :value="__('Tiri da 2 tentati')" />
                        <x-text-input id="stats${newStatIndex}[two_point_field_goals_attmepted]"
                            name="stats${newStatIndex}[two_point_field_goals_attmepted]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[two_point_field_goal_percentage]"
                            :value="__('Percentuale tiro da 2')" />
                        <x-text-input id="stats${newStatIndex}[two_point_field_goal_percentage]"
                            name="stats${newStatIndex}[two_point_field_goal_percentage]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[free_throws_made]" :value="__('Tiri liberi segnati')" />
                        <x-text-input id="stats${newStatIndex}[free_throws_made]"
                            name="stats${newStatIndex}[free_throws_made]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[free_throws_attmepted]" :value="__('Tiri liberi tentati')" />
                        <x-text-input id="stats${newStatIndex}[free_throws_attmepted]"
                            name="stats${newStatIndex}[free_throws_attmepted]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[free_throw_percentage]" :value="__('Percentuale tiro libero')" />
                        <x-text-input id="stats${newStatIndex}[free_throw_percentage]"
                            name="stats${newStatIndex}[free_throw_percentage]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[offensive_rebounds]" :value="__('Rimbalzi offensivi')" />
                        <x-text-input id="stats${newStatIndex}[offensive_rebounds]"
                            name="stats${newStatIndex}[offensive_rebounds]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[defensive_rebounds]" :value="__('Rimbalzi difensivi')" />
                        <x-text-input id="stats${newStatIndex}[defensive_rebounds]"
                            name="stats${newStatIndex}[defensive_rebounds]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[total_rebounds]" :value="__('Rimbalzi totali')" />
                        <x-text-input id="stats${newStatIndex}[total_rebounds]" name="stats${newStatIndex}[total_rebounds]"
                            type="number" class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[assists]" :value="__('Assist')" />
                        <x-text-input id="stats${newStatIndex}[assists]" name="stats${newStatIndex}[assists]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[turnovers]" :value="__('Palle perse')" />
                        <x-text-input id="stats${newStatIndex}[turnovers]" name="stats${newStatIndex}[turnovers]"
                            type="number" class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[steals]" :value="__('Palle rubate')" />
                        <x-text-input id="stats${newStatIndex}[steals]" name="stats${newStatIndex}[steals]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[blocks]" :value="__('Stoppate')" />
                        <x-text-input id="stats${newStatIndex}[blocks]" name="stats${newStatIndex}[blocks]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[personal_fouls]" :value="__('Falli personali')" />
                        <x-text-input id="stats${newStatIndex}[personal_fouls]" name="stats${newStatIndex}[personal_fouls]"
                            type="number" class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[performance_index_rating]"
                            :value="__('Performance Index Rating')" />
                        <x-text-input id="stats${newStatIndex}[performance_index_rating]"
                            name="stats${newStatIndex}[performance_index_rating]" type="number"
                            class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[efficiency]" :value="__('Efficenza')" />
                        <x-text-input id="stats${newStatIndex}[efficiency]" name="stats${newStatIndex}[efficiency]"
                            type="number" class="mt-1 block w-full" autocomplete="off" />
                    </div>


                    <div>
                        <x-input-label for="stats${newStatIndex}[plus_minus]" :value="__('Plus-Minus')" />
                        <x-text-input id="stats${newStatIndex}[plus_minus]" name="stats${newStatIndex}[plus_minus]"
                            type="number" class="mt-1 block w-full" autocomplete="off" />
                    </div>

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