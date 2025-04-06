<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
}
