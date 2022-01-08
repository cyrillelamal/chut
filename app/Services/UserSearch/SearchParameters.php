<?php

namespace App\Services\UserSearch;

use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\Pure;

/**
 * Typesense additional search parameters.
 * Do not include "q" parameter here.
 */
class SearchParameters implements Arrayable
{
    private array $queryBy;
    private array $facetBy;
    private array $filterBy;
    private int $page;

    /**
     * @param string[] $queryBy The list of fields to query against.
     * @param string[] $facetBy The list of fields that will be used for faceting the results on.
     * @param string[] $filterBy Filter conditions for refining the search results.
     * @param int $page The page number.
     */
    #[Pure] public function __construct(array $queryBy, array $facetBy, array $filterBy = [], int $page = 1)
    {
        $this->queryBy = $queryBy;
        $this->facetBy = $facetBy;
        $this->filterBy = $filterBy;
        $this->page = $page;
    }

    #[Pure] public function toArray(): array
    {
        $parameters = [
            'query_by' => $this->getQueryBy(),
            'facet_by' => $this->getFacetBy(),
        ];

        if (!empty($this->filterBy)) {
            $parameters['filter_by'] = $this->getFilterBy();
        }

        return $parameters;
    }

    /**
     * Get the list of fields that should be queried against.
     *
     * The order of the fields is important:
     * a record that matches on a field earlier in the list is considered
     * more relevant than a record matched on a field later in the list.
     */
    #[Pure] public function getQueryBy(): string
    {
        return join(',', $this->queryBy);
    }

    /**
     * Get the list of fields that will be used for faceting the results on.
     */
    #[Pure] public function getFacetBy(): string
    {
        return join(',', $this->facetBy);
    }

    /**
     * Get filter conditions for refining the search results.
     */
    #[Pure] public function getFilterBy(): string
    {
        return join(' && ', $this->filterBy);
    }

    /**
     * Get the page number.
     *
     * Page numbers start at 1 for the first page.
     */
    public function getPage(): int
    {
        return $this->page;
    }
}
