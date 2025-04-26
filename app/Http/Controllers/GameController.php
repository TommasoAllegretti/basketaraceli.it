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
            'stats.*.player_id' => 'required|integer',
            'stats.*.minutes_played' => 'integer',
            'stats.*.seconds_played' => 'integer',
            'stats.*.points' => 'integer',
            'stats.*.field_goals_made' => 'integer',
            'stats.*.field_goals_attempted' => 'integer',
            'stats.*.field_goal_percentage' => 'integer',
            'stats.*.two_point_field_goals_made' => 'integer',
            'stats.*.two_point_field_goals_attempted' => 'integer',
            'stats.*.two_point_field_goal_percentage' => 'integer',
            'stats.*.three_point_field_goals_made' => 'integer',
            'stats.*.three_point_field_goals_attempted' => 'integer',
            'stats.*.three_point_field_goal_percentage' => 'integer',
            'stats.*.free_throws_made' => 'integer',
            'stats.*.free_throws_attempted' => 'integer',
            'stats.*.free_throw_percentage' => 'integer',
            'stats.*.offensive_rebounds' => 'integer',
            'stats.*.defensive_rebounds' => 'integer',
            'stats.*.total_rebounds' => 'integer',
            'stats.*.assists' => 'integer',
            'stats.*.turnovers' => 'integer',
            'stats.*.steals' => 'integer',
            'stats.*.blocks' => 'integer',
            'stats.*.personal_fouls' => 'integer',
            'stats.*.performance_index_rating' => 'integer',
            'stats.*.efficiency' => 'integer',
            'stats.*.plus_minus' => 'integer',
        ]);



        $game = Game::create($request->all());

        foreach ($validated['stats'] as $stat) {

            $stat['seconds_played'] += $stat['minutes_played'] * 60;

            $game->stats()->create($stat);
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
        return view('game.edit', compact(var_name: 'game'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $request->validate([

            'name' => 'required',

        ]);

        $game->update($request->all());

        return redirect()->route('games.index')

            ->with('success', 'Game updated successfully');
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
