<?php

namespace Database\Seeders;

use App\Models\Song;
use App\Models\User;
use App\Models\Visits;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $visits = Visits::factory(1)
        ->create();
    }
}
