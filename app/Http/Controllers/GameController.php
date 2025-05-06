<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

use App\Models\Team;
use App\Models\Player;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::latest()->where('deleted_at', NULL)->paginate(10);

        return view('game.index', compact('games'))

            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::all()->where('deleted_at', NULL);
        $players = Player::all()->where('deleted_at', NULL);

        return view('game.create', compact('teams', 'players'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'home_team_id' => 'required|integer|exists:teams,id',
            'away_team_id' => 'required|integer|exists:teams,id',
            'home_team_total_score' => 'nullable|integer|min:0',
            'away_team_total_score' => 'nullable|integer|min:0',
            'home_team_quarters_score' => 'nullable|array',
            'home_team_quarters_score.*' => 'nullable|integer|min:0',
            'away_team_quarters_score' => 'nullable|array',
            'away_team_quarters_score.*' => 'nullable|integer|min:0',
            'stats.*.player_id' => 'required|integer|exists:players,id',
            'stats.*.minutes_played' => 'nullable|integer|min:0',
            'stats.*.seconds_played' => 'nullable|integer|min:0',
            'stats.*.points' => 'nullable|integer|min:0',
            'stats.*.field_goals_made' => 'nullable|integer|min:0',
            'stats.*.field_goals_attempted' => 'nullable|integer|min:0',
            'stats.*.field_goal_percentage' => 'nullable|numeric|min:0|max:100',
            'stats.*.two_point_field_goals_made' => 'nullable|integer|min:0',
            'stats.*.two_point_field_goals_attempted' => 'nullable|integer|min:0',
            'stats.*.two_point_field_goal_percentage' => 'nullable|numeric|min:0|max:100',
            'stats.*.three_point_field_goals_made' => 'nullable|integer|min:0',
            'stats.*.three_point_field_goals_attempted' => 'nullable|integer|min:0',
            'stats.*.three_point_field_goal_percentage' => 'nullable|numeric|min:0|max:100',
            'stats.*.free_throws_made' => 'nullable|integer|min:0',
            'stats.*.free_throws_attempted' => 'nullable|integer|min:0',
            'stats.*.free_throw_percentage' => 'nullable|numeric|min:0|max:100',
            'stats.*.offensive_rebounds' => 'nullable|integer|min:0',
            'stats.*.defensive_rebounds' => 'nullable|integer|min:0',
            'stats.*.total_rebounds' => 'nullable|integer|min:0',
            'stats.*.assists' => 'nullable|integer|min:0',
            'stats.*.turnovers' => 'nullable|integer|min:0',
            'stats.*.steals' => 'nullable|integer|min:0',
            'stats.*.blocks' => 'nullable|integer|min:0',
            'stats.*.personal_fouls' => 'nullable|integer|min:0',
            'stats.*.performance_index_rating' => 'nullable|integer',
            'stats.*.efficiency' => 'nullable|integer',
            'stats.*.plus_minus' => 'nullable|integer',
        ]);

        $validated['home_team_first_quarter_score'] = $validated['home_team_quarters_score'][0] ?? null;
        $validated['home_team_second_quarter_score'] = $validated['home_team_quarters_score'][1] ?? null;
        $validated['home_team_third_quarter_score'] = $validated['home_team_quarters_score'][2] ?? null;
        $validated['home_team_fourth_quarter_score'] = $validated['home_team_quarters_score'][3] ?? null;

        $validated['away_team_first_quarter_score'] = $validated['away_team_quarters_score'][0] ?? null;
        $validated['away_team_second_quarter_score'] = $validated['away_team_quarters_score'][1] ?? null;
        $validated['away_team_third_quarter_score'] = $validated['away_team_quarters_score'][2] ?? null;
        $validated['away_team_fourth_quarter_score'] = $validated['away_team_quarters_score'][3] ?? null;

        $game = Game::create([
            'date' => $validated['date'],
            'home_team_id' => $validated['home_team_id'],
            'away_team_id' => $validated['away_team_id'],
            'home_team_total_score' => $validated['home_team_total_score'],
            'away_team_total_score' => $validated['away_team_total_score'],
            'home_team_first_quarter_score' => $validated['home_team_first_quarter_score'],
            'home_team_second_quarter_score' => $validated['home_team_second_quarter_score'],
            'home_team_third_quarter_score' => $validated['home_team_third_quarter_score'],
            'home_team_fourth_quarter_score' => $validated['home_team_fourth_quarter_score'],
            'away_team_first_quarter_score' => $validated['away_team_first_quarter_score'],
            'away_team_second_quarter_score' => $validated['away_team_second_quarter_score'],
            'away_team_third_quarter_score' => $validated['away_team_third_quarter_score'],
            'away_team_fourth_quarter_score' => $validated['away_team_fourth_quarter_score'],
        ]);

        if (isset($validated['stats']) && is_array($validated['stats'])) {
            foreach ($validated['stats'] as $stat) {

                if ($stat['minutes_played'] != null) {
                    $stat['seconds_played'] += $stat['minutes_played'] * 60;
                }

                $game->stats()->create($stat);
            }
        }

        return redirect()->route('games.index')

            ->with('success', 'Game created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {

        $home_team_id = $game->home_team_id;
        $away_team_id = $game->away_team_id;

        $home_team_stats = $game->stats()
            ->whereHas('player.teams', function ($query) use ($home_team_id) {
                $query->where('teams.id', $home_team_id);
            })
            ->with('player.teams')
            ->get();


        $away_team_stats = $game->stats()
            ->whereHas('player.teams', function ($query) use ($away_team_id) {
                $query->where('teams.id', $away_team_id);
            })
            ->with('player.teams')
            ->get();

        return view('game.show', compact('game', 'home_team_stats', 'away_team_stats'))

            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {

        $teams = Team::all()->where('deleted_at', NULL);
        $players = Player::all()->where('deleted_at', NULL);

        return view('game.edit', compact('game', 'teams', 'players'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'home_team_id' => 'required|integer|exists:teams,id',
            'away_team_id' => 'required|integer|exists:teams,id',
            'home_team_total_score' => 'nullable|integer|min:0',
            'away_team_total_score' => 'nullable|integer|min:0',
            'home_team_quarters_score' => 'nullable|array',
            'home_team_quarters_score.*' => 'nullable|integer|min:0',
            'away_team_quarters_score' => 'nullable|array',
            'away_team_quarters_score.*' => 'nullable|integer|min:0',
            'stats.*.player_id' => 'required|integer|exists:players,id',
            'stats.*.minutes_played' => 'nullable|integer|min:0',
            'stats.*.seconds_played' => 'nullable|integer|min:0',
            'stats.*.points' => 'nullable|integer|min:0',
            'stats.*.field_goals_made' => 'nullable|integer|min:0',
            'stats.*.field_goals_attempted' => 'nullable|integer|min:0',
            'stats.*.field_goal_percentage' => 'nullable|numeric|min:0|max:100',
            'stats.*.two_point_field_goals_made' => 'nullable|integer|min:0',
            'stats.*.two_point_field_goals_attempted' => 'nullable|integer|min:0',
            'stats.*.two_point_field_goal_percentage' => 'nullable|numeric|min:0|max:100',
            'stats.*.three_point_field_goals_made' => 'nullable|integer|min:0',
            'stats.*.three_point_field_goals_attempted' => 'nullable|integer|min:0',
            'stats.*.three_point_field_goal_percentage' => 'nullable|numeric|min:0|max:100',
            'stats.*.free_throws_made' => 'nullable|integer|min:0',
            'stats.*.free_throws_attempted' => 'nullable|integer|min:0',
            'stats.*.free_throw_percentage' => 'nullable|numeric|min:0|max:100',
            'stats.*.offensive_rebounds' => 'nullable|integer|min:0',
            'stats.*.defensive_rebounds' => 'nullable|integer|min:0',
            'stats.*.total_rebounds' => 'nullable|integer|min:0',
            'stats.*.assists' => 'nullable|integer|min:0',
            'stats.*.turnovers' => 'nullable|integer|min:0',
            'stats.*.steals' => 'nullable|integer|min:0',
            'stats.*.blocks' => 'nullable|integer|min:0',
            'stats.*.personal_fouls' => 'nullable|integer|min:0',
            'stats.*.performance_index_rating' => 'nullable|integer',
            'stats.*.efficiency' => 'nullable|numeric',
            'stats.*.plus_minus' => 'nullable|integer',
        ]);

        // Transform quarter scores into individual fields
        $validated['home_team_first_quarter_score'] = $validated['home_team_quarters_score'][0] ?? null;
        $validated['home_team_second_quarter_score'] = $validated['home_team_quarters_score'][1] ?? null;
        $validated['home_team_third_quarter_score'] = $validated['home_team_quarters_score'][2] ?? null;
        $validated['home_team_fourth_quarter_score'] = $validated['home_team_quarters_score'][3] ?? null;

        $validated['away_team_first_quarter_score'] = $validated['away_team_quarters_score'][0] ?? null;
        $validated['away_team_second_quarter_score'] = $validated['away_team_quarters_score'][1] ?? null;
        $validated['away_team_third_quarter_score'] = $validated['away_team_quarters_score'][2] ?? null;
        $validated['away_team_fourth_quarter_score'] = $validated['away_team_quarters_score'][3] ?? null;

        // Update the game details
        $game->update([
            'date' => $validated['date'],
            'home_team_id' => $validated['home_team_id'],
            'away_team_id' => $validated['away_team_id'],
            'home_team_total_score' => $validated['home_team_total_score'],
            'away_team_total_score' => $validated['away_team_total_score'],
            'home_team_first_quarter_score' => $validated['home_team_first_quarter_score'],
            'home_team_second_quarter_score' => $validated['home_team_second_quarter_score'],
            'home_team_third_quarter_score' => $validated['home_team_third_quarter_score'],
            'home_team_fourth_quarter_score' => $validated['home_team_fourth_quarter_score'],
            'away_team_first_quarter_score' => $validated['away_team_first_quarter_score'],
            'away_team_second_quarter_score' => $validated['away_team_second_quarter_score'],
            'away_team_third_quarter_score' => $validated['away_team_third_quarter_score'],
            'away_team_fourth_quarter_score' => $validated['away_team_fourth_quarter_score'],
        ]);

        // Process stats
        if (isset($validated['stats']) && is_array($validated['stats'])) {
            foreach ($validated['stats'] as $stat) {
                // Check if the stat record exists
                $existingStat = $game->stats()->where('player_id', $stat['player_id'])->first();

                if ($existingStat) {
                    // Update the existing stat record
                    $existingStat->update($stat);
                } else {
                    // Create a new stat record
                    $game->stats()->create($stat);
                }
            }
        }

        return redirect()->route('games.index')
            ->with('success', 'Game updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('games.index')

            ->with('success', 'Game deleted successfully');
    }
}
