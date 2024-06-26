<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Artist extends Model
{
    use HasFactory;
    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(Song::class,'songs_artists');
    }
    public function genres()
    {
        return $this->belongsToMany(Genres::class, 'artists_genres');
    }
}

