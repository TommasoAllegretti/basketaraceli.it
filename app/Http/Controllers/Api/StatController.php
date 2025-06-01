<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Stats',
    description: 'API endpoints for managing player stats'
)]
class StatController extends Controller
{
    /**
     * List all stats
     */
    #[OA\Get(
        path: '/api/stats',
        summary: 'Get all stats',
        tags: ['Stats'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Response(
        response: 200,
        description: 'List of stats',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'integer'),
                    new OA\Property(property: 'player_id', type: 'integer'),
                    new OA\Property(property: 'game_id', type: 'integer'),
                    new OA\Property(property: 'points', type: 'integer'),
                    new OA\Property(property: 'rebounds', type: 'integer'),
                    new OA\Property(property: 'assists', type: 'integer'),
                    new OA\Property(property: 'player', type: 'object'),
                    new OA\Property(property: 'game', type: 'object'),
                ]
            )
        )
    )]
    public function index()
    {
        return response()->json(
            Stat::with(['player', 'game'])->get()
        );
    }

    /**
     * Create a new stat
     */
    #[OA\Post(
        path: '/api/stats',
        summary: 'Create a new stat',
        tags: ['Stats'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['player_id', 'game_id'],
            properties: [
                new OA\Property(property: 'player_id', type: 'integer'),
                new OA\Property(property: 'game_id', type: 'integer'),
                new OA\Property(property: 'seconds_played', type: 'integer'),
                new OA\Property(property: 'points', type: 'integer'),
                new OA\Property(property: 'field_goals_made', type: 'integer'),
                new OA\Property(property: 'field_goals_attempted', type: 'integer'),
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
        description: 'Stat created successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'stat', type: 'object')
            ]
        )
    )]
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can create stats.'
            ], 403);
        }

        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'game_id' => 'required|exists:games,id',
            'seconds_played' => 'nullable|integer|min:0',
            'points' => 'nullable|integer|min:0',
            'field_goals_made' => 'nullable|integer|min:0',
            'field_goals_attempted' => 'nullable|integer|min:0',
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

        $stat = Stat::create($validated);

        return response()->json([
            'message' => 'Stat created successfully',
            'stat' => $stat->load(['player', 'game'])
        ], 201);
    }

    /**
     * Get a specific stat
     */
    #[OA\Get(
        path: '/api/stats/{id}',
        summary: 'Get stat details',
        tags: ['Stats'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Stat ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Stat details'
    )]
    public function show(Stat $stat)
    {
        return response()->json($stat->load(['player', 'game']));
    }

    /**
     * Update a stat
     */
    #[OA\Put(
        path: '/api/stats/{id}',
        summary: 'Update stat details',
        tags: ['Stats'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Stat ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['player_id', 'game_id'],
            properties: [
                new OA\Property(property: 'player_id', type: 'integer'),
                new OA\Property(property: 'game_id', type: 'integer'),
                new OA\Property(property: 'seconds_played', type: 'integer'),
                new OA\Property(property: 'points', type: 'integer'),
                new OA\Property(property: 'field_goals_made', type: 'integer'),
                new OA\Property(property: 'field_goals_attempted', type: 'integer'),
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
        description: 'Stat updated successfully'
    )]
    public function update(Request $request, Stat $stat)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can update stats.'
            ], 403);
        }

        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'game_id' => 'required|exists:games,id',
            'seconds_played' => 'nullable|integer|min:0',
            'points' => 'nullable|integer|min:0',
            'field_goals_made' => 'nullable|integer|min:0',
            'field_goals_attempted' => 'nullable|integer|min:0',
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

        $stat->update($validated);

        return response()->json([
            'message' => 'Stat updated successfully',
            'stat' => $stat->load(['player', 'game'])
        ]);
    }

    /**
     * Delete a stat
     */
    #[OA\Delete(
        path: '/api/stats/{id}',
        summary: 'Delete a stat',
        tags: ['Stats'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Stat ID',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Stat deleted successfully'
    )]
    public function destroy(Stat $stat)
    {
        $user = auth()->user();
        
        if ($user->admin != 1) {
            return response()->json([
                'message' => 'Unauthorized. Only administrators can delete stats.'
            ], 403);
        }

        $stat->delete();

        return response()->json([
            'message' => 'Stat deleted successfully'
        ]);
    }
} 