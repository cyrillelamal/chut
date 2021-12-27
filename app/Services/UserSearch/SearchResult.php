<?php

namespace App\Services\UserSearch;


use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;

class SearchResult
{
    private array $result;

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

    public function toPaginator(): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            $this->getItems(),
            $this->getTotal(),
            $this->getPerPage(),
            $this->getPage(),
        );
    }

    public function getItems(): Collection
    {
        $hits = collect($this->getResult()['hits']);

        $emails = $hits
            ->map(fn(array $hit) => $hit['document'])
            ->map(fn(array $document) => $document['email']);

        return User::query()->whereIn('email', $emails)->get();
    }

    #[Pure] public function getTotal(): int
    {
        return $this->getResult()['out_of'];
    }

    #[Pure] public function getPerPage(): int
    {
        return $this->getResult()['request_params']['per_page'];
    }

    #[Pure] public function getPage(): int
    {
        return $this->getResult()['page'];
    }
}
