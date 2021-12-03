<?php

namespace App\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class StartConversationDto extends DataTransferObject
{
    /**
     * @var int[]
     */
    public array $user_ids = [];

    public bool $private = true;

    public ?string $title = null;
}
