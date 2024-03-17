<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'language',
        'title',
        'previous_title',
        'next_title',
        'language_title',
        'add_title',
        'edit_title',
        'username',
        'password',
        'register_title',
        'home_description',
        'cancel',
        'title',
        'rating',
        'price',
        'description',
        'tags',
        'tags_description',
        'delete',
        'search_title',
    ];
    use HasFactory;
}
