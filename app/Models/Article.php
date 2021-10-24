<?php

namespace App\Models;

use App\Observers\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory, Searchable;

    protected $casts = [
        'tags' => 'json',
    ];
}
