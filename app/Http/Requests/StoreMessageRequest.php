<?php

namespace App\Http\Requests;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\Pure;

/**
 * @property-read string $body
 * @property-read Conversation $conversation
 * @method User user($guard = null)
 */
class StoreMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('post-to', $this->conversation);
    }

    #[Pure] public function rules(): array
    {
        return [
            'body' => $this->getBodyRules(),
        ];
    }

    #[Pure] protected function getBodyRules(): array
    {
        return [
            'required',
            'string',
            'min:1',
        ];
    }
}
