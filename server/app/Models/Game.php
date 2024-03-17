<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'title',
        'rating',
        'price'
    ];
    use HasFactory;

    public function languages()
    {
        return $this->hasMany(GameLanguage::class);
    }
}
