<?php

namespace Tests\Unit;

use App\Dtos\StartConversationDto;
use App\Models\Conversation;
use App\Models\Participation;
use App\Models\User;
use App\UseCases\Conversation\StartConversation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class StartConversationTest extends TestCase
{
    use DatabaseTransactions;

    private StartConversationDto $dto;
    private StartConversation $startConversation;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->dto = $this->newDto();

        $this->startConversation = app()->get(StartConversation::class);
    }

    /**
     * @test
     */
    public function it_creates_a_new_conversation(): void
    {
        $before = Conversation::query()->count();

        $conversation = ($this->startConversation)($this->dto);

        $this->assertNotNull($conversation->id);
        $this->assertEquals($before + 1, Conversation::query()->count());
    }

    /**
     * @test
     */
    public function it_creates_conversation_participations(): void
    {
        $users = $this->dto->users;

        $before = Participation::query()->count();

        ($this->startConversation)($this->dto);

        $this->assertEquals($before + count($users), Participation::query()->count());
    }

    /**
     * @test
     */
    public function it_creates_private_conversations(): void
    {
        $conversation = ($this->startConversation)($this->dto);

        $this->assertTrue($conversation->private);
    }

    /**
     * @test
     */
    public function it_creates_public_conversations(): void
    {
        $this->dto->private = false;

        $conversation = ($this->startConversation)($this->dto);

        $this->assertFalse($conversation->private);
    }

    /**
     * @test
     */
    public function it_forces_public_conversations(): void
    {
        $this->dto->users = User::all()->map(fn(User $user) => $user->id)->toArray();
        $this->dto->private = true;

        $conversation = ($this->startConversation)($this->dto);

        $this->assertFalse($conversation->private);
    }

    /**
     * @test
     */
    public function it_does_not_create_conversations_without_participants(): void
    {
        $this->dto->users = [];

        $before = Conversation::query()->count();

        $this->expectException(HttpException::class);
        ($this->startConversation)($this->dto);

        $this->assertEquals($before, Conversation::query()->count());
    }

    /**
     * @test
     */
    public function it_saves_the_provided_title_for_public_conversations(): void
    {
        $this->dto->private = false;
        $this->dto->title = Str::random();

        $conversation = ($this->startConversation)($this->dto);
        $this->assertEquals($this->dto->title, $conversation->title);
    }

    /**
     * @test
     */
    public function it_forces_null_title_for_private_conversations(): void
    {
        $this->dto->private = true;
        $this->dto->title = Str::random();

        $conversation = ($this->startConversation)($this->dto);
        $this->assertNull($conversation->title);
    }

    private function newDto(): StartConversationDto
    {
        $dto = new StartConversationDto();

        $dto->users = User::all()->random(2)->map(fn(User $user) => $user->id)->toArray();
        $dto->private = true;
        $dto->title = null;

        return $dto;
    }
}
