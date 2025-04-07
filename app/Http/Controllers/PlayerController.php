<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = Player::latest()->where('deleted_at', NULL)->paginate(10);

        return view('player.index', compact('players'))

            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('player.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',

        ]);



        Player::create($request->all());



        return redirect()->route('player.index')

            ->with('success', 'Player created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        return view('player.show', compact('player'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        return view('player.edit', compact(var_name: 'player'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        $request->validate([

            'name' => 'required',

            'detail' => 'required',

        ]);

        $player->update($request->all());

        return redirect()->route('player.index')

            ->with('success', 'Player updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $player->delete();

        return redirect()->route('player.index')

            ->with('success', 'Player deleted successfully');
    }
}
