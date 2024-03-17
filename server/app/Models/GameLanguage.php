<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLanguage extends Model
{
    protected $table = 'games_languages';
    protected $cast = [
        'tags' => 'array'
    ];
    protected $fillable = [
        'game_id',
        'language',
        'tags',
        'description',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
