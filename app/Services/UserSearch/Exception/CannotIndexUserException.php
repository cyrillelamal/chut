<?php

namespace App\Services\UserSearch\Exception;

use App\Models\User;
use Exception;
use JetBrains\PhpStorm\Pure;

class CannotIndexUserException extends Exception
{
    private User $user;

    #[Pure] public function __construct(User $user, $message = '', $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->user = $user;
    }

    /**
     * Get the user model that could not be indexed.
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
