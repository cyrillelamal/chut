<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    const FIND = '/api/users';

    /**
     * @test
     */
    public function users_must_be_authenticated_to_search_for_other_users()
    {
        $this->getJson(self::FIND)->assertStatus(401);

        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $this->actingAs($user)->json('GET', self::FIND, ['q' => 'foo'])->assertStatus(200);
    }

    /**
     * @test
     */
    public function it_requires_a_search_query(): void
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $this->actingAs($user)->getJson(self::FIND)->assertStatus(422);

        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $this->actingAs($user)->json('GET', self::FIND, [
            'q' => 'foo',
        ])->assertStatus(200);
    }

    /**
     * @test
     */
    public function it_searches_for_other_users_by_email()
    {
        [$john, $kathy] = User::all()->random(2);

        $response = $this->actingAs($john)->json('GET', self::FIND, [
            'q' => $kathy->email,
        ]);

        $response->assertJson([
            'data' => [
                0 => [
                    'email' => $kathy->email,
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_searches_for_other_users_by_partial_email()
    {
        [$john, $kathy] = User::all()->random(2);

        $response = $this->actingAs($john)->json('GET', self::FIND, [
            'q' => Str::substr($kathy->email, 1),
        ]);

        $response->assertJson([
            'data' => [
                0 => [
                    'email' => $kathy->email,
                ],
            ],
        ]);

        $response = $this->actingAs($john)->json('GET', self::FIND, [
            'q' => Str::substr($kathy->email, 0, -1),
        ]);

        $response->assertJson([
            'data' => [
                0 => [
                    'email' => $kathy->email,
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_searches_for_other_users_by_partial_name()
    {
        [$john, $kathy] = User::all()->random(2);

        $response = $this->actingAs($john)->json('GET', self::FIND, [
            'q' => Str::substr($kathy->name, 1),
        ]);

        $response->assertJson([
            'data' => [
                0 => [
                    'name' => $kathy->name,
                ],
            ],
        ]);

        $response = $this->actingAs($john)->json('GET', self::FIND, [
            'q' => Str::substr($kathy->name, 0, -1),
        ]);

        $response->assertJson([
            'data' => [
                0 => [
                    'name' => $kathy->name,
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_searches_for_other_users_by_name()
    {
        [$john, $kathy] = User::all()->random(2);

        $response = $this->actingAs($john)->json('GET', self::FIND, [
            'q' => $kathy->name,
        ]);

        $response->assertJson([
            'data' => [
                0 => [
                    'name' => $kathy->name,
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function search_results_do_not_contain_the_actual_user(): void
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)->json('GET', self::FIND, ['q' => $user->email]);

        $response->assertJsonPath('data', []);
    }
}
