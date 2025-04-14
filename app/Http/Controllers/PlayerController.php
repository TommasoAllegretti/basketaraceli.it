<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = Player::with('team')->latest()->where('deleted_at', NULL)->paginate(10);

        return view('players.index', compact('players'))

            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::all()->where('deleted_at', NULL);

        return view('players.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'team_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'height_cm' => 'nullable|integer',
            'birth_date' => 'nullable|date',
            'jersey_number' => 'nullable|integer',
            'points_per_game' => 'nullable|numeric',
            'rebounds_per_game' => 'nullable|numeric',
            'assists_per_game' => 'nullable|numeric',
        ]);



        Player::create($request->all());



        return redirect()->route('players.index')

            ->with('success', 'Player created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player = null)
    {
        if (!(Auth::user()->admin == 1 || !!Auth::user()->player)) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to view this player.');
        }

        if (empty($player)) {
            $player = Player::where('id', Auth::user()->player_id)->first();
        }

        return view('players.show', compact('player'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        $teams = Team::all()->where('deleted_at', NULL);

        return view('players.edit', compact('player', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        $request->validate([

            'name' => 'required',

        ]);

        $player->update($request->all());

        return redirect()->route('players.index')

            ->with('success', 'Player updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $player->delete();

        return redirect()->route('players.index')

            ->with('success', 'Player deleted successfully');
    }
}
