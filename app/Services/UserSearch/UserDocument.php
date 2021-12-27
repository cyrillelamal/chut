<?php

namespace App\Services\UserSearch;

use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\Pure;

/**
 * Typeset user document used while indexation and inserting.
 */
class UserDocument implements Arrayable
{
    private string $name;
    private string $email;

    #[Pure] public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Create a new user document from a user model.
     * @param User $user
     * @return $this
     */
    #[Pure] public static function createFrom(User $user): self
    {
        return new self(
            $user->name,
            $user->email,
        );
    }

    #[Pure] public function getName(): string
    {
        return $this->name;
    }

    #[Pure] public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * {@inheritDoc}
     */
    #[Pure] public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'email' => $this->getEmail(),
        ];
    }
}
