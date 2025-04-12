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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('away_team_id')->constrained('teams')->onDelete('cascade');
            $table->date('date');
            $table->integer('home_team_total_score')->nullable();
            $table->integer('away_team_total_score')->nullable();
            $table->integer('home_team_first_quarter_score')->nullable();
            $table->integer('away_team_first_quarter_score')->nullable();
            $table->integer('home_team_second_quarter_score')->nullable();
            $table->integer('away_team_second_quarter_score')->nullable();
            $table->integer('home_team_third_quarter_score')->nullable();
            $table->integer('away_team_third_quarter_score')->nullable();
            $table->integer('home_team_fourth_quarter_score')->nullable();
            $table->integer('away_team_fourth_quarter_score')->nullable();
            $table->foreignId('top_scorer_id')->nullable()->constrained('players')->onDelete('cascade');
            $table->foreignId('top_rebounder_id')->nullable()->constrained('players')->onDelete('cascade');
            $table->foreignId('top_assister_id')->nullable()->constrained('players')->onDelete('cascade');
            $table->foreignId('top_efficiency_id')->nullable()->constrained('players')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
