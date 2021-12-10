<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DiscoveryControllerTest extends TestCase
{
    const URI = '/api/discovery';

    /**
     * @test
     */
    public function it_requires_authentication()
    {
        $this->json('GET', self::URI)->assertStatus(401);
    }

    /**
     * @test
     */
    public function it_returns_the_list_of_channels()
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)->json('GET', self::URI);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [],
        ]);
    }
}
