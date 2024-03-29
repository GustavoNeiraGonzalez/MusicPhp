<?php

namespace Tests\Feature;
use Database\Seeders\ArtistSeeder;
use Database\Seeders\TransactionStatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArtistModuleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function TestGetArtistInfo(): void
    {
        $this->seed(ArtistSeeder::class); //para rellenar la tabla artist

        $Artist = [
            "Artist"=>[

                "name"=>"Michael Jackson",//el seeder trae este nombre como prueba
            ]
            ];
        $response = $this->get('/api/artists/get/2');//tener en cuenta el
            //id donde se creará el dato a probar
        $response
            ->assertStatus(200)
            ->assertJson($Artist); //ASSERTJSON lo que hace es verificar que
            //coincida el objeto json tipo array (data=>[data : data]) 
    }

}
