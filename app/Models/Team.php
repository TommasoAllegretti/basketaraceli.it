<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'abbreviation',
        'league_id',
        'club_id'
    ];

    protected $appends = ['name'];

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Get the team's name (combination of club and league names)
     */
    public function name(): string
    {
        $clubName = $this->club ? $this->club->name : 'Unaffiliated';
        $leagueName = $this->league ? $this->league->name : 'No League';
        
        return "{$clubName} ({$leagueName})";
    }

    /**
     * Get the team's name as an attribute
     */
    public function getNameAttribute(): string
    {
        return $this->name();
    }
}
