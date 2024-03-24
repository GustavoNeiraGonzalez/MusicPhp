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
        $response = $this->get('/api/artists/get/6')
                        ->assertStatus(200);
    }
}
