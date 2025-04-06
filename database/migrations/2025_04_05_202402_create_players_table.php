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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position', 20)->nullable();
            $table->integer('height_cm')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('team', 100)->nullable();
            $table->integer('jersey_number')->nullable();
            $table->decimal('points_per_game', 4, 1)->nullable();
            $table->decimal('rebounds_per_game', 4, 1)->nullable();
            $table->decimal('assists_per_game', 4, 1)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
