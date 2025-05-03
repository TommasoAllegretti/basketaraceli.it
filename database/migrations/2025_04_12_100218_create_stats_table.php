<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->integer('seconds_played')->nullable();
            $table->integer('points')->nullable();
            $table->integer('field_goals_attempted')->nullable();
            $table->integer('field_goals_made')->nullable();
            $table->decimal('field_goal_percentage')->nullable();
            $table->integer('three_point_field_goals_made')->nullable();
            $table->integer('three_point_field_goals_attempted')->nullable();
            $table->decimal('three_point_field_goal_percentage')->nullable();
            $table->integer('two_point_field_goals_made')->nullable();
            $table->integer('two_point_field_goals_attempted')->nullable();
            $table->decimal('two_point_field_goal_percentage')->nullable();
            $table->integer('free_throws_made')->nullable();
            $table->integer('free_throws_attempted')->nullable();
            $table->decimal('free_throw_percentage')->nullable();
            $table->integer('offensive_rebounds')->nullable();
            $table->integer('defensive_rebounds')->nullable();
            $table->integer('total_rebounds')->nullable();
            $table->integer('assists')->nullable();
            $table->integer('turnovers')->nullable();
            $table->integer('steals')->nullable();
            $table->integer('blocks')->nullable();
            $table->integer('personal_fouls')->nullable();
            $table->integer('performance_index_rating')->nullable();
            $table->integer('efficiency')->nullable();
            $table->integer('plus_minus')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
