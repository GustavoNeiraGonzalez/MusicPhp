<?php

namespace Database\Seeders;
use App\Models\Artist;
use App\Models\Song;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $song = Song::factory()
            ->has(Artist::factory()->count(1))
            ->create();
    }
}
