<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'abbreviation',
        'league_id',
        'club_id'
    ];


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
}
