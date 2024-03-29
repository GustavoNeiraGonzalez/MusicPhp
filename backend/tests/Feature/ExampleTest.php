<?php

namespace Tests\Feature;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TransactionStatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed(DatabaseSeeder::class);
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
}
