<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visits extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(User::class, 'visit_user');
    }
    public function songs()
    {
        return $this->belongsToMany(Song::class, 'visit_song');
    }
}
