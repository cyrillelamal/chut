<?php

namespace App\Services\UserSearch;


use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;

class SearchResult
{
    private array $result;

    private ?Collection $users = null; // Cached result

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * Get original Typesense search result.
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * Wrap the queried result set into a paginator.
     * The result set must provide the information about pagination.
     */
    public function toPaginator(): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            $this->getItems(),
            $this->getTotal(),
            $this->getPerPage(),
            $this->getPage(),
        );
    }

    /**
     * Get the queried users.
     */
    public function getItems(): Collection
    {
        $hits = collect($this->getResult()['hits']);

        $emails = $hits
            ->map(fn(array $hit) => $hit['document'])
            ->map(fn(array $document) => $document['email']);

        // Since this search result can be used in several contexts, we cache it.
        return null === $this->users
            ? $this->users = User::query()->whereIn('email', $emails)->get()
            : $this->users;
    }

    /**
     * Get the total number of user documents.
     */
    #[Pure] public function getTotal(): int
    {
        return $this->getResult()['out_of'];
    }

    /**
     * Get the number of user documents per page.
     */
    #[Pure] public function getPerPage(): int
    {
        return $this->getResult()['request_params']['per_page'];
    }

    /**
     * Get the current page number.
     */
    #[Pure] public function getPage(): int
    {
        return $this->getResult()['page'];
    }
}
