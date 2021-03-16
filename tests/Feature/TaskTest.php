<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = User::factory();
        $response = $this->getJson('/');

        $response->assertStatus(200);
    }

    public function testStore()
    {
    }

    public function testShow()
    {
    }

    public function testUpdate()
    {
    }

    public function testDestroy()
    {
    }
}
