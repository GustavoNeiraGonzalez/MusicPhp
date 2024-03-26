<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\Artist::factory(1)->create();
        \App\Models\Artist::factory()->create([
            'name' => 'Test User',
            'desription' => 'test example ;D',
            ]);
    }
    
}
