<?php

namespace App\Http\Requests;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\Pure;

/**
 * @method User user($guard = null)
 * @property-read Conversation $conversation
 * @property-read string $body
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
