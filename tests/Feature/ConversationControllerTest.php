<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class ConversationControllerTest extends TestCase
{
    use DatabaseTransactions;

    const STORE = '/api/conversations';
    const UPDATE = self::STORE . '/%d';

    /**
     * @test
     */
    public function users_must_be_authenticated_to_start_a_new_conversation()
    {
        $this->json('POST', self::STORE)->assertStatus(401);
    }

    /**
     * @test
     */
    public function users_must_provide_at_least_one_user_id_to_start_a_new_conversation()
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
    public function initiator_participates_in_the_started_conversation(): void
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)->json('POST', self::STORE, $this->getStoreRequestData());
        $this->assertTrue(
            DB::table('participations')
                ->where('conversation_id', $response->json('data.id'))
                ->where('user_id', $user->id)
                ->exists()
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
    public function users_may_not_provide_title_when_they_start_a_new_conversation()
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

    /**
     * @test
     */
    public function users_can_update_the_title_of_a_public_conversation(): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::query()->inRandomOrder()->where('private', false)->first();
        /** @var Participation $participation */
        $participation = $conversation->participations->random();

        $data = [
            'title' => Str::random(4) . $conversation->title . Str::random(4),
        ];

        $this->actingAs($participation->user)->json('PATCH', $this->update($conversation), $data);

        $conversation->refresh();

        $this->assertEquals($data['title'], $conversation->title);
    }

    private function update(Conversation $conversation): string
    {
        return sprintf(self::UPDATE, $conversation->id);
    }

    private function getStoreRequestData(): array
    {
        return [
            'users' => User::all()->random(2)->map(fn(User $user) => $user->id)->toArray(),
            'title' => Str::random(),
        ];
    }
}
