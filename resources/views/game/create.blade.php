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

    function roundDecimal() {
        if (!this.value) {
            return;
        }
        this.value = Math.round(this.value);
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

    function addStatForPlayer(checkbox) {
        const statsWrapper = document.getElementById('stats-wrapper');
        const playerId = checkbox.getAttribute('data-player-id');
        const playerName = checkbox.getAttribute('data-player-name');
        const newStatIndex = statsWrapper.children.length;

        if (checkbox.checked) {
            // Add a new stat element for the player
            const newStatElement = document.createElement('div');
            newStatElement.className = 'stat-item border rounded-md';
            newStatElement.setAttribute('data-player-id', playerId);

            newStatElement.innerHTML = `
            
            <button onclick="toggleAccordion(event, ${newStatIndex})"
                class="w-full flex justify-between items-center p-6 text-slate-800">
                <span>Statistiche <b>${playerName}</b></span>
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

    async function toggleHomeTeamRoster(e) {
        const homeTeamDetails = document.getElementById('homeTeamDetails');
        if (!this.value) {
            homeTeamDetails.classList.add('hidden');
            return
        }

        try {
            const response = await fetch(`/teams/${this.value}/players`);
            if (!response.ok) {
                throw new Error('Failed to fetch players');
            }
            const playersList = document.getElementById('homeTeamPlayersList');

            const players = await response.json();
            playersList.innerHTML = players
                .map(player => `
                    <div>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="player-checkbox" data-player-id="${player.id}" data-player-name="${player.name}" onchange="addStatForPlayer(this)">
                            <span>${player.name}</span>
                        </label>
                    </div>
                `)
                .join('');

            homeTeamDetails.classList.remove('hidden');
        } catch (error) {
            console.error(error);
            playersList.innerHTML = '<li>Error loading players</li>';
        }
    }

    async function toggleAwayTeamRoster(e) {
        const awayTeamDetails = document.getElementById('awayTeamDetails');
        if (!this.value) {
            awayTeamDetails.classList.add('hidden');
            return
        }

        try {
            const response = await fetch(`/teams/${this.value}/players`);
            if (!response.ok) {
                throw new Error('Failed to fetch players');
            }
            const playersList = document.getElementById('awayTeamPlayersList');

            const players = await response.json();
            playersList.innerHTML = players
                .map(player => `
                    <div>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="player-checkbox" data-player-id="${player.id}" data-player-name="${player.name}" onchange="addStatForPlayer(this)">
                            <span>${player.name}</span>
                        </label>
                    </div>
                `)
                .join('');

            awayTeamDetails.classList.remove('hidden');
        } catch (error) {
            console.error(error);
            playersList.innerHTML = '<li>Error loading players</li>';
        }
    }


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

                    <form method="POST" action="{{ route('games.store') }}" class="m-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="date" :value="__('Data (obbligatorio)')" />
                            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" autocomplete="off"
                                required />
                        </div>

                        <div>
                            <x-input-label for="home_team_id" :value="__('Locali (obbligatorio)')" />
                            <select id="home_team_id" name="home_team_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                onchange="toggleHomeTeamRoster.call(this, event)" required>
                                <option value="" selected></option>

                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div id="homeTeamDetails" class="mt-4 hidden">
                            <h3 class="text-gray-700 dark:text-gray-300">Players:</h3>
                            <ul id="homeTeamPlayersList" class="list-disc list-inside text-gray-700 dark:text-gray-300">
                            </ul>
                        </div>

                        <div>
                            <x-input-label for="away_team_id" :value="__('Ospiti (obbligatorio)')" />
                            <select id="away_team_id" name="away_team_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                onchange="toggleAwayTeamRoster.call(this, event)" required>
                                <option value="" selected></option>

                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div id="awayTeamDetails" class="mt-4 hidden">
                            <h3 class="text-gray-700 dark:text-gray-300">Players:</h3>
                            <ul id="awayTeamPlayersList" class="list-disc list-inside text-gray-700 dark:text-gray-300">
                            </ul>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Risultato della partita') }}
                            </h3>

                            <!-- Quarter Scores Input -->
                            <div id="quarterScoresInput" class="mt-4 space-y-6">
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="flex items-center gap-4">
                                        <div>
                                            <x-input-label for="home_team_quarters_score_{{ $i }}" :value="__('Punteggio Locali Q' . ($i + 1))" />
                                            <x-text-input id="home_team_quarters_score_{{ $i }}"
                                                name="home_team_quarters_score[{{ $i }}]" type="number" min="0"
                                                class="mt-1 block w-full" oninput="updateTeamTotalScore.call(this, true)"
                                                value="{{ old('home_team_quarters_score.' . $i, $game->home_team_quarters_score[$i] ?? '') }}" />
                                        </div>
                                        <div>
                                            <x-input-label for="away_team_quarters_score_{{ $i }}" :value="__('Punteggio Ospiti Q' . ($i + 1))" />
                                            <x-text-input id="away_team_quarters_score_{{ $i }}"
                                                name="away_team_quarters_score[{{ $i }}]" type="number" min="0"
                                                class="mt-1 block w-full" oninput="updateTeamTotalScore.call(this, false)"
                                                value="{{ old('away_team_quarters_score.' . $i, $game->away_team_quarters_score[$i] ?? '') }}" />
                                        </div>
                                    </div>
                                @endfor
                                <div class="flex items-center gap-4">
                                    <div>
                                        <x-input-label for="home_team_total_score" value="Punteggio totale Locali" />
                                        <x-text-input id="home_team_total_score" name="home_team_total_score"
                                            type="number" min="0" class="mt-1 block w-full" autocomplete="off" />
                                    </div>
                                    <div>
                                        <x-input-label for="away_team_total_score" value="Punteggio totale Ospiti" />
                                        <x-text-input id="away_team_total_score" name="away_team_total_score"
                                            type="number" min="0" class="mt-1 block w-full" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="stats-wrapper" class="mt-6 space-y-4"></div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Salva') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>

@php

    function getQuarterScoreName(int $index)
    {
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