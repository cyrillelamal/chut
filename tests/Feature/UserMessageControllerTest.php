<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserMessageControllerTest extends TestCase
{
    use DatabaseTransactions;

    const STORE = '/api/users/%d/messages';

    /**
     * @test
     */
    public function users_must_be_authenticated_to_send_private_messages(): void
    {
        $receiver = User::all()->random();

        $this->json('POST', $this->store($receiver))->assertStatus(401);
    }

    /**
     * @test
     * @dataProvider data
     */
    public function new_message_requires_body(array $data): void
    {
        [$sender, $receiver] = User::all()->random(2);

        unset($data['body']);

        $this->actingAs($sender)->json('POST', $this->store($receiver))->assertStatus(422);
    }

    /**
     * @test
     * @dataProvider data
     */
    public function it_creates_a_new_message(array $data): void
    {
        [$sender, $receiver] = User::all()->random(2);

        $before = Message::query()->count();

        $response = $this->actingAs($sender)->json('POST', $this->store($receiver), $data);

        $response->assertStatus(201);
        $this->assertEquals($before + 1, Message::query()->count());
    }

    /**
     * @test
     * @dataProvider data
     */
    public function it_returns_the_created_message(array $data): void
    {
        [$sender, $receiver] = User::all()->random(2);

        $response = $this->actingAs($sender)->json('POST', $this->store($receiver), $data);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'author' => [
                    'id',
                    'name',
                ],
            ],
        ]);
        $response->assertJson([
            'data' => [
                'body' => $data['body'],
            ],
        ]);
    }

    /**
     * @test
     * @dataProvider data
     */
    public function it_starts_a_new_conversation_if_needed(array $data): void
    {
        $sender = User::all()->random();
        /** @var User $receiver */
        $receiver = User::factory()->create();

        $before = Conversation::query()->count();

        $response = $this->actingAs($sender)->json('POST', $this->store($receiver), $data);

        $response->assertStatus(201);
        $this->assertEquals($before + 1, Conversation::query()->count());
    }

    /**
     * @test
     * @dataProvider data
     */
    public function it_creates_new_participations_if_needed(array $data): void
    {
        $sender = User::all()->random();
        /** @var User $receiver */
        $receiver = User::factory()->create();

        $before = Participation::query()->count();

        $response = $this->actingAs($sender)->json('POST', $this->store($receiver), $data);

        $response->assertStatus(201);
        $this->assertEquals($before + 2, Participation::query()->count());
    }

    public function data(): iterable
    {
        $data = [
            'body' => Str::random(),
        ];

        yield [$data];
    }

    private function store(User $user): string
    {
        return sprintf(self::STORE, $user->id);
    }
}
