<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    const METHOD = 'POST';
    const URI = '/api/login';

    /**
     * @test
     */
    public function client_must_provide_email(): void
    {
        $credentials = $this->getValidCredentials();
        unset($credentials['email']);

        $response = $this->json(self::METHOD, self::URI, $credentials);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function client_must_provide_password(): void
    {
        $credentials = $this->getValidCredentials();
        unset($credentials['password']);

        $response = $this->json(self::METHOD, self::URI, $credentials);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function client_must_provide_device_name(): void
    {
        $credentials = $this->getValidCredentials();
        unset($credentials['device_name']);

        $response = $this->json(self::METHOD, self::URI, $credentials);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function client_must_provide_valid_credentials(): void
    {
        $credentials = $this->getValidCredentials();
        $credentials['password'] = Str::random(8);

        $response = $this->json(self::METHOD, self::URI, $credentials);

        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function it_returns_access_token_after_authentication(): void
    {
        $credentials = $this->getValidCredentials();

        $response = $this->json(self::METHOD, self::URI, $credentials);

        $response->assertJsonStructure([
            'data' => ['token']
        ]);
    }

    private function getValidCredentials(): array
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        return [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'Foo',
        ];
    }
}
