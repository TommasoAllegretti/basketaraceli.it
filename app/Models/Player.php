<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'name',
        'position',
        'height_cm',
        'birth_date',
        'team',
        'jersey_number',
        'points_per_game',
        'rebounds_per_game',
        'assists_per_game',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
