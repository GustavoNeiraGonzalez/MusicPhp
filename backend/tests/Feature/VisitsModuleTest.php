<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\SongSeeder;

class VisitsModuleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function TestAddVisitsUserSong(): void
    {
        $this->seed(SongSeeder::class); //para rellenar la tabla artist

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/auth/add/visits/1');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function TestShowVisitsSong(): void
    {

    }
}
