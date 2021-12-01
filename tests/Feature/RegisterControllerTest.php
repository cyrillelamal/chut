<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use DatabaseTransactions;

    const METHOD = 'POST';
    const URI = '/api/register';

    /**
     * @test
     */
    public function client_must_provide_email(): void
    {
        $credentials = $this->credentials();
        unset($credentials['email']);

        $response = $this->json(self::METHOD, self::URI, $credentials);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function client_must_provide_password(): void
    {
        $credentials = $this->credentials();
        unset($credentials['password']);

        $response = $this->json(self::METHOD, self::URI, $credentials);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function client_must_provide_name(): void
    {
        $credentials = $this->credentials();
        unset($credentials['name']);

        $response = $this->json(self::METHOD, self::URI, $credentials);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_creates_a_new_user_model(): void
    {
        $before = User::query()->count();

        $this->json(self::METHOD, self::URI, $this->credentials());

        $this->assertEquals($before + 1, User::query()->count());
    }

    public function credentials(): array
    {
        return [
            'email' => 'mail' . Str::random() . '@mail.com',
            'password' => Str::random(),
            'name' => 'John',
        ];
    }
}
