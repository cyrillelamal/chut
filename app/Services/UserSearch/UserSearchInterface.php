<?php

namespace App\Services\UserSearch;

use App\Models\User;
use App\Services\UserSearch\Exception\CannotCreateCollectionException;
use App\Services\UserSearch\Exception\CannotIndexUserException;
use App\Services\UserSearch\Exception\CannotSearchForUsersException;

interface UserSearchInterface
{
    /**
     * Create a search group of documents.
     *
     * @throws CannotCreateCollectionException
     */
    public function createCollection(): void;

    /**
     * Insert a user document.
     *
     * @param User $user The user to index.
     * @return void
     * @throws CannotIndexUserException
     */
    public function index(User $user): void;

    /**
     * Search for users.
     *
     * @param string $q The searched value.
     * @param SearchParameters|null $parameters Search engine parameters.
     * @return SearchResult
     * @throws CannotSearchForUsersException
     */
    public function search(string $q, ?SearchParameters $parameters = null): SearchResult;

    /**
     * Permanently drop the user collection.
     * This action cannot be undone.
     * For large collections, this might have an impact on read latencies.
     */
    public function dropCollection(): void;
}
