<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArtistModuleTest extends TestCase
{

    /**
     * @test
     */
    public function TestGetArtistInfo(): void
    {
        $Artist = [
            "Artist"=>[

                "name"=>"Fae Littel II",
            ]
            ];
        $response = $this->get('/api/artists/get/2');
 
        $response
            ->assertStatus(200)
            ->assertJson($Artist);
    }

}
