<?php

namespace App\Services\UserSearch\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class CannotSearchForUsersException extends Exception
{
    private array $parameters;

    #[Pure] public function __construct(array $parameters, $message = '', $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->parameters = $parameters;
    }

    /**
     * Get search parameters.
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
