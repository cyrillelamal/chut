<?php

namespace App\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class StartConversationDto extends DataTransferObject
{
    /**
     * User identifiers
     *
     * @var int[]
     */
    public array $users = [];

    public bool $private = true;

    public ?string $title = null;
}
