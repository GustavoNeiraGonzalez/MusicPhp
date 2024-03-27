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
        $user = Song::factory()
            ->has(Artist::factory()->count(1))
            ->create();
    }
}
