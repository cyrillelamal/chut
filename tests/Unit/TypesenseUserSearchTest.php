<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserSearch\Exception\CannotCreateCollectionException;
use App\Services\UserSearch\Exception\CannotIndexUserException;
use App\Services\UserSearch\Exception\CannotSearchForUsersException;
use App\Services\UserSearch\SearchParameters;
use App\Services\UserSearch\SearchResult;
use App\Services\UserSearch\TypesenseUserSearch;
use App\Services\UserSearch\UserDocument;
use App\Services\UserSearch\UsersSchema;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Typesense\Client;
use Typesense\Collection;
use Typesense\Collections;
use Typesense\Documents;

class TypesenseUserSearchTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @test
     * @throws CannotCreateCollectionException
     */
    public function it_creates_collection(): void
    {
        $client = Mockery::mock(Client::class);
        $schema = Mockery::mock(UsersSchema::class);

        $client->collections = Mockery::mock(Collections::class);

        $schema->shouldReceive('toArray')->atLeast()->once()->andReturn([]);

        $client->collections->shouldReceive('create')->once();

        /** @var TypesenseUserSearch|Mockery\MockInterface $search */
        $search = Mockery::mock(TypesenseUserSearch::class, [$client, $schema])->makePartial();
        $search->createCollection();
    }

    /**
     * @test
     * @dataProvider users
     * @throws CannotIndexUserException
     */
    public function it_index_user(User $user): void
    {
        $name = 'users';

        $client = Mockery::mock(Client::class);
        $schema = Mockery::mock(UsersSchema::class);

        $client->collections = Mockery::mock(Collections::class);
        $collection = Mockery::mock(Collection::class);
        $collection->documents = Mockery::mock(Documents::class);

        $schema->shouldReceive('getName')->once()->andReturn($name);

        $client->collections->shouldReceive('offsetGet')->once()->with($name)->andReturn($collection);
        $collection->documents->shouldReceive('create')->once()->with(UserDocument::createFrom($user)->toArray());

        /** @var TypesenseUserSearch|Mockery\MockInterface $search */
        $search = Mockery::mock(TypesenseUserSearch::class, [$client, $schema])->makePartial();
        $search->index($user);
    }

    /**
     * @test
     * @throws CannotSearchForUsersException
     */
    public function it_searches_for_users_with_default_parameters(): void
    {
        $name = 'users';
        $q = 'foo';

        $client = Mockery::mock(Client::class);
        $schema = Mockery::mock(UsersSchema::class);

        $collection = Mockery::mock(Collection::class);
        $collection->documents = Mockery::mock(Documents::class);

        $client->collections = Mockery::mock(Collections::class);
        $client->collections->shouldReceive('offsetGet')->once()->with($name)->andReturn($collection);

        $schema->shouldReceive('getName')->once()->andReturn($name);

        /** @var TypesenseUserSearch|Mockery\MockInterface $search */
        $search = Mockery::mock(TypesenseUserSearch::class, [$client, $schema])->makePartial();

        $args = array_merge($search->getDefaultSearchParameters()->toArray(), ['q' => $q]);
        $collection->documents->shouldReceive('search')->once()->with($args);

        $search->search($q);
    }

    /**
     * @test
     * @throws CannotSearchForUsersException
     */
    public function it_searches_for_users_with_custom_parameters(): void
    {
        $name = 'users';
        $q = 'foo';
        $parameters = new SearchParameters(['foo', 'bar'], ['foo', 'bar'], page: 2);

        $client = Mockery::mock(Client::class);
        $schema = Mockery::mock(UsersSchema::class);

        $collection = Mockery::mock(Collection::class);
        $collection->documents = Mockery::mock(Documents::class);

        $client->collections = Mockery::mock(Collections::class);
        $client->collections->shouldReceive('offsetGet')->andReturn($collection);

        $schema->shouldReceive('getName')->andReturn($name);

        /** @var TypesenseUserSearch|Mockery\MockInterface $search */
        $search = Mockery::mock(TypesenseUserSearch::class, [$client, $schema])->makePartial();

        $args = array_merge($parameters->toArray(), ['q' => $q]);
        $collection->documents->shouldReceive('search')->once()->with($args);

        $search->search($q, $parameters);
    }

    /**
     * @test
     * @throws CannotSearchForUsersException
     */
    public function it_returns_a_search_result(): void
    {
        $client = Mockery::mock(Client::class);
        $schema = Mockery::mock(UsersSchema::class);
        /** @var TypesenseUserSearch|Mockery\MockInterface $search */
        $search = Mockery::spy(TypesenseUserSearch::class, [$client, $schema]);

        $this->assertInstanceOf(SearchResult::class, $search->search('q'));
    }

    public function users(): iterable
    {
        return [
            [new User(['name' => 'foo', 'email' => 'foo@bar.com'])],
            [new User(['name' => 'bar', 'email' => 'bar@bar.com'])],
            [new User(['name' => 'baz', 'email' => 'baz@bar.com'])],
        ];
    }
}
