<?php

namespace Tests\Feature;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TransactionStatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */

    public function TestLoginUserWithMethod(): void
    {   
        $this->seed(DatabaseSeeder::class);
        $userEmail = 'user@user.com';
        $userPassword ='password'; //si los junto como array, realmente 
        //funciona el test 

        $response = $this->post('/api/auth/users/login',[
            "email"=>$userEmail, "password"=>$userPassword
        ]);

        $response->assertStatus(200);
    }
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
