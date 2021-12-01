<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use DatabaseTransactions;

    const METHOD = 'POST';
    const URI = '/api/logout';

    /**
     * @test
     */
    public function user_session_is_invalidated()
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $this->actingAs($user)->assertAuthenticatedAs($user);

        $this->json(self::METHOD, self::URI);

        $this->assertTrue(Auth::guest());
    }
}
