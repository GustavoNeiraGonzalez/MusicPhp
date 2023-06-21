<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Song extends Model
{
    use HasFactory;
    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class,'songs_artists');
    }
    public function genres()
    {
        return $this->belongsToMany(Genres::class, 'songs_genres');
    }
}
