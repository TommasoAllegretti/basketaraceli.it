<?php
namespace App\Http\Controllers;

use App\Models\GameStat;
use Illuminate\Http\Request;

class GameStatController extends Controller
{
    public function index()
    {
        $gameStats = GameStat::all();
        return view('game_stats.index', compact('gameStats'));
    }

    public function create()
    {
        return view('game_stats.create');
    }

    public function store(Request $request)
    {

        GameStat::create($request->all());

        return redirect()->route('games.index');
    }

    public function show(GameStat $gameStat)
    {
        return view('game_stats.show', compact('gameStat'));
    }

    public function edit(GameStat $gameStat)
    {
        return view('game_stats.edit', compact('gameStat'));
    }

    public function update(Request $request, GameStat $gameStat)
    {
        
        GameStat::upfate($request->all());

        return redirect()->route('games.index');
    }

    public function destroy(GameStat $gameStat)
    {
        $gameStat->delete();

        return redirect()->route('game_stats.index')->with('success', 'GameStat deleted successfully.');
    }
}