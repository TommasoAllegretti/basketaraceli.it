<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Games',
    description: 'API endpoints for managing games'
)]
class GameController extends Controller
{
    /**
     * List all games
     */
    #[OA\Get(
        path: '/api/games',
        summary: 'Get all games',
        tags: ['Games'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Response(
        response: 200,
        description: 'List of games',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'integer'),
                    new OA\Property(property: 'date', type: 'string', format: 'date'),
                    new OA\Property(property: 'home_team', type: 'object'),
                    new OA\Property(property: 'away_team', type: 'object'),
                    new OA\Property(property: 'home_team_total_score', type: 'integer'),
                    new OA\Property(property: 'away_team_total_score', type: 'integer'),
                    new OA\Property(property: 'stats', type: 'array', items: new OA\Items(type: 'object')),
                ]
            )
        )
    )]
    public function index()
    {
        return response()->json(
            Game::with(['home_team', 'away_team', 'stats'])->get()
        );
    }

    /**
     * Create a new game
     */
    #[OA\Post(
        path: '/api/games',
        summary: 'Create a new game',
        tags: ['Games'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['date', 'home_team_id', 'away_team_id'],
            properties: [
                new OA\Property(property: 'date', type: 'string', format: 'date'),
                new OA\Property(property: 'home_team_id', type: 'integer'),
                new OA\Property(property: 'away_team_id', type: 'integer'),
                new OA\Property(property: 'home_team_total_score', type: 'integer'),
                new OA\Property(property: 'away_team_total_score', type: 'integer'),
                new OA\Property(property: 'home_team_first_quarter_score', type: 'integer'),
                new OA\Property(property: 'away_team_first_quarter_score', type: 'integer'),
                new OA\Property(property: 'home_team_second_quarter_score', type: 'integer'),
                new OA\Property(property: 'away_team_second_quarter_score', type: 'integer'),
                new OA\Property(property: 'home_team_third_quarter_score', type: 'integer'),
                new OA\Property(property: 'away_team_third_quarter_score', type: 'integer'),
                new OA\Property(property: 'home_team_fourth_quarter_score', type: 'integer'),
                new OA\Property(property: 'away_team_fourth_quarter_score', type: 'integer'),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Game created successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'game', type: 'object')
            ]
        )
    )]
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can create games.'
            ], 403);
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'home_team_total_score' => 'nullable|integer|min:0',
            'away_team_total_score' => 'nullable|integer|min:0',
            'home_team_first_quarter_score' => 'nullable|integer|min:0',
            'away_team_first_quarter_score' => 'nullable|integer|min:0',
            'home_team_second_quarter_score' => 'nullable|integer|min:0',
            'away_team_second_quarter_score' => 'nullable|integer|min:0',
            'home_team_third_quarter_score' => 'nullable|integer|min:0',
            'away_team_third_quarter_score' => 'nullable|integer|min:0',
            'home_team_fourth_quarter_score' => 'nullable|integer|min:0',
            'away_team_fourth_quarter_score' => 'nullable|integer|min:0',
        ]);

        $game = Game::create($validated);

        return response()->json([
            'message' => 'Game created successfully',
            'game' => $game->load(['home_team', 'away_team'])
        ], 201);
    }

    /**
     * Get a specific game
     */
    #[OA\Get(
        path: '/api/games/{id}',
        summary: 'Get game details',
        tags: ['Games'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Game ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Game details',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'integer'),
                new OA\Property(property: 'date', type: 'string', format: 'date'),
                new OA\Property(property: 'home_team', type: 'object'),
                new OA\Property(property: 'away_team', type: 'object'),
                new OA\Property(property: 'home_team_total_score', type: 'integer'),
                new OA\Property(property: 'away_team_total_score', type: 'integer'),
                new OA\Property(property: 'stats', type: 'array', items: new OA\Items(type: 'object')),
            ]
        )
    )]
    public function show(Game $game)
    {
        return response()->json(
            $game->load(['home_team', 'away_team', 'stats'])
        );
    }

    /**
     * Update a game
     */
    #[OA\Put(
        path: '/api/games/{id}',
        summary: 'Update game details',
        tags: ['Games'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Game ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['date', 'home_team_id', 'away_team_id'],
            properties: [
                new OA\Property(property: 'date', type: 'string', format: 'date'),
                new OA\Property(property: 'home_team_id', type: 'integer'),
                new OA\Property(property: 'away_team_id', type: 'integer'),
                new OA\Property(property: 'home_team_total_score', type: 'integer'),
                new OA\Property(property: 'away_team_total_score', type: 'integer'),
                new OA\Property(property: 'home_team_first_quarter_score', type: 'integer'),
                new OA\Property(property: 'away_team_first_quarter_score', type: 'integer'),
                new OA\Property(property: 'home_team_second_quarter_score', type: 'integer'),
                new OA\Property(property: 'away_team_second_quarter_score', type: 'integer'),
                new OA\Property(property: 'home_team_third_quarter_score', type: 'integer'),
                new OA\Property(property: 'away_team_third_quarter_score', type: 'integer'),
                new OA\Property(property: 'home_team_fourth_quarter_score', type: 'integer'),
                new OA\Property(property: 'away_team_fourth_quarter_score', type: 'integer'),
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Game updated successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'game', type: 'object')
            ]
        )
    )]
    public function update(Request $request, Game $game)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can update games.'
            ], 403);
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'home_team_total_score' => 'nullable|integer|min:0',
            'away_team_total_score' => 'nullable|integer|min:0',
            'home_team_first_quarter_score' => 'nullable|integer|min:0',
            'away_team_first_quarter_score' => 'nullable|integer|min:0',
            'home_team_second_quarter_score' => 'nullable|integer|min:0',
            'away_team_second_quarter_score' => 'nullable|integer|min:0',
            'home_team_third_quarter_score' => 'nullable|integer|min:0',
            'away_team_third_quarter_score' => 'nullable|integer|min:0',
            'home_team_fourth_quarter_score' => 'nullable|integer|min:0',
            'away_team_fourth_quarter_score' => 'nullable|integer|min:0',
        ]);

        $game->update($validated);

        return response()->json([
            'message' => 'Game updated successfully',
            'game' => $game->load(['home_team', 'away_team'])
        ]);
    }

    /**
     * Delete a game
     */
    #[OA\Delete(
        path: '/api/games/{id}',
        summary: 'Delete a game',
        tags: ['Games'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Game ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Game deleted successfully'
    )]
    public function destroy(Game $game)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can delete games.'
            ], 403);
        }

        $game->delete();

        return response()->json([
            'message' => 'Game deleted successfully'
        ]);
    }
} 