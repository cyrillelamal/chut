<?php

namespace App\Services\UserSearch;

use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\Pure;

/**
 * Typesense field representation.
 */
class Field implements Arrayable
{
    private string $name;
    private string $type;
    private bool $facet;

    public function __construct(string $name, string $type, bool $facet = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->facet = $facet;
    }

    #[Pure] public function getName(): string
    {
        return $this->name;
    }

    #[Pure] public function getType(): string
    {
        return $this->type;
    }

    #[Pure] public function isFacet(): bool
    {
        return $this->facet;
    }

    /**
     * {@inheritDoc}
     */
    #[Pure] public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'type' => $this->getType(),
            'facet' => $this->isFacet(),
        ];
    }
}
