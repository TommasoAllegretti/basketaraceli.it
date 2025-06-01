<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\League;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Leagues',
    description: 'API endpoints for managing leagues'
)]
class LeagueController extends Controller
{
    /**
     * List all leagues
     */
    #[OA\Get(
        path: '/api/leagues',
        summary: 'Get all leagues',
        tags: ['Leagues'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Response(
        response: 200,
        description: 'List of leagues',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'integer'),
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'teams', type: 'array', items: new OA\Items(type: 'object')),
                ]
            )
        )
    )]
    public function index()
    {
        return response()->json(
            League::with('teams')->get()
        );
    }

    /**
     * Create a new league
     */
    #[OA\Post(
        path: '/api/leagues',
        summary: 'Create a new league',
        tags: ['Leagues'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['name'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'U15'),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'League created successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'League created successfully'),
                new OA\Property(property: 'league', type: 'object')
            ]
        )
    )]
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can create leagues.'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $league = League::create($validated);

        return response()->json([
            'message' => 'League created successfully',
            'league' => $league
        ], 201);
    }

    /**
     * Get a specific league
     */
    #[OA\Get(
        path: '/api/leagues/{id}',
        summary: 'Get league details',
        tags: ['Leagues'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'League ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'League details',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'integer'),
                new OA\Property(property: 'name', type: 'string'),
                new OA\Property(property: 'teams', type: 'array', items: new OA\Items(type: 'object')),
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'League not found'
    )]
    public function show(League $league)
    {
        return response()->json($league->load('teams'));
    }

    /**
     * Update a league
     */
    #[OA\Put(
        path: '/api/leagues/{id}',
        summary: 'Update league details',
        tags: ['Leagues'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'League ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['name'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'U17'),
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'League updated successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'League updated successfully'),
                new OA\Property(property: 'league', type: 'object')
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'League not found'
    )]
    public function update(Request $request, League $league)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can update leagues.'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $league->update($validated);

        return response()->json([
            'message' => 'League updated successfully',
            'league' => $league
        ]);
    }

    /**
     * Delete a league
     */
    #[OA\Delete(
        path: '/api/leagues/{id}',
        summary: 'Delete a league',
        tags: ['Leagues'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'League ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'League deleted successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'League deleted successfully')
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'League not found'
    )]
    public function destroy(League $league)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can delete leagues.'
            ], 403);
        }

        $league->delete();

        return response()->json([
            'message' => 'League deleted successfully'
        ]);
    }
} 