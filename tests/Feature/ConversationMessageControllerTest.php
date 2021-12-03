<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class ConversationMessageControllerTest extends TestCase
{
    use DatabaseTransactions;

    const INDEX = '/api/conversations/%d/messages';
    const STORE = self::INDEX;

    /**
     * @test
     */
    public function users_must_be_authenticated_to_see_their_messages(): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::query()->inRandomOrder()->first();

        $this->json('GET', $this->index($conversation))->assertStatus(401);
    }

    /**
     * @test
     */
    public function only_participants_of_the_conversation_can_see_its_messages()
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::query()->inRandomOrder()->first();

        /** @var User $erroneous */
        $erroneous = User::factory()->create();

        $this->actingAs($erroneous)->json('GET', $this->index($conversation))->assertStatus(403);
    }

    /**
     * @test
     */
    public function participants_can_see_messages_of_the_conversation(): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::query()->inRandomOrder()->first();
        /** @var Participation $participation */
        $participation = $conversation->participations->random();

        $user = $participation->user;

        $response = $this->actingAs($user)->json('GET', $this->index($conversation));
        $response->assertStatus(200);
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
    public function users_must_be_authenticated_to_post_new_messages(): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::all()->random();

        $this->json('POST', $this->store($conversation))->assertStatus(401);
    }

    /**
     * @test
     */
    public function only_participants_of_the_conversation_can_post_to(): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::all()->random();
        /** @var User $erroneous */
        $erroneous = User::factory()->create();

        $this->actingAs($erroneous)->json('POST', $this->store($conversation))->assertStatus(403);
    }

    /**
     * @test
     * @dataProvider data
     */
    public function new_messages_are_created(array $data): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::all()->random();
        /** @var Participation $participation */
        $participation = $conversation->participations->random();

        $before = Message::query()->count();

        $response = $this->actingAs($participation->user)->json('POST', $this->store($conversation), $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'created_at',
                'author' => [
                    'id',
                    'name',
                ]
            ],
        ]);
        $this->assertEquals($before + 1, Message::query()->count());
    }

    /**
     * @test
     * @dataProvider data
     */
    public function new_messages_require_body(array $data): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::all()->random();
        /** @var Participation $participation */
        $participation = $conversation->participations->random();

        unset($data['body']);

        $response = $this->actingAs($participation->user)->json('POST', $this->store($conversation), $data);
        $response->assertStatus(422);
    }

    /**
     * @test
     * @dataProvider data
     */
    public function participations_are_updated_when_new_message_is_posted(array $data): void
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::all()->random();
        /** @var Participation $participation */
        $participation = $conversation->participations->random();

        $response = $this->actingAs($participation->user)->json('POST', $this->store($conversation), $data);

        $created = Message::query()->find($response->json('data.id'));

        $this->assertTrue($created->isNot($participation->last_available_message));
        $participation->refresh();
        $this->assertTrue($created->is($participation->last_available_message));
    }

    public function data(): iterable
    {
        $data = [
            'body' => Str::random()
        ];

        yield [$data];
    }

    private function index(Conversation $conversation): string
    {
        return sprintf(self::INDEX, $conversation->id);
    }

    private function store(Conversation $conversation): string
    {
        return sprintf(self::INDEX, $conversation->id);
    }
}
