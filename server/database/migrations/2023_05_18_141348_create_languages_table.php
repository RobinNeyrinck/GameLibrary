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
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('language');
            $table->string('library_title');
            $table->string('previous_title');
            $table->string('next_title');
            $table->string('language_title');
            $table->string('add_title');
            $table->string('edit_title');
            $table->string('username');
            $table->string('password');
            $table->string('register_title');
            $table->string('home_description');
            $table->string('cancel');
            $table->string('title');
            $table->string('rating');
            $table->string('price');
            $table->string('description');
            $table->string('tags');
            $table->string('tags_description');
            $table->string('delete');
            $table->string('search_title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
