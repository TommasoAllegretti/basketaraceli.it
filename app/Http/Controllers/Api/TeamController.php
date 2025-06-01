<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Teams',
    description: 'API endpoints for managing teams'
)]
class TeamController extends Controller
{
    /**
     * List all teams
     */
    #[OA\Get(
        path: '/api/teams',
        summary: 'Get all teams',
        tags: ['Teams'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Response(
        response: 200,
        description: 'List of teams',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'integer'),
                    new OA\Property(property: 'abbreviation', type: 'string'),
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'league', type: 'object'),
                    new OA\Property(property: 'club', type: 'object'),
                    new OA\Property(property: 'players', type: 'array', items: new OA\Items(type: 'object')),
                ]
            )
        )
    )]
    public function index()
    {
        $user = auth()->user();
        
        if ($user->admin == 1) {
            // Admin users can see all teams
            return response()->json(
                Team::with(['league', 'club', 'players'])->get()
            );
        }
        
        // Non-admin users can only see teams they belong to through their player
        if (!$user->player_id) {
            return response()->json([
                'message' => 'No teams found. User is not associated with any player.'
            ]);
        }
        
        return response()->json(
            Team::with(['league', 'club', 'players'])
                ->whereHas('players', function($query) use ($user) {
                    $query->where('players.id', $user->player_id);
                })
                ->get()
        );
    }

    /**
     * Create a new team
     */
    #[OA\Post(
        path: '/api/teams',
        summary: 'Create a new team',
        tags: ['Teams'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['abbreviation'],
            properties: [
                new OA\Property(property: 'abbreviation', type: 'string', example: 'LAL'),
                new OA\Property(property: 'league_id', type: 'integer', example: 1),
                new OA\Property(property: 'club_id', type: 'integer', example: 1),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Team created successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Team created successfully'),
                new OA\Property(property: 'team', type: 'object')
            ]
        )
    )]
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can create teams.'
            ], 403);
        }

        $validated = $request->validate([
            'abbreviation' => 'required|string|max:10',
            'league_id' => 'nullable|exists:leagues,id',
            'club_id' => 'nullable|exists:clubs,id',
        ]);

        $team = Team::create($validated);

        return response()->json([
            'message' => 'Team created successfully',
            'team' => $team->load(['league', 'club'])
        ], 201);
    }

    /**
     * Get a specific team
     */
    #[OA\Get(
        path: '/api/teams/{id}',
        summary: 'Get team details',
        tags: ['Teams'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Team ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Team details',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'integer'),
                new OA\Property(property: 'abbreviation', type: 'string'),
                new OA\Property(property: 'name', type: 'string'),
                new OA\Property(property: 'league', type: 'object'),
                new OA\Property(property: 'club', type: 'object'),
                new OA\Property(property: 'players', type: 'array', items: new OA\Items(type: 'object')),
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Team not found'
    )]
    public function show(Team $team)
    {
        $user = auth()->user();
        
        if ($user->admin == 1) {
            return response()->json($team->load(['league', 'club', 'players']));
        }
        
        // Check if the user's player belongs to this team
        if (!$user->player_id) {
            return response()->json([
                'message' => 'Unauthorized. User is not associated with any player.'
            ], 403);
        }
        
        $hasAccess = $team->players()->where('players.id', $user->player_id)->exists();
        
        if (!$hasAccess) {
            return response()->json([
                'message' => 'Unauthorized. You can only view teams you belong to.'
            ], 403);
        }
        
        return response()->json($team->load(['league', 'club', 'players']));
    }

    /**
     * Update a team
     */
    #[OA\Put(
        path: '/api/teams/{id}',
        summary: 'Update team details',
        tags: ['Teams'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Team ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['abbreviation'],
            properties: [
                new OA\Property(property: 'abbreviation', type: 'string', example: 'LAL'),
                new OA\Property(property: 'league_id', type: 'integer', example: 1),
                new OA\Property(property: 'club_id', type: 'integer', example: 1),
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Team updated successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Team updated successfully'),
                new OA\Property(property: 'team', type: 'object')
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Team not found'
    )]
    public function update(Request $request, Team $team)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can update teams.'
            ], 403);
        }

        $validated = $request->validate([
            'abbreviation' => 'required|string|max:10',
            'league_id' => 'nullable|exists:leagues,id',
            'club_id' => 'nullable|exists:clubs,id',
        ]);

        $team->update($validated);

        return response()->json([
            'message' => 'Team updated successfully',
            'team' => $team->load(['league', 'club'])
        ]);
    }

    /**
     * Delete a team
     */
    #[OA\Delete(
        path: '/api/teams/{id}',
        summary: 'Delete a team',
        tags: ['Teams'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Team ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Team deleted successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Team deleted successfully')
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Team not found'
    )]
    public function destroy(Team $team)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can delete teams.'
            ], 403);
        }

        $team->delete();

        return response()->json([
            'message' => 'Team deleted successfully'
        ]);
    }
} 