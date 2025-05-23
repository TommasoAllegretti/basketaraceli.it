<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameStat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'game_id',
        'seconds_played',
        'points',
        'field_goals_attempted',
        'field_goals_made',
        'field_goal_percentage',
        'three_point_field_goals_made',
        'three_point_field_goals_attempted',
        'three_point_field_goal_percentage',
        'two_point_field_goals_made',
        'two_point_field_goals_attempted',
        'two_point_field_goal_percentage',
        'free_throws_made',
        'free_throws_attempted',
        'free_throw_percentage',
        'offensive_rebounds',
        'defensive_rebounds',
        'total_rebounds',
        'assists',
        'turnovers',
        'steals',
        'blocks',
        'personal_fouls',
        'performance_index_rating',
        'efficiency',
        'plus_minus',
    ];

    function game()
    {
        return $this->belongsTo(Game::class);
    }
}