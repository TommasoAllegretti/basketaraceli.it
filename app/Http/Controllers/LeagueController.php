<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leagues = League::latest()->where('deleted_at', NULL)->paginate(10);

        return view('league.index', compact('leagues'))

            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('league.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',

        ]);



        League::create($request->all());



        return redirect()->route('leagues.index')

            ->with('success', 'League created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(League $league)
    {
        return view('league.show', compact('league'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(League $league)
    {
        return view('league.edit', compact(var_name: 'league'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, League $league)
    {
        $request->validate([

            'name' => 'required',

        ]);

        $league->update($request->all());

        return redirect()->route('leagues.index')

            ->with('success', 'League updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(League $league)
    {
        $league->delete();

        return redirect()->route('leagues.index')

            ->with('success', 'League deleted successfully');
    }
}
