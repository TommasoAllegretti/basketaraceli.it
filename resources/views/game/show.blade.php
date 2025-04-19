<script>

    function activateTab(tabNumber) {
        const tab1Btn = document.getElementById('tab1Btn');
        const tab2Btn = document.getElementById('tab2Btn');
        const tab1Content = document.getElementById('tab1Content');
        const tab2Content = document.getElementById('tab2Content');
        const activeClasses = "border-blue-500 text-blue-600";
        const inactiveClasses = "border-transparent text-gray-600";

        if (tabNumber === 1) {
            tab1Btn.classList.add(...activeClasses.split(" "));
            tab1Btn.classList.remove(...inactiveClasses.split(" "));
            tab2Btn.classList.remove(...activeClasses.split(" "));
            tab2Btn.classList.add(...inactiveClasses.split(" "));
            tab1Content.classList.remove("hidden");
            tab2Content.classList.add("hidden");
        } else {
            tab2Btn.classList.add(...activeClasses.split(" "));
            tab2Btn.classList.remove(...inactiveClasses.split(" "));
            tab1Btn.classList.remove(...activeClasses.split(" "));
            tab1Btn.classList.add(...inactiveClasses.split(" "));
            tab2Content.classList.remove("hidden");
            tab1Content.classList.add("hidden");
        }
    }


</script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span class="font-semibold ">{{ $game->home_team->name }}</span> vs <span
                class="font-semibold ">{{ $game->away_team->name }}</span>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 overflow-hidden shadow-sm sm:rounded-lg py-6 space-y-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <div class="space-y-6 w-full">

                        <h2 class="font-semibold">Generale</h2>

                        <p>Data: <span class="font-bold">{{ $game->date }}</span></p>


                        <div class="bg-white shadow-lg rounded-xl w-full p-4">
                            <div class="flex border-b w-full">
                                <button id="tab1Btn" onclick="activateTab(1)"
                                    class="tab-btn flex-1 py-2 text-center font-medium border-b-2 hover:bg-gray-100 border-blue-500 text-blue-600">
                                    {{ $game->home_team->name }}
                                </button>
                                <button id="tab2Btn" onclick="activateTab(2)"
                                    class="tab-btn flex-1 py-2 text-center font-medium border-b-2 border-transparent hover:bg-gray-100">
                                    {{ $game->away_team->name }}
                                </button>
                            </div>

                            <div id="tab1Content" class="tab-content p-4">

                                <div class="relative overflow-x-auto">
                                    <table
                                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Giocatore
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    MIN
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    PTS
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FGM
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FGA
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FG%
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    3PM
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    3PA
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    3P%
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    2PM
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    2PA
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    2P%
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FTM
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FTA
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FT%
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    OREB
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    DREB
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    REB
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    AST
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    TOV
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    STL
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    BLK
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    PF
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    PIR
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    EFF
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    +/-
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($home_team_stats as $home_team_player_stats)
                                                <tr
                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                    <th scope="row"
                                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $home_team_player_stats->player->name}}
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        {{ formatSecondsToMinutes($home_team_player_stats->seconds_played) }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->points }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->field_goals_made }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->field_goals_attempted }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->field_goal_percentage }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->three_point_field_goals_made }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->three_point_field_goals_attempted }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->three_point_field_goal_percentage }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->two_point_field_goals_made }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->two_point_field_goals_attempted }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->two_point_field_goal_percentage }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->free_throws_made }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->free_throws_attempted }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->free_throw_percentage }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->offensive_rebounds }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->defensive_rebounds }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->total_rebounds }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->assists }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->turnovers }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->steals }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->blocks }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->personal_fouls }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->performance_index_rating }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->efficiency }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $home_team_player_stats->plus_minus }}
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="tab2Content" class="tab-content p-4 hidden">

                                <div class="relative overflow-x-auto">
                                    <table
                                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Giocatore
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    MIN
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    PTS
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FGM
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FGA
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FG%
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    3PM
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    3PA
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    3P%
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    2PM
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    2PA
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    2P%
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FTM
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FTA
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    FT%
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    OREB
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    DREB
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    REB
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    AST
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    TOV
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    STL
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    BLK
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    PF
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    PIR
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    EFF
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    +/-
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($away_team_stats as $away_team_player_stats)
                                                <tr
                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                    <th scope="row"
                                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $away_team_player_stats->player->name}}
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        {{ formatSecondsToMinutes($away_team_player_stats->seconds_played) }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->points }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->field_goals_made }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->field_goals_attempted }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->field_goal_percentage }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->three_point_field_goals_made }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->three_point_field_goals_attempted }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->three_point_field_goal_percentage }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->two_point_field_goals_made }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->two_point_field_goals_attempted }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->two_point_field_goal_percentage }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->free_throws_made }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->free_throws_attempted }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->free_throw_percentage }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->offensive_rebounds }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->defensive_rebounds }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->total_rebounds }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->assists }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->turnovers }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->steals }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->blocks }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->personal_fouls }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->performance_index_rating }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->efficiency }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $away_team_player_stats->plus_minus }}
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@php
    function formatSecondsToMinutes(int $seconds): string
    {
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;
        return sprintf('%02d:%02d', $minutes, $remainingSeconds);
    }
@endphp