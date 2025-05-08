<script>

function toggleScoreInput(type) {
        const totalScoreInput = document.getElementById('totalScoreInput');
        const quarterScoresInput = document.getElementById('quarterScoresInput');

        if (type === 'total') {
            totalScoreInput.classList.remove('hidden');
            quarterScoresInput.classList.add('hidden');
            quarterScoresInput.querySelectorAll('input').forEach(input => {
                input.value = '';
            });
            totalScoreInput.querySelectorAll('input').forEach(input => {
                input.value = '';
            });
        } else if (type === 'quarters') {
            totalScoreInput.classList.add('hidden');
            quarterScoresInput.classList.remove('hidden');
            totalScoreInput.querySelectorAll('input').forEach(input => {
                input.value = '';
            });
        }
    }

function roundDecimal() {
    if (!this.value) {
        return;
    }

    if (this.value < 0) {
        this.value = 0;
    }

    this.value = Math.round(this.value);
}

function fixPercentage() {
    if (!this.value) {
        return;
    }
    if (this.value > 100) {
        this.value = 100;
    } else if (this.value < 0) {
        this.value = 0;
    } else if (this.value.length > 4) {
        this.value = parseFloat(this.value).toFixed(2);
    }
}

function fixSeconds() {
    if (!this.value) {
        return;
    }
    if (this.value > 59) {
        this.value = 59;
    } else if (this.value < 0) {
        this.value = 0;
    } else {
        this.value = Math.round(this.value);
    }
}

function fixMinutes() {
    if (!this.value) {
        return;
    }
    if (this.value > 60) {
        this.value = 60;
    } else if (this.value < 0) {
        this.value = 0;
    } else {
        this.value = Math.round(this.value);
    }
}

function fixTotalScore() {
    if (!this.value) {
        return;
    }
    this.value = Math.round(this.value);

    if (this.value < 0) {
        this.value = 0;
    } else if (this.value > 999) {
        this.value = 999;
    }
}
    
function updateTeamTotalScore(home) {
        const totalScoreInput = document.getElementById(home ? 'home_team_total_score' : 'away_team_total_score');
        const quarterScores = Array.from(document.querySelectorAll(home ? 'input[name^="home_team_quarters_score"]' : 'input[name^="away_team_quarters_score"]'));

        console.log(quarterScores);

        if (!this.value) {
            return;
        }
        this.value = Math.round(this.value);

        if (this.value < 0) {
            this.value = 0;
        } else if (this.value > 99) {
            this.value = 99;
        }

        const totalScore = quarterScores.reduce((sum, input) => sum + (parseInt(input.value) || 0), 0);
        totalScoreInput.value = totalScore;
        mockTotalScoreInput.value = totalScore;
    }


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


