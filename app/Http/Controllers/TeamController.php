<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::latest()->where('deleted_at', NULL)->paginate(10);

        return view('team.index', compact('teams'))

            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leagues = League::all()->where('deleted_at', NULL);

        return view('team.create', compact('leagues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',

        ]);



        Team::create($request->all());



        return redirect()->route('teams.index')

            ->with('success', 'Team created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {

        $players = $team->players()->where('deleted_at', NULL)->get();

        return view('team.show', compact('team', 'players'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        $leagues = League::all()->where('deleted_at', NULL);

        return view('team.edit', compact('team', 'leagues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $request->validate([

            'name' => 'required',

        ]);

        $team->update($request->all());

        return redirect()->route('teams.index')

            ->with('success', 'Team updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index')

            ->with('success', 'Team deleted successfully');
    }
}
