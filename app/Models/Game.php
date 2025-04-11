<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'date',
        'home_team_total_score',
        'away_team_total_score',
        'home_team_first_quarter_score',
        'away_team_first_quarter_score',
        'home_team_second_quarter_score',
        'away_team_second_quarter_score',
        'home_team_third_quarter_score',
        'away_team_third_quarter_score',
        'home_team_fourth_quarter_score',
        'away_team_fourth_quarter_score',
        'top_scorer_id',
        'top_rebounder_id',
        'top_assister_id',
        'top_efficiency_id',
    ];

    public function home_team()
    {
        return $this->belongsTo(Team::class);
    }

    public function away_team()
    {
        return $this->belongsTo(Team::class);
    }
}
