<?php

namespace Tests\Feature;

use Database\Seeders\SongSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SongModuleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function TestGetSongInfo(): void
    {
        $this->seed(SongSeeder::class); //para rellenar la tabla artist

        $song = [
            "song_name"=>"FakeSong",//el seeder trae este nombre como prueba
            ];
        $response = $this->get('/api/auth/songs');//tener en cuenta el
            //id donde se creará el dato a probar
        $response
            ->assertStatus(200)
            ->assertJsonFragment($song); //jsonfragment verifica que el dato
            //no sea un array para buscarlo, (data:data) no ([data:[.. : ..]])
    }
}
