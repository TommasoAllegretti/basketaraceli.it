<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Players',
    description: 'API endpoints for managing players'
)]
class PlayerController extends Controller
{
    /**
     * List all players
     */
    #[OA\Get(
        path: '/api/players',
        summary: 'Get all players',
        tags: ['Players'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Response(
        response: 200,
        description: 'List of players',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'integer'),
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'position', type: 'string', nullable: true),
                    new OA\Property(property: 'height_cm', type: 'integer', nullable: true),
                    new OA\Property(property: 'birth_date', type: 'string', format: 'date', nullable: true),
                    new OA\Property(property: 'jersey_number', type: 'integer', nullable: true),
                    new OA\Property(property: 'points_per_game', type: 'number', format: 'float', nullable: true),
                    new OA\Property(property: 'rebounds_per_game', type: 'number', format: 'float', nullable: true),
                    new OA\Property(property: 'assists_per_game', type: 'number', format: 'float', nullable: true),
                    new OA\Property(property: 'teams', type: 'array', items: new OA\Items(type: 'object')),
                ]
            )
        )
    )]
    public function index()
    {
        $user = auth()->user();
        
        if ($user->admin == 1) {
            // Admin users can see all players
            return response()->json(Player::with('teams')->get());
        } else {
            // Non-admin users can only see their associated player
            if (!$user->player_id) {
                return response()->json([
                    'message' => 'No player associated with this user'
                ], 403);
            }
            
            return response()->json(
                Player::with('teams')->where('id', $user->player_id)->get()
            );
        }
    }

    /**
     * Create a new player
     */
    #[OA\Post(
        path: '/api/players',
        summary: 'Create a new player',
        tags: ['Players'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['name'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                new OA\Property(property: 'position', type: 'string', example: 'Playmaker', nullable: true),
                new OA\Property(property: 'height_cm', type: 'integer', example: 185, nullable: true),
                new OA\Property(property: 'birth_date', type: 'string', format: 'date', example: '1990-01-01', nullable: true),
                new OA\Property(property: 'jersey_number', type: 'integer', example: 23, nullable: true),
                new OA\Property(property: 'points_per_game', type: 'number', format: 'float', example: 15.5, nullable: true),
                new OA\Property(property: 'rebounds_per_game', type: 'number', format: 'float', example: 5.2, nullable: true),
                new OA\Property(property: 'assists_per_game', type: 'number', format: 'float', example: 4.8, nullable: true),
                new OA\Property(property: 'teams', type: 'array', items: new OA\Items(type: 'integer'), example: [1, 2], description: 'Array of team IDs')
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Player created successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Player created successfully'),
                new OA\Property(property: 'player', type: 'object')
            ]
        )
    )]
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can create players.'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:20',
            'height_cm' => 'nullable|integer',
            'birth_date' => 'nullable|date',
            'jersey_number' => 'nullable|integer',
            'points_per_game' => 'nullable|numeric',
            'rebounds_per_game' => 'nullable|numeric',
            'assists_per_game' => 'nullable|numeric',
            'teams' => 'nullable|array',
            'teams.*' => 'exists:teams,id',
        ]);

        $player = Player::create($validated);

        if (isset($validated['teams'])) {
            $player->teams()->attach($validated['teams']);
        }

        return response()->json([
            'message' => 'Player created successfully',
            'player' => $player->load('teams')
        ], 201);
    }

    /**
     * Get a specific player
     */
    #[OA\Get(
        path: '/api/players/{id}',
        summary: 'Get player details',
        tags: ['Players'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Player ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Player details',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'integer'),
                new OA\Property(property: 'name', type: 'string'),
                new OA\Property(property: 'position', type: 'string', nullable: true),
                new OA\Property(property: 'height_cm', type: 'integer', nullable: true),
                new OA\Property(property: 'birth_date', type: 'string', format: 'date', nullable: true),
                new OA\Property(property: 'jersey_number', type: 'integer', nullable: true),
                new OA\Property(property: 'points_per_game', type: 'number', format: 'float', nullable: true),
                new OA\Property(property: 'rebounds_per_game', type: 'number', format: 'float', nullable: true),
                new OA\Property(property: 'assists_per_game', type: 'number', format: 'float', nullable: true),
                new OA\Property(property: 'teams', type: 'array', items: new OA\Items(type: 'object')),
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Player not found'
    )]
    public function show(Player $player)
    {
        $user = auth()->user();
        
        if ($user->admin == 1 || $user->player_id == $player->id) {
            return response()->json($player->load('teams'));
        }
        
        return response()->json([
            'message' => 'Unauthorized. You can only view your own player information.'
        ], 403);
    }

    /**
     * Update a player
     */
    #[OA\Put(
        path: '/api/players/{id}',
        summary: 'Update player details',
        tags: ['Players'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Player ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['name'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                new OA\Property(property: 'position', type: 'string', example: 'Playmaker', nullable: true),
                new OA\Property(property: 'height_cm', type: 'integer', example: 185, nullable: true),
                new OA\Property(property: 'birth_date', type: 'string', format: 'date', example: '1990-01-01', nullable: true),
                new OA\Property(property: 'jersey_number', type: 'integer', example: 23, nullable: true),
                new OA\Property(property: 'points_per_game', type: 'number', format: 'float', example: 15.5, nullable: true),
                new OA\Property(property: 'rebounds_per_game', type: 'number', format: 'float', example: 5.2, nullable: true),
                new OA\Property(property: 'assists_per_game', type: 'number', format: 'float', example: 4.8, nullable: true),
                new OA\Property(property: 'teams', type: 'array', items: new OA\Items(type: 'integer'), example: [1, 2], description: 'Array of team IDs')
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Player updated successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Player updated successfully'),
                new OA\Property(property: 'player', type: 'object')
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Player not found'
    )]
    public function update(Request $request, Player $player)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can update players.'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:20',
            'height_cm' => 'nullable|integer',
            'birth_date' => 'nullable|date',
            'jersey_number' => 'nullable|integer',
            'points_per_game' => 'nullable|numeric',
            'rebounds_per_game' => 'nullable|numeric',
            'assists_per_game' => 'nullable|numeric',
            'teams' => 'nullable|array',
            'teams.*' => 'exists:teams,id',
        ]);

        $player->update($validated);

        if (isset($validated['teams'])) {
            $player->teams()->sync($validated['teams']);
        }

        return response()->json([
            'message' => 'Player updated successfully',
            'player' => $player->load('teams')
        ]);
    }

    /**
     * Delete a player
     */
    #[OA\Delete(
        path: '/api/players/{id}',
        summary: 'Delete a player',
        tags: ['Players'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Player ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Player deleted successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Player deleted successfully')
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Player not found'
    )]
    public function destroy(Player $player)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can delete players.'
            ], 403);
        }

        $player->delete();

        return response()->json([
            'message' => 'Player deleted successfully'
        ]);
    }
} 