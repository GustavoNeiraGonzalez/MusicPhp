<?php

namespace Tests\Feature;
use Database\Seeders\ArtistSeeder;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
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
        $response = $this->get('/api/songs');//tener en cuenta el
            //id donde se creará el dato a probar
        $response
            ->assertStatus(200)
            ->assertJsonFragment($song); //jsonfragment verifica que el dato
            //no sea un array para buscarlo, (data:data) no ([data:[.. : ..]])
    }
    /**
     * @test
     */
    public function TestAttachSongUser(): void
    {   
        $this->seed(ArtistSeeder::class);
        $this->seed(DatabaseSeeder::class);
        $this->seed(SongSeeder::class); //para rellenar la tabla artist
        $user = User::factory()->create();
        
        
        $song_id =3;
        $user_id =3;
          

        $response = $this->actingAs($user)->post('/api/atach/users/songs',[
            "song_id"=>$song_id, "user_id"=>$user_id
        ]);

        $response->assertStatus(200);
    }
}