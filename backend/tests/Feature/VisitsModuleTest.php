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
        $visits = [ "visits"=> 40,];
        
        $this->seed(VisitSeeder::class); //para rellenar la tabla artist

        $response2 = $this->get('/api/get/visits');//tener en cuenta el
        $response2
            ->assertStatus(200)
                ->assertJsonFragment($visits); //jsonfragment verifica que el dato
            //no sea un array para buscarlo, (data:data) no ([data:[.. : ..]])

    }
        /**
     * @test
     */
    public function TestShowVisitsSpecificSong(): void
    {
        $visits = [ "visits"=> "40",];//no se porque en este caso
        //de buscar una cancion en especifico este valor numerico
        //tiene que ser string
        
        $this->seed(VisitSeeder::class); //para rellenar la tabla artist
        $songId = 3; //valor de 3 porque se ha creado canciones 3 veces en este test
        //quizas no es necesario sumar 1 cada que se crea un test secuente 
        //si se usa refreshdatabase dentro del test??
        $response2 = $this->get('/api/get/visits/' . $songId);//tener en cuenta el
        $response2
            ->assertStatus(200)
                ->assertJsonFragment($visits); //jsonfragment verifica que el dato
            //no sea un array para buscarlo, (data:data) no ([data:[.. : ..]])

    }

}