function addStatForPlayer(checkbox) {
    const statsWrapper = document.getElementById('stats-wrapper');
    const playerId = checkbox.getAttribute('data-player-id');
    const playerName = checkbox.getAttribute('data-player-name');
    const newStatIndex = statsWrapper.children.length;

    if (checkbox.checked) {
        // Add a new stat element for the player
        const newStatElement = document.createElement('div');
        newStatElement.className = 'stat-item border-2 rounded-md dark:border-gray-700 border-gray-200';
        newStatElement.setAttribute('data-player-id', playerId);

        newStatElement.innerHTML = `
        
        <button onclick="toggleAccordion(event, ${newStatIndex})"
            class="w-full flex justify-between items-center p-6 text-slate-800">
            <span class="dark:text-gray-300">Statistiche <b>${playerName}</b></span>
            <span id="icon-${newStatIndex}" class="text-slate-800 transition-transform duration-300 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                    class="w-4 h-4">
                    <path fill-rule="evenodd"
                        d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z"
                        clip-rule="evenodd" />
                </svg>
            </span>
        </button>
        <div id="content-${newStatIndex}"
            class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-6">
            <div class="pb-5 text-sm text-slate-500 space-y-6">

                <div class="hidden">
                    <x-input-label for="stats[${newStatIndex}][player_id]" :value="__('Giocatore (obbligatorio)')" />
                    <select id="stats[${newStatIndex}][player_id]" name="stats[${newStatIndex}][player_id]"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        readonly
                        required>

                        <option value="${playerId}" selected>${playerName}</option>
                        
                    </select>
                </div>

                <div>
                    <x-input-label :value="__('Minuti giocati')" />
                    <div class="flex items-center gap-2">
                        <div>
                            <x-text-input id="stats[${newStatIndex}][minutes_played]" name="stats[${newStatIndex}][minutes_played]"
                                type="number" min="0" oninput="fixMinutes.call(this)" class="mt-1 block w-full" autocomplete="off" />
                        </div>

                        <span>:</span>

                        <div>
                            <x-text-input id="stats[${newStatIndex}][seconds_played]" name="stats[${newStatIndex}][seconds_played]"
                                type="number" min="0" class="mt-1 block w-full" oninput="fixSeconds.call(this)" autocomplete="off" />
                        </div>
                        
                    </div>
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][points]" :value="__('Punti')" />
                    <x-text-input id="stats[${newStatIndex}][points]" name="stats[${newStatIndex}][points]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][field_goals_made]" :value="__('Tiri segnati')" />
                    <x-text-input id="stats[${newStatIndex}][field_goals_made]"
                        name="stats[${newStatIndex}][field_goals_made]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][field_goals_attempted]" :value="__('Tiri tentati')" />
                    <x-text-input id="stats[${newStatIndex}][field_goals_attempted]"
                        name="stats[${newStatIndex}][field_goals_attempted]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][field_goal_percentage]" :value="__('Percentuale di tiro')" />
                    <x-text-input id="stats[${newStatIndex}][field_goal_percentage]"
                        name="stats[${newStatIndex}][field_goal_percentage]" type="number" min="0" step="0.01"
                        class="mt-1 block w-full" oninput="fixPercentage.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][three_point_field_goals_made]"
                        :value="__('Tiri da 3 segnati')" />
                    <x-text-input id="stats[${newStatIndex}][three_point_field_goals_made]"
                        name="stats[${newStatIndex}][three_point_field_goals_made]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][three_point_field_goals_attempted]"
                        :value="__('Tiri da 3 tentati')" />
                    <x-text-input id="stats[${newStatIndex}][three_point_field_goals_attempted]"
                        name="stats[${newStatIndex}][three_point_field_goals_attempted]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][three_point_field_goal_percentage]"
                        :value="__('Percentuale tiro da 3')" />
                    <x-text-input id="stats[${newStatIndex}][three_point_field_goal_percentage]"
                        name="stats[${newStatIndex}][three_point_field_goal_percentage]" type="number" min="0"
                        class="mt-1 block w-full" oninput="fixPercentage.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][two_point_field_goals_made]"
                        :value="__('Tiri da 2 segnati')" />
                    <x-text-input id="stats[${newStatIndex}][two_point_field_goals_made]"
                        name="stats[${newStatIndex}][two_point_field_goals_made]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][two_point_field_goals_attempted]"
                        :value="__('Tiri da 2 tentati')" />
                    <x-text-input id="stats[${newStatIndex}][two_point_field_goals_attempted]"
                        name="stats[${newStatIndex}][two_point_field_goals_attempted]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][two_point_field_goal_percentage]"
                        :value="__('Percentuale tiro da 2')" />
                    <x-text-input id="stats[${newStatIndex}][two_point_field_goal_percentage]"
                        name="stats[${newStatIndex}][two_point_field_goal_percentage]" type="number" min="0"
                        class="mt-1 block w-full" oninput="fixPercentage.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][free_throws_made]" :value="__('Tiri liberi segnati')" />
                    <x-text-input id="stats[${newStatIndex}][free_throws_made]"
                        name="stats[${newStatIndex}][free_throws_made]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][free_throws_attempted]" :value="__('Tiri liberi tentati')" />
                    <x-text-input id="stats[${newStatIndex}][free_throws_attempted]"
                        name="stats[${newStatIndex}][free_throws_attempted]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][free_throw_percentage]" :value="__('Percentuale tiro libero')" />
                    <x-text-input id="stats[${newStatIndex}][free_throw_percentage]"
                        name="stats[${newStatIndex}][free_throw_percentage]" type="number" min="0"
                        class="mt-1 block w-full" oninput="fixPercentage.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][offensive_rebounds]" :value="__('Rimbalzi offensivi')" />
                    <x-text-input id="stats[${newStatIndex}][offensive_rebounds]"
                        name="stats[${newStatIndex}][offensive_rebounds]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][defensive_rebounds]" :value="__('Rimbalzi difensivi')" />
                    <x-text-input id="stats[${newStatIndex}][defensive_rebounds]"
                        name="stats[${newStatIndex}][defensive_rebounds]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][total_rebounds]" :value="__('Rimbalzi totali')" />
                    <x-text-input id="stats[${newStatIndex}][total_rebounds]" name="stats[${newStatIndex}][total_rebounds]"
                        type="number" min="0" class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][assists]" :value="__('Assist')" />
                    <x-text-input id="stats[${newStatIndex}][assists]" name="stats[${newStatIndex}][assists]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][turnovers]" :value="__('Palle perse')" />
                    <x-text-input id="stats[${newStatIndex}][turnovers]" name="stats[${newStatIndex}][turnovers]"
                        type="number" min="0" class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][steals]" :value="__('Palle rubate')" />
                    <x-text-input id="stats[${newStatIndex}][steals]" name="stats[${newStatIndex}][steals]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][blocks]" :value="__('Stoppate')" />
                    <x-text-input id="stats[${newStatIndex}][blocks]" name="stats[${newStatIndex}][blocks]" type="number" min="0"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][personal_fouls]" :value="__('Falli personali')" />
                    <x-text-input id="stats[${newStatIndex}][personal_fouls]" name="stats[${newStatIndex}][personal_fouls]"
                        type="number" min="0" class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][performance_index_rating]"
                        :value="__('Performance Index Rating')" />
                    <x-text-input id="stats[${newStatIndex}][performance_index_rating]"
                        name="stats[${newStatIndex}][performance_index_rating]" type="number"
                        class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][efficiency]" :value="__('Efficenza')" />
                    <x-text-input id="stats[${newStatIndex}][efficiency]" name="stats[${newStatIndex}][efficiency]"
                        type="number" class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>


                <div>
                    <x-input-label for="stats[${newStatIndex}][plus_minus]" :value="__('Plus-Minus')" />
                    <x-text-input id="stats[${newStatIndex}][plus_minus]" name="stats[${newStatIndex}][plus_minus]"
                        type="number" class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" />
                </div>

            </div>
        </div>
    `;


        statsWrapper.appendChild(newStatElement);
    } else {
        // Remove the stat element for the player
        const statElement = statsWrapper.querySelector(`.stat-item[data-player-id="${playerId}"]`);
        if (statElement) {
            statsWrapper.removeChild(statElement);
        }
    }
}


