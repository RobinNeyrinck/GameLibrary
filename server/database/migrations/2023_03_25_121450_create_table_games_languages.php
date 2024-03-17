<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games_languages', function (Blueprint $table) {
            $table->increments('language_id');
            $table->unsignedInteger('game_id');
            $table->string('language');
            $table->longText('description');
            $table->json('tags');
            $table->timestamps();
            $table->foreign('game_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games_languages');
    }
};
