<?php

namespace App\Services\UserSearch;

use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\Pure;

/**
 * Typesense user document schema.
 */
class UsersSchema implements Arrayable
{
    private string $name;
    /** @var Field[] */
    private array $fields;

    public function __construct(
        string $name,
        array  $fields,
    )
    {
        $this->name = $name;
        $this->fields = $fields;
    }

    /**
     * Get the schema name.
     */
    #[Pure] public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the schema fields.
     *
     * @return Field[]
     */
    #[Pure] public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'fields' => array_map(fn(Field $field) => $field->toArray(), $this->getFields()),
        ];
    }
}