</script>

<style>
    .toggle-checkbox:checked + div .toggle-span::before {
    content: "-";
}

.toggle-checkbox:not(:checked) + div .toggle-span::before {
    content: "+";
}
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifica partita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Modifica partita') }}
                    </h2>

                    <form method="POST" action="{{ route('games.update', $game->id) }}" class="m-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Game Date -->
                        <div>
                            <x-input-label for="date" :value="__('Data (obbligatorio)')" />
                            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full dark:[color-scheme:dark]"
                                value="{{ $game->date }}" autocomplete="off" required />
                        </div>

                        <!-- Home Team -->
                        <div>
                            <x-input-label for="home_team_id" :value="__('Locali (obbligatorio)')" />
                            <select id="home_team_id" name="home_team_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                onchange="toggleHomeTeamRoster.call(this, event)" required>
                                <option value="" selected></option>

                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}"
                                        {{ $game->home_team_id == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div id="homeTeamDetails" class="mt-4">
                            <h3 class="text-gray-700 dark:text-gray-300">Players:</h3>
                            <ul id="homeTeamPlayersList" class="list-disc list-inside text-gray-700 dark:text-gray-300">
                                @foreach ($game->home_team->players as $player)
                                    <div>
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" class="player-checkbox"
                                                data-player-id="{{ $player->id }}"
                                                data-player-name="{{ $player->name }}"
                                                onchange="addStatForPlayer(this)"
                                                {{ in_array($player->id, $game->stats->pluck('player_id')->toArray()) ? 'checked' : '' }}>
                                            <span>{{ $player->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Away Team -->
                        <div>
                            <x-input-label for="away_team_id" :value="__('Ospiti (obbligatorio)')" />
                            <select id="away_team_id" name="away_team_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                onchange="toggleAwayTeamRoster.call(this, event)" required>
                                <option value="" selected></option>

                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}"
                                        {{ $game->away_team_id == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div id="awayTeamDetails" class="mt-4">
                            <h3 class="text-gray-700 dark:text-gray-300">Players:</h3>
                            <ul id="awayTeamPlayersList" class="list-disc list-inside text-gray-700 dark:text-gray-300">
                                @foreach ($game->away_team->players as $player)
                                    <div>
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" class="player-checkbox"
                                                data-player-id="{{ $player->id }}"
                                                data-player-name="{{ $player->name }}"
                                                onchange="addStatForPlayer(this)"
                                                {{ in_array($player->id, $game->stats->pluck('player_id')->toArray()) ? 'checked' : '' }}>
                                            <span>{{ $player->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Game Results -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Risultato della partita') }}
                            </h3>

                            <!-- Quarter Scores Input -->
                            <div id="quarterScoresInput" class="mt-4 space-y-6">
                                <div class="flex items-center gap-4">
                                    <div>
                                        <x-input-label for="home_team_first_quarter_score" :value="__('Punteggio Locali Q1')" />
                                        <x-text-input id="home_team_first_quarter_score" name="home_team_quarters_score[0]" type="number" min="0"
                                            class="mt-1 block w-full" oninput="updateTeamTotalScore.call(this, true)" value="{{ old('home_team_first_quarter_score', $game->home_team_first_quarter_score) }}" />
                                    </div>
                                    <div>
                                        <x-input-label for="away_team_first_quarter_score" :value="__('Punteggio Ospiti Q1')" />
                                        <x-text-input id="away_team_first_quarter_score" name="away_team_quarters_score[0]" type="number" min="0"
                                            class="mt-1 block w-full" oninput="updateTeamTotalScore.call(this, false)" value="{{ old('away_team_first_quarter_score', $game->away_team_first_quarter_score) }}" />
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div>
                                        <x-input-label for="home_team_second_quarter_score" :value="__('Punteggio Locali Q2')" />
                                        <x-text-input id="home_team_second_quarter_score" name="home_team_quarters_score[1]" type="number" min="0"
                                            class="mt-1 block w-full" oninput="updateTeamTotalScore.call(this, true)" value="{{ old('home_team_second_quarter_score', $game->home_team_second_quarter_score) }}" />
                                    </div>
                                    <div>
                                        <x-input-label for="away_team_second_quarter_score" :value="__('Punteggio Ospiti Q2')" />
                                        <x-text-input id="away_team_second_quarter_score" name="away_team_quarters_score[1]" type="number" min="0"
                                            class="mt-1 block w-full" oninput="updateTeamTotalScore.call(this, false)" value="{{ old('away_team_second_quarter_score', $game->away_team_second_quarter_score) }}" />
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div>
                                        <x-input-label for="home_team_third_quarter_score" :value="__('Punteggio Locali Q3')" />
                                        <x-text-input id="home_team_third_quarter_score" name="home_team_quarters_score[2]" type="number" min="0"
                                            class="mt-1 block w-full" oninput="updateTeamTotalScore.call(this, true)" value="{{ old('home_team_third_quarter_score', $game->home_team_third_quarter_score) }}" />
                                    </div>
                                    <div>
                                        <x-input-label for="away_team_third_quarter_score" :value="__('Punteggio Ospiti Q3')" />
                                        <x-text-input id="away_team_third_quarter_score" name="away_team_quarters_score[2]" type="number" min="0"
                                            class="mt-1 block w-full" oninput="updateTeamTotalScore.call(this, false)" value="{{ old('away_team_third_quarter_score', $game->away_team_third_quarter_score) }}" />
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div>
                                        <x-input-label for="home_team_fourth_quarter_score" :value="__('Punteggio Locali Q4')" />
                                        <x-text-input id="home_team_fourth_quarter_score" name="home_team_quarters_score[3]" type="number" min="0"
                                            class="mt-1 block w-full" oninput="updateTeamTotalScore.call(this, true)" value="{{ old('home_team_fourth_quarter_score', $game->home_team_fourth_quarter_score) }}" />
                                    </div>
                                    <div>
                                        <x-input-label for="away_team_fourth_quarter_score" :value="__('Punteggio Ospiti Q4')" />
                                        <x-text-input id="away_team_fourth_quarter_score" name="away_team_quarters_score[3]" type="number" min="0"
                                            class="mt-1 block w-full" oninput="updateTeamTotalScore.call(this, false)" value="{{ old('away_team_fourth_quarter_score', $game->away_team_fourth_quarter_score) }}" />
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div>
                                        <x-input-label for="home_team_total_score" :value="__('Punteggio totale Locali')" />
                                        <x-text-input id="home_team_total_score" name="home_team_total_score" type="number" min="0"
                                            class="mt-1 block w-full" value="{{ old('home_team_total_score', $game->home_team_total_score) }}" />
                                    </div>
                                    <div>
                                        <x-input-label for="away_team_total_score" :value="__('Punteggio totale Ospiti')" />
                                        <x-text-input id="away_team_total_score" name="away_team_total_score" type="number" min="0"
                                            class="mt-1 block w-full" value="{{ old('away_team_total_score', $game->away_team_total_score) }}" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Wrapper -->
                        <div id="stats-wrapper" class="mt-6 space-y-4">
                            @foreach ($game->stats as $index => $stat)
                                <div class="stat-item border-2 rounded-md dark:border-gray-700 border-gray-200" data-player-id="{{ $stat->player_id }}">
                                    
                                    <button onclick="toggleAccordion(event, {{ $index }})"
                                        class="w-full flex justify-between items-center p-6 text-slate-800">
                                        <span class="dark:text-gray-300">Statistiche <b>{{ $stat->player->name }}</b></span>
                                        <span id="icon-{{$index}}" class="text-slate-800 transition-transform duration-300 dark:text-gray-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                                class="w-4 h-4">
                                                <path fill-rule="evenodd"
                                                    d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div id="content-{{ $index }}"
                                        class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-6">
                                        <div class="pb-5 text-sm text-slate-500 space-y-6">

                                            <div class="hidden">
                                                <x-input-label for="stats[{{ $index }}][player_id]" :value="__('Giocatore (obbligatorio)')" />
                                                <select id="stats[{{ $index }}][player_id]" name="stats[{{ $index }}][player_id]"
                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                    readonly
                                                    required>

                                                    <option value="{{ $stat->player_id }}" selected>${playerName}</option>
                                                    
                                                </select>
                                            </div>

                                            <div>
                                                <x-input-label :value="__('Minuti giocati')" />
                                                <div class="flex items-center gap-2">
                                                    <div>
                                                        <x-text-input id="stats[{{ $index }}][minutes_played]" name="stats[{{ $index }}][minutes_played]"
                                                            type="number" min="0" oninput="fixMinutes.call(this)" class="mt-1 block w-full" autocomplete="off" value="{{ intdiv($stat->seconds_played, 60) }}" />
                                                    </div>

                                                    <span>:</span>

                                                    <div>
                                                        <x-text-input id="stats[{{ $index }}][seconds_played]" name="stats[{{ $index }}][seconds_played]"
                                                            type="number" min="0" class="mt-1 block w-full" oninput="fixSeconds.call(this)" autocomplete="off" value="{{ $stat->seconds_played % 60 }}" />
                                                    </div>
                                                    
                                                </div>
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][points]" :value="__('Punti')" />
                                                <x-text-input id="stats[{{ $index }}][points]" name="stats[{{ $index }}][points]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->points }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][field_goals_made]" :value="__('Tiri segnati')" />
                                                <x-text-input id="stats[{{ $index }}][field_goals_made]"
                                                    name="stats[{{ $index }}][field_goals_made]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->field_goals_made }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][field_goals_attempted]" :value="__('Tiri tentati')" />
                                                <x-text-input id="stats[{{ $index }}][field_goals_attempted]"
                                                    name="stats[{{ $index }}][field_goals_attempted]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->field_goals_attempted }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][field_goal_percentage]" :value="__('Percentuale di tiro')" />
                                                <x-text-input id="stats[{{ $index }}][field_goal_percentage]"
                                                    name="stats[{{ $index }}][field_goal_percentage]" type="number" min="0" step="0.01"
                                                    class="mt-1 block w-full" oninput="fixPercentage.call(this)" autocomplete="off" value="{{ $stat->field_goal_percentage }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][three_point_field_goals_made]"
                                                    :value="__('Tiri da 3 segnati')" />
                                                <x-text-input id="stats[{{ $index }}][three_point_field_goals_made]"
                                                    name="stats[{{ $index }}][three_point_field_goals_made]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->three_point_field_goals_made }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][three_point_field_goals_attempted]"
                                                    :value="__('Tiri da 3 tentati')" />
                                                <x-text-input id="stats[{{ $index }}][three_point_field_goals_attempted]"
                                                    name="stats[{{ $index }}][three_point_field_goals_attempted]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->three_point_field_goals_attempted }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][three_point_field_goal_percentage]"
                                                    :value="__('Percentuale tiro da 3')" />
                                                <x-text-input id="stats[{{ $index }}][three_point_field_goal_percentage]"
                                                    name="stats[{{ $index }}][three_point_field_goal_percentage]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="fixPercentage.call(this)" autocomplete="off" value="{{ $stat->three_point_field_goal_percentage }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][two_point_field_goals_made]"
                                                    :value="__('Tiri da 2 segnati')" />
                                                <x-text-input id="stats[{{ $index }}][two_point_field_goals_made]"
                                                    name="stats[{{ $index }}][two_point_field_goals_made]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->two_point_field_goals_made }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][two_point_field_goals_attempted]"
                                                    :value="__('Tiri da 2 tentati')" />
                                                <x-text-input id="stats[{{ $index }}][two_point_field_goals_attempted]"
                                                    name="stats[{{ $index }}][two_point_field_goals_attempted]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->two_point_field_goals_attempted }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][two_point_field_goal_percentage]"
                                                    :value="__('Percentuale tiro da 2')" />
                                                <x-text-input id="stats[{{ $index }}][two_point_field_goal_percentage]"
                                                    name="stats[{{ $index }}][two_point_field_goal_percentage]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="fixPercentage.call(this)" autocomplete="off" value="{{ $stat->two_point_field_goal_percentage }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][free_throws_made]" :value="__('Tiri liberi segnati')" />
                                                <x-text-input id="stats[{{ $index }}][free_throws_made]"
                                                    name="stats[{{ $index }}][free_throws_made]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->free_throws_made }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][free_throws_attempted]" :value="__('Tiri liberi tentati')" />
                                                <x-text-input id="stats[{{ $index }}][free_throws_attempted]"
                                                    name="stats[{{ $index }}][free_throws_attempted]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->free_throws_attempted }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][free_throw_percentage]" :value="__('Percentuale tiro libero')" />
                                                <x-text-input id="stats[{{ $index }}][free_throw_percentage]"
                                                    name="stats[{{ $index }}][free_throw_percentage]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="fixPercentage.call(this)" autocomplete="off" value="{{ $stat->free_throw_percentage }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][offensive_rebounds]" :value="__('Rimbalzi offensivi')" />
                                                <x-text-input id="stats[{{ $index }}][offensive_rebounds]"
                                                    name="stats[{{ $index }}][offensive_rebounds]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->offensive_rebounds }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][defensive_rebounds]" :value="__('Rimbalzi difensivi')" />
                                                <x-text-input id="stats[{{ $index }}][defensive_rebounds]"
                                                    name="stats[{{ $index }}][defensive_rebounds]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->defensive_rebounds }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][total_rebounds]" :value="__('Rimbalzi totali')" />
                                                <x-text-input id="stats[{{ $index }}][total_rebounds]" name="stats[{{ $index }}][total_rebounds]"
                                                    type="number" min="0" class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->total_rebounds }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][assists]" :value="__('Assist')" />
                                                <x-text-input id="stats[{{ $index }}][assists]" name="stats[{{ $index }}][assists]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->assists }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][turnovers]" :value="__('Palle perse')" />
                                                <x-text-input id="stats[{{ $index }}][turnovers]" name="stats[{{ $index }}][turnovers]"
                                                    type="number" min="0" class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->turnovers }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][steals]" :value="__('Palle rubate')" />
                                                <x-text-input id="stats[{{ $index }}][steals]" name="stats[{{ $index }}][steals]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->steals }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][blocks]" :value="__('Stoppate')" />
                                                <x-text-input id="stats[{{ $index }}][blocks]" name="stats[{{ $index }}][blocks]" type="number" min="0"
                                                    class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->blocks }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][personal_fouls]" :value="__('Falli personali')" />
                                                <x-text-input id="stats[{{ $index }}][personal_fouls]" name="stats[{{ $index }}][personal_fouls]"
                                                    type="number" min="0" class="mt-1 block w-full" oninput="roundDecimal.call(this)" autocomplete="off" value="{{ $stat->personal_fouls }}" />
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][performance_index_rating]"
                                                    :value="__('Performance Index Rating')" />
                                                <label class="relative">
                                                    <input type="checkbox" name="stats[{{ $index }}][performance_index_rating_sign]" class="hidden toggle-checkbox"
                                                        {{ $stat->performance_index_rating < 0 ? 'checked' : '' }} />
                                                    <div class="flex items-center ">
                                                        <div
                                                        class="w-10 h-10 flex mt-1 items-center justify-center border rounded-l-md cursor-pointer border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 active:border-indigo-500 dark:active:border-indigo-600 focus:ring-indigo-500 dark:active:ring-indigo-600 shadow-sm"
                                                    >
                                                        <span class="text-xl font-semibold select-none toggle-span"></span>
                                                    </div>
                                                </label>
                                                <x-text-input id="stats[{{ $index }}][performance_index_rating]"
                                                    name="stats[{{ $index }}][performance_index_rating]" type="number" min="0"
                                                    class="mt-1 block w-full !rounded-l-none" oninput="roundDecimal.call(this)" autocomplete="off" value="{{abs($stat->performance_index_rating)}}" />
                                                </div>
                                            </div>
                        
                        
                                            <div>
                                                <x-input-label for="stats[{{ $index }}][efficiency]" :value="__('Efficenza')" />
                                                <label class="relative">
                                                    <input type="checkbox" name="stats[{{ $index }}][efficiency_sign]" class="hidden toggle-checkbox" 
                                                        {{ $stat->efficiency < 0 ? 'checked' : '' }} />
                                                    <div class="flex items-center">
                                                        <div
                                                        class="w-10 h-10 flex mt-1 items-center justify-center border rounded-l-md cursor-pointer border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 active:border-indigo-500 dark:active:border-indigo-600 focus:ring-indigo-500 dark:active:ring-indigo-600 shadow-sm"
                                                    >
                                                        <span class="text-xl font-semibold select-none toggle-span"></span>
                                                    </div>
                                                </label>
                                                <x-text-input id="stats[{{ $index }}][efficiency]" name="stats[{{ $index }}][efficiency]"
                                                    type="number" min="0" class="mt-1 block w-full !rounded-l-none" oninput="roundDecimal.call(this)" autocomplete="off" value="{{abs($stat->efficiency)}}" />
                                                </div>
                                            </div>


                                            <div>
                                                <x-input-label for="stats[{{ $index }}][plus_minus]" :value="__('Plus-Minus')" />
                                                <label class="relative">
                                                    <input type="checkbox" name="stats[{{ $index }}][plus_minus_sign]" class="hidden toggle-checkbox" 
                                                        {{ $stat->plus_minus < 0 ? 'checked' : '' }} />
                                                    <div class="flex items-center">
                                                        <div
                                                        class="w-10 h-10 flex mt-1 items-center justify-center border rounded-l-md cursor-pointer border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 active:border-indigo-500 dark:active:border-indigo-600 focus:ring-indigo-500 dark:active:ring-indigo-600 shadow-sm"
                                                    >
                                                        <span class="text-xl font-semibold select-none toggle-span"></span>
                                                    </div>
                                                </label>
                                                <x-text-input id="stats[{{ $index }}][plus_minus]" name="stats[{{ $index }}][plus_minus]"
                                                type="number" min="0" class="mt-1 block w-full !rounded-l-none" oninput="roundDecimal.call(this)" autocomplete="off" value="{{abs($stat->plus_minus)}}" />
                                                    
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Salva modifiche') }}</x-primary-button>
                            <a href="{{ route('games.index') }}" class="text-gray-500 hover:underline">{{ __('Annulla') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@php
    
    function getQuarterScoreName(int $index) {
        switch ($index) {
            case 1:
                return 'first';
            case 2:
                return 'second';
            case 3:
                return 'third';
            case 4:
                return 'fourth';
            default:
                return 'unknown';
        }
    }

@endphp