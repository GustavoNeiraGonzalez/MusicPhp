<?php

namespace Tests\Feature;

use App\Models\Visits;
use Database\Seeders\VisitSeeder;
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
        $visits = [ 
            "visits"=>[ 
                "visits"=> 40,
            ]
        ];
        
        $this->seed(VisitSeeder::class); //para rellenar la tabla artist

        $response2 = $this->get('/api/get/visits/');//tener en cuenta el
        $response2
            ->assertStatus(200)
            ->assertJson($visits); //jsonfragment verifica que el dato
            //no sea un array para buscarlo, (data:data) no ([data:[.. : ..]])

    }


}
