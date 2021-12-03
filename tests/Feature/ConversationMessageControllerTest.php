<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Participation;
use App\Models\User;
use Tests\TestCase;

class ConversationMessageControllerTest extends TestCase
{
    const INDEX = '/api/conversations/%d/messages';

    public function anonymous_users_cannot_see_messages_at_all(): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::query()->inRandomOrder()->first();

        $this->json('GET', $this->index($conversation))
            ->assertStatus(401);
    }

    /**
     * @test
     */
    public function users_cannot_see_messages_of_conversations_they_do_not_participate_in()
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::query()->inRandomOrder()->first();

        /** @var User $malicious */
        $malicious = User::query()
            ->whereNotIn(
                'id',
                $conversation->participations->map(fn(Participation $participation) => $participation->user_id)
            )->inRandomOrder()->first();

        $this->actingAs($malicious)->json('GET', $this->index($conversation))
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function participants_can_see_conversation_messages(): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::query()->inRandomOrder()->first();
        /** @var Participation $participation */
        $participation = $conversation->participations()->inRandomOrder()->first();

        $user = $participation->user;

        $response = $this->actingAs($user)->json('GET', $this->index($conversation));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function conversation_messages_are_readable(): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::query()->inRandomOrder()->first();
        /** @var Participation $participation */
        $participation = $conversation->participations()->inRandomOrder()->first();

        $user = $participation->user;

        $response = $this->actingAs($user)->json('GET', $this->index($conversation));

        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'body',
                    'created_at',
                    'author' => [
                        'id',
                        'name',
                    ],
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function conversation_messages_are_paginated(): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::query()->inRandomOrder()->first();
        /** @var Participation $participation */
        $participation = $conversation->participations()->inRandomOrder()->first();

        $user = $participation->user;

        $response = $this->actingAs($user)->json('GET', $this->index($conversation));

        $response->assertJsonStructure([
            'links' => ['first', 'prev', 'next'],
        ]);
    }

    private function index(Conversation $conversation): string
    {
        return sprintf(self::INDEX, $conversation->id);
    }
}
