<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ParticipationControllerTest extends TestCase
{
    use DatabaseTransactions;

    const INDEX = '/api/participations';

    /**
     * @test
     */
    public function users_must_be_authenticated_to_see_their_list_of_participations(): void
    {
        $this->json('GET', self::INDEX)->assertStatus(401);

        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();
        $this->actingAs($user)->json('GET', self::INDEX)->assertStatus(200);
    }

    /**
     * @test
     */
    public function users_can_see_their_participations(): void
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)->json('GET', self::INDEX);

        $response->assertJsonStructure([
            'data' => [],
            'links' => [],
        ]);
    }

    /**
     * @test
     */
    public function listed_participations_have_visible_title(): void
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)->json('GET', self::INDEX);

        $response->assertJsonStructure([
            'data' => [
                0 => ['visible_title'],
            ],
        ]);
    }

    /**
     * @test
     */
    public function listed_participations_have_last_message(): void
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)->json('GET', self::INDEX);

        $response->assertJsonStructure([
            'data' => [
                0 => ['last_available_message'],
            ],
        ]);
    }

//    /**
//     * @test
//     */
//    public function listed_participations_have_link_to_conversation(): void
//    {
//        /** @var User $user */
//        $user = User::query()->inRandomOrder()->first();
//
//        $response = $this->actingAs($user)->json('GET', self::INDEX);
//
//        $response->assertJson(function (AssertableJson $json) {
//            $json->whereType('data.0.conversation', 'string')->etc();
//        });
//    }

    /**
     * @test
     */
    public function listed_participations_are_paginated(): void
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)->json('GET', self::INDEX);

        $response->assertJsonStructure([
            'links' => [
                'first',
                'last',
                'next',
            ]
        ]);
    }
}
