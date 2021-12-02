<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class ConversationControllerTest extends TestCase
{
    use DatabaseTransactions;

    const STORE = '/api/conversations';

    /**
     * @test
     */
    public function users_must_be_authenticated_to_create_a_new_conversation()
    {
        $this->json('POST', self::STORE, [])->assertStatus(401);
    }

    /**
     * @test
     */
    public function users_must_provide_at_least_one_user_id()
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $data = $this->getStoreRequestData();
        $data['users'] = [];

        $response = $this->actingAs($user)->json('POST', self::STORE, $data);
        $response->assertStatus(422);

        $data = $this->getStoreRequestData();
        unset($data['users']);

        $response = $this->actingAs($user)->json('POST', self::STORE, $data);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function initiator_participates_in_the_created_conversation(): void
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();
        $data = $this->getStoreRequestData();

        $response = $this->actingAs($user)->json('POST', self::STORE, $data);

        $id = $response->json('data.id');

        /** @var Conversation $conversation */
        $conversation = Conversation::query()->with('participations')->find($id);

        $this->assertNotNull(
            $conversation->participations->first(fn(Participation $participation) => $participation->user_id === $user->id)
        );
    }

    /**
     * @test
     */
    public function it_returns_the_created_conversation()
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $data = $this->getStoreRequestData();

        $response = $this->actingAs($user)->json('POST', self::STORE, $data);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'created_at',
                'updated_at',
                'private',
            ],
        ]);
    }

    /**
     * @test
     */
    public function users_must_not_provide_title()
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $data = $this->getStoreRequestData();
        unset($data['title']);

        $response = $this->actingAs($user)->json('POST', self::STORE, $data);
        $response->assertStatus(201);
    }

    /**
     * @test
     */
    public function provided_title_is_used()
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $data = $this->getStoreRequestData();

        $response = $this->actingAs($user)->json('POST', self::STORE, $data);
        $response->assertJson([
            'data' => [
                'title' => $data['title'],
            ],
        ]);
    }

    private function getStoreRequestData(): array
    {
        return [
            'users' => User::all()->random(2)->map(fn(User $user) => $user->id)->toArray(),
            'title' => Str::random(),
        ];
    }
}
