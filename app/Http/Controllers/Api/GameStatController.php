<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameStat;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Game Stats',
    description: 'API endpoints for managing team game stats'
)]
class GameStatController extends Controller
{
    /**
     * List all game stats
     */
    #[OA\Get(
        path: '/api/game-stats',
        summary: 'Get all game stats',
        tags: ['Game Stats'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Response(
        response: 200,
        description: 'List of game stats',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'integer'),
                    new OA\Property(property: 'team_id', type: 'integer'),
                    new OA\Property(property: 'game_id', type: 'integer'),
                    new OA\Property(property: 'points', type: 'integer'),
                    new OA\Property(property: 'field_goals_attempted', type: 'integer'),
                    new OA\Property(property: 'field_goals_made', type: 'integer'),
                    new OA\Property(property: 'field_goal_percentage', type: 'number'),
                    new OA\Property(property: 'team', type: 'object'),
                    new OA\Property(property: 'game', type: 'object'),
                ]
            )
        )
    )]
    public function index()
    {
        return response()->json(
            GameStat::with(['team', 'game'])->get()
        );
    }

    /**
     * Create a new game stat
     */
    #[OA\Post(
        path: '/api/game-stats',
        summary: 'Create a new game stat',
        tags: ['Game Stats'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['team_id', 'game_id'],
            properties: [
                new OA\Property(property: 'team_id', type: 'integer'),
                new OA\Property(property: 'game_id', type: 'integer'),
                new OA\Property(property: 'points', type: 'integer'),
                new OA\Property(property: 'field_goals_attempted', type: 'integer'),
                new OA\Property(property: 'field_goals_made', type: 'integer'),
                new OA\Property(property: 'three_point_field_goals_made', type: 'integer'),
                new OA\Property(property: 'three_point_field_goals_attempted', type: 'integer'),
                new OA\Property(property: 'two_point_field_goals_made', type: 'integer'),
                new OA\Property(property: 'two_point_field_goals_attempted', type: 'integer'),
                new OA\Property(property: 'free_throws_made', type: 'integer'),
                new OA\Property(property: 'free_throws_attempted', type: 'integer'),
                new OA\Property(property: 'offensive_rebounds', type: 'integer'),
                new OA\Property(property: 'defensive_rebounds', type: 'integer'),
                new OA\Property(property: 'total_rebounds', type: 'integer'),
                new OA\Property(property: 'assists', type: 'integer'),
                new OA\Property(property: 'turnovers', type: 'integer'),
                new OA\Property(property: 'steals', type: 'integer'),
                new OA\Property(property: 'blocks', type: 'integer'),
                new OA\Property(property: 'personal_fouls', type: 'integer'),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Game stat created successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'game_stat', type: 'object')
            ]
        )
    )]
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can create game stats.'
            ], 403);
        }

        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'game_id' => 'required|exists:games,id',
            'points' => 'nullable|integer|min:0',
            'field_goals_attempted' => 'nullable|integer|min:0',
            'field_goals_made' => 'nullable|integer|min:0',
            'three_point_field_goals_made' => 'nullable|integer|min:0',
            'three_point_field_goals_attempted' => 'nullable|integer|min:0',
            'two_point_field_goals_made' => 'nullable|integer|min:0',
            'two_point_field_goals_attempted' => 'nullable|integer|min:0',
            'free_throws_made' => 'nullable|integer|min:0',
            'free_throws_attempted' => 'nullable|integer|min:0',
            'offensive_rebounds' => 'nullable|integer|min:0',
            'defensive_rebounds' => 'nullable|integer|min:0',
            'total_rebounds' => 'nullable|integer|min:0',
            'assists' => 'nullable|integer|min:0',
            'turnovers' => 'nullable|integer|min:0',
            'steals' => 'nullable|integer|min:0',
            'blocks' => 'nullable|integer|min:0',
            'personal_fouls' => 'nullable|integer|min:0',
        ]);

        // Calculate percentages
        if (isset($validated['field_goals_attempted']) && $validated['field_goals_attempted'] > 0) {
            $validated['field_goal_percentage'] = ($validated['field_goals_made'] / $validated['field_goals_attempted']) * 100;
        }
        if (isset($validated['three_point_field_goals_attempted']) && $validated['three_point_field_goals_attempted'] > 0) {
            $validated['three_point_field_goal_percentage'] = ($validated['three_point_field_goals_made'] / $validated['three_point_field_goals_attempted']) * 100;
        }
        if (isset($validated['two_point_field_goals_attempted']) && $validated['two_point_field_goals_attempted'] > 0) {
            $validated['two_point_field_goal_percentage'] = ($validated['two_point_field_goals_made'] / $validated['two_point_field_goals_attempted']) * 100;
        }
        if (isset($validated['free_throws_attempted']) && $validated['free_throws_attempted'] > 0) {
            $validated['free_throw_percentage'] = ($validated['free_throws_made'] / $validated['free_throws_attempted']) * 100;
        }

        $gameStat = GameStat::create($validated);

        return response()->json([
            'message' => 'Game stat created successfully',
            'game_stat' => $gameStat->load(['team', 'game'])
        ], 201);
    }

    /**
     * Get a specific game stat
     */
    #[OA\Get(
        path: '/api/game-stats/{id}',
        summary: 'Get game stat details',
        tags: ['Game Stats'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Game Stat ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Game stat details'
    )]
    public function show(GameStat $gameStat)
    {
        return response()->json($gameStat->load(['team', 'game']));
    }

    /**
     * Update a game stat
     */
    #[OA\Put(
        path: '/api/game-stats/{id}',
        summary: 'Update game stat details',
        tags: ['Game Stats'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Game Stat ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['team_id', 'game_id'],
            properties: [
                new OA\Property(property: 'team_id', type: 'integer'),
                new OA\Property(property: 'game_id', type: 'integer'),
                new OA\Property(property: 'points', type: 'integer'),
                new OA\Property(property: 'field_goals_attempted', type: 'integer'),
                new OA\Property(property: 'field_goals_made', type: 'integer'),
                new OA\Property(property: 'three_point_field_goals_made', type: 'integer'),
                new OA\Property(property: 'three_point_field_goals_attempted', type: 'integer'),
                new OA\Property(property: 'two_point_field_goals_made', type: 'integer'),
                new OA\Property(property: 'two_point_field_goals_attempted', type: 'integer'),
                new OA\Property(property: 'free_throws_made', type: 'integer'),
                new OA\Property(property: 'free_throws_attempted', type: 'integer'),
                new OA\Property(property: 'offensive_rebounds', type: 'integer'),
                new OA\Property(property: 'defensive_rebounds', type: 'integer'),
                new OA\Property(property: 'total_rebounds', type: 'integer'),
                new OA\Property(property: 'assists', type: 'integer'),
                new OA\Property(property: 'turnovers', type: 'integer'),
                new OA\Property(property: 'steals', type: 'integer'),
                new OA\Property(property: 'blocks', type: 'integer'),
                new OA\Property(property: 'personal_fouls', type: 'integer'),
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Game stat updated successfully'
    )]
    public function update(Request $request, GameStat $gameStat)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can update game stats.'
            ], 403);
        }

        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'game_id' => 'required|exists:games,id',
            'points' => 'nullable|integer|min:0',
            'field_goals_attempted' => 'nullable|integer|min:0',
            'field_goals_made' => 'nullable|integer|min:0',
            'three_point_field_goals_made' => 'nullable|integer|min:0',
            'three_point_field_goals_attempted' => 'nullable|integer|min:0',
            'two_point_field_goals_made' => 'nullable|integer|min:0',
            'two_point_field_goals_attempted' => 'nullable|integer|min:0',
            'free_throws_made' => 'nullable|integer|min:0',
            'free_throws_attempted' => 'nullable|integer|min:0',
            'offensive_rebounds' => 'nullable|integer|min:0',
            'defensive_rebounds' => 'nullable|integer|min:0',
            'total_rebounds' => 'nullable|integer|min:0',
            'assists' => 'nullable|integer|min:0',
            'turnovers' => 'nullable|integer|min:0',
            'steals' => 'nullable|integer|min:0',
            'blocks' => 'nullable|integer|min:0',
            'personal_fouls' => 'nullable|integer|min:0',
        ]);

        // Calculate percentages
        if (isset($validated['field_goals_attempted']) && $validated['field_goals_attempted'] > 0) {
            $validated['field_goal_percentage'] = ($validated['field_goals_made'] / $validated['field_goals_attempted']) * 100;
        }
        if (isset($validated['three_point_field_goals_attempted']) && $validated['three_point_field_goals_attempted'] > 0) {
            $validated['three_point_field_goal_percentage'] = ($validated['three_point_field_goals_made'] / $validated['three_point_field_goals_attempted']) * 100;
        }
        if (isset($validated['two_point_field_goals_attempted']) && $validated['two_point_field_goals_attempted'] > 0) {
            $validated['two_point_field_goal_percentage'] = ($validated['two_point_field_goals_made'] / $validated['two_point_field_goals_attempted']) * 100;
        }
        if (isset($validated['free_throws_attempted']) && $validated['free_throws_attempted'] > 0) {
            $validated['free_throw_percentage'] = ($validated['free_throws_made'] / $validated['free_throws_attempted']) * 100;
        }

        $gameStat->update($validated);

        return response()->json([
            'message' => 'Game stat updated successfully',
            'game_stat' => $gameStat->load(['team', 'game'])
        ]);
    }

    /**
     * Delete a game stat
     */
    #[OA\Delete(
        path: '/api/game-stats/{id}',
        summary: 'Delete a game stat',
        tags: ['Game Stats'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Game Stat ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Game stat deleted successfully'
    )]
    public function destroy(GameStat $gameStat)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can delete game stats.'
            ], 403);
        }

        $gameStat->delete();

        return response()->json([
            'message' => 'Game stat deleted successfully'
        ]);
    }
} 