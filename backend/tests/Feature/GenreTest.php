<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function TestGenrePost(): void
    {

        $user = User::factory()->create();
        $genre = 'Rock';
        $response = $this->actingAs($user)->post('/api/genre/post',[
            "genre"=>$genre
        ]);

        $response->assertStatus(200);
    }
        
    
    
}
