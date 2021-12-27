<?php

namespace App\Providers;

use App\Services\UserSearch\Field;
use App\Services\UserSearch\UsersSchema;
use Illuminate\Support\ServiceProvider;
use RuntimeException;
use Typesense\Client;

class TypesenseProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootClient();
        $this->bootUsersSchema();
    }

    private function bootClient(): void
    {
        $this->app->singleton(Client::class, function () {
            $key = config('typesense.key');

            if (null === $key) {
                throw new RuntimeException('Typesense key is not configured.');
            }

            return new Client([
                'api_key' => config('typesense.key'),
                'nodes' => [
                    [
                        'host' => config('typesense.host'),
                        'port' => config('typesense.port'),
                        'protocol' => config('typesense.protocol'),
                    ]
                ],
                'connection_timeout_seconds' => 2,
            ]);
        });
    }

    private function bootUsersSchema(): void
    {
        $this->app->singleton(UsersSchema::class, function () {
            return new UsersSchema(
                name: 'users',
                fields: [
                    new Field('name', 'string', true),
                    new Field('email', 'string', true),
                ]
            );
        });
    }
}
