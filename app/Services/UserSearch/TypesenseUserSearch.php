<?php

namespace App\Services\UserSearch;

use App\Models\User;
use App\Services\UserSearch\Exception\CannotCreateCollectionException;
use App\Services\UserSearch\Exception\CannotIndexUserException;
use App\Services\UserSearch\Exception\CannotSearchForUsersException;
use Http\Client\Exception;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\Pure;
use RuntimeException;
use Typesense\Client;
use Typesense\Exceptions\TypesenseClientError;

class TypesenseUserSearch implements UserSearchInterface
{
    private Client $client;
    private UsersSchema $schema;

    public function __construct(
        Client      $client,
        UsersSchema $schema,
    )
    {
        $this->client = $client;
        $this->schema = $schema;
    }

    /**
     * {@inheritDoc}
     */
    public function createCollection(): void
    {
        $schema = $this->getSchema();

        try {
            $this->getClient()->collections->create($schema->toArray());
        } catch (Exception|TypesenseClientError $e) {
            Log::error('Cannot create user collection', ['exception' => $e, 'schema' => $schema]);
            throw new CannotCreateCollectionException('Cannot create user collection', previous: $e);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function index(User $user): void
    {
        $document = UserDocument::createFrom($user);

        try {
            $this->getClient()->collections[$this->getSchemaName()]->documents->create($document->toArray());
        } catch (Exception|TypesenseClientError $e) {
            Log::error('Cannot index user', ['exception' => $e, 'document' => $document]);
            throw new CannotIndexUserException($user, 'Cannot index user', previous: $e);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function search(string $q, SearchParameters $parameters = null): SearchResult
    {
        $parameters = $parameters ?? $this->getDefaultSearchParameters();

        $parameters = array_merge($parameters->toArray(), ['q' => $q]);

        try {
            $result = $this->getClient()->collections[$this->getSchemaName()]->documents->search($parameters);
            return new SearchResult($result);
        } catch (Exception|TypesenseClientError $e) {
            Log::error('Cannot search for users', ['exception' => $e, 'parameters' => $parameters]);
            throw new CannotSearchForUsersException($parameters, 'Cannot search for users', previous: $e);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function dropCollection(): void
    {
        try {
            $this->getClient()->collections[$this->getSchemaName()]->delete();
        } catch (Exception|TypesenseClientError $e) {
            Log::error('Cannot drop user collection', ['exception' => $e]);
            throw new RuntimeException('Cannot drop user collection', previous: $e);
        }
    }

    #[Pure] public function getDefaultSearchParameters(): SearchParameters
    {
        return new SearchParameters(
            ['name', 'email'],
            ['name', 'email'],
        );
    }

    #[Pure] protected function getSchemaName(): string
    {
        return $this->getSchema()->getName();
    }

    #[Pure] protected function getClient(): Client
    {
        return $this->client;
    }

    #[Pure] protected function getSchema(): UsersSchema
    {
        return $this->schema;
    }
}
